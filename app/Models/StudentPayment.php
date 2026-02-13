<?php

namespace App\Models;

use App\Traits\{HasUuid, BelongsToSchool};
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class StudentPayment extends Model
{
    use HasUuid, BelongsToSchool, LogsActivity;

    protected $guarded = ['id'];
    protected $casts = ['amount' => 'decimal:2', 'payment_date' => 'date'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['student_id', 'fee_structure_id', 'amount', 'payment_method', 'payment_date'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('school');
    }

    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            activity('school')
                ->performedOn($model)
                ->causedBy(auth()->user())
                ->withProperties(['attributes' => $model->getAttributes()])
                ->tap(function ($activity) use ($model) {
                    $activity->school_id = $model->school_id;
                })
                ->log('Recorded student payment');
        });

        static::deleted(function ($model) {
            activity('school')
                ->performedOn($model)
                ->causedBy(auth()->user())
                ->tap(function ($activity) use ($model) {
                    $activity->school_id = $model->school_id;
                })
                ->log('Deleted student payment');
        });
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function feeStructure()
    {
        return $this->belongsTo(FeeStructure::class);
    }

    public function feeInstallment()
    {
        return $this->belongsTo(FeeInstallment::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
