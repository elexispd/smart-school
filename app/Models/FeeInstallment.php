<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class FeeInstallment extends Model
{
    use HasUuid;

    protected $guarded = ['id'];
    protected $casts = ['percentage' => 'decimal:2', 'due_date' => 'date'];

    public function feeStructure()
    {
        return $this->belongsTo(FeeStructure::class);
    }
}
