<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationScan extends Model
{
    protected $fillable = ['product_unit_id', 'visitor_hash'];

    protected function casts(): array
    {
        return [];
    }
}
