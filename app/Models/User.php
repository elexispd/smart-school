<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuid, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'school_id',
        'role',
        'avatar',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function staff()
    {
        return $this->hasOne(Staff::class, 'user_id');
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'user_id');
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function hasPermission($permission)
    {
        if ($this->role === 'super_admin') return true;
        
        $role = \Spatie\Permission\Models\Role::where('name', $this->role)->first();
        if (!$role) return false;
        return $role->permissions()->where('name', $permission)->exists();
    }

    protected static function booted()
    {
        static::addGlobalScope('school', function ($builder) {
            if (auth()->hasUser()) {
                $user = auth()->user();
                if ($user->role !== 'super_admin' && $user->school_id) {
                    $builder->where('school_id', $user->school_id);
                }
            }
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'role', 'school_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName($this->school_id ? 'school' : 'saas')
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => "User '{$this->name}' was created",
                'updated' => "User '{$this->name}' was updated",
                'deleted' => "User '{$this->name}' was deleted",
                default => "{$eventName} on user"
            });
    }

    protected static function bootLogsActivity()
    {
        static::updated(function ($model) {
            if ($model->isDirty()) {
                $causer = auth()->user();
                $logName = ($causer && !$causer->school_id) ? 'saas' : 'school';
                
                activity($logName)
                    ->performedOn($model)
                    ->causedBy($causer)
                    ->withProperties([
                        'attributes' => $model->getChanges(),
                        'old' => array_intersect_key($model->getOriginal(), $model->getChanges()),
                        'school_id' => $model->school_id
                    ])
                    ->tap(function ($activity) use ($model) {
                        $activity->school_id = $model->school_id;
                    })
                    ->log("User '{$model->name}' was updated");
            }
        });

        static::created(function ($model) {
            $causer = auth()->user();
            $logName = ($causer && !$causer->school_id) ? 'saas' : 'school';
            
            activity($logName)
                ->performedOn($model)
                ->causedBy($causer)
                ->withProperties([
                    'attributes' => $model->getAttributes(),
                    'school_id' => $model->school_id
                ])
                ->tap(function ($activity) use ($model) {
                    $activity->school_id = $model->school_id;
                })
                ->log("User '{$model->name}' was created");
        });
    }
}
