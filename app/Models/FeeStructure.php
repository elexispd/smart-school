<?php

namespace App\Models;

use App\Traits\{HasUuid, BelongsToSchool};
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FeeStructure extends Model
{
    use HasUuid, BelongsToSchool, LogsActivity;

    protected $guarded = ['id'];
    protected $casts = ['is_active' => 'boolean', 'amount' => 'decimal:2'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['fee_category_id', 'session_id', 'term', 'class_id', 'class_arm_id', 'amount', 'payment_type', 'is_active'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('school');
    }

    protected static function bootLogsActivity()
    {
        static::updated(function ($model) {
            if ($model->isDirty()) {
                activity('school')
                    ->performedOn($model)
                    ->causedBy(auth()->user())
                    ->withProperties([
                        'attributes' => $model->getChanges(),
                        'old' => array_intersect_key($model->getOriginal(), $model->getChanges()),
                    ])
                    ->tap(function ($activity) use ($model) {
                        $activity->school_id = $model->school_id;
                    })
                    ->log('Updated fee schedule');
            }
        });

        static::created(function ($model) {
            activity('school')
                ->performedOn($model)
                ->causedBy(auth()->user())
                ->withProperties(['attributes' => $model->getAttributes()])
                ->tap(function ($activity) use ($model) {
                    $activity->school_id = $model->school_id;
                })
                ->log('Created fee schedule');
        });

        static::deleted(function ($model) {
            activity('school')
                ->performedOn($model)
                ->causedBy(auth()->user())
                ->tap(function ($activity) use ($model) {
                    $activity->school_id = $model->school_id;
                })
                ->log('Deleted fee schedule');
        });
    }

    public function feeCategory()
    {
        return $this->belongsTo(FeeCategory::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function classArm()
    {
        return $this->belongsTo(ClassArm::class);
    }

    public function installments()
    {
        return $this->hasMany(FeeInstallment::class)->orderBy('order');
    }
}
