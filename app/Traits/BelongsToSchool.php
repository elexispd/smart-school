<?php

namespace App\Traits;

use App\Models\School;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToSchool
{
    protected static function bootBelongsToSchool()
    {
        static::addGlobalScope('school', function (Builder $builder) {
            if (auth()->check()) {
                $user = auth()->user();
                // Ensure we don't access role if user is not fully loaded or different structure
                if (isset($user->role) && $user->role !== 'super_admin' && $user->school_id) {
                    $builder->where('school_id', $user->school_id);
                }
            }
        });

        static::creating(function ($model) {
            if (auth()->check() && auth()->user()->school_id) {
                $model->school_id = auth()->user()->school_id;
            }
        });
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
