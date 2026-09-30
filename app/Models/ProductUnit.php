<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductUnit extends Model
{
    protected $fillable = ['manufacturing_batch_id', 'serial', 'verification_token', 'status'];

    protected function casts(): array
    {
        return [];
    }

    protected $hidden = ['verification_token'];

    /** @return BelongsTo<ManufacturingBatch, $this> */
    public function batch(): BelongsTo
    {
        return $this->belongsTo(ManufacturingBatch::class, 'manufacturing_batch_id');
    }
}
