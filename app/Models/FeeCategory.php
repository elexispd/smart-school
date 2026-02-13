<?php

namespace App\Models;

use App\Traits\{HasUuid, BelongsToSchool};
use Illuminate\Database\Eloquent\Model;

class FeeCategory extends Model
{
    use HasUuid, BelongsToSchool;

    protected $guarded = ['id'];
    protected $casts = ['is_active' => 'boolean'];

    public function feeStructures()
    {
        return $this->hasMany(FeeStructure::class);
    }
}
