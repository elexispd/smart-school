<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class School extends Model
{
    use HasUuid, LogsActivity;
    protected $guarded = [];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'phone', 'address', 'is_active', 'subscription_plan'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('saas')
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => "School '{$this->name}' was created",
                'updated' => "School '{$this->name}' was updated",
                'deleted' => "School '{$this->name}' was deleted",
                default => "{$eventName} on school"
            });
    }

    protected static function bootLogsActivity()
    {
        static::updated(function ($model) {
            if ($model->isDirty()) {
                activity('saas')
                    ->performedOn($model)
                    ->causedBy(auth()->user())
                    ->withProperties([
                        'attributes' => $model->getChanges(),
                        'old' => array_intersect_key($model->getOriginal(), $model->getChanges()),
                        'school_id' => null
                    ])
                    ->log("School '{$model->name}' was updated");
            }
        });

        static::created(function ($model) {
            activity('saas')
                ->performedOn($model)
                ->causedBy(auth()->user())
                ->withProperties([
                    'attributes' => $model->getAttributes(),
                    'school_id' => null
                ])
                ->log("School '{$model->name}' was created");
        });
    }
}
