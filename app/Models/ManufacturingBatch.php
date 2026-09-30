<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property Carbon $manufactured_on
 * @property Carbon|null $expires_on
 */
class ManufacturingBatch extends Model
{
    protected $fillable = ['product_id', 'code', 'manufactured_on', 'expires_on', 'status', 'quality_notes'];

    protected function casts(): array
    {
        return ['manufactured_on' => 'date', 'expires_on' => 'date'];
    }

    /** @return BelongsTo<Product, $this> */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
