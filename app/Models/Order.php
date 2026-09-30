<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $attributes = ['status' => 'pending', 'payment_status' => 'unpaid', 'currency' => 'TZS'];

    protected $fillable = ['number', 'user_id', 'checkout_key', 'status', 'payment_status', 'payment_reference', 'subtotal', 'shipping_fee', 'total', 'currency', 'shipping_address', 'notes', 'tracking_reference', 'paid_at'];

    protected function casts(): array
    {
        return ['subtotal' => 'integer', 'shipping_fee' => 'integer', 'total' => 'integer', 'shipping_address' => 'array', 'paid_at' => 'datetime'];
    }

    /** @return HasMany<OrderItem, $this> */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
