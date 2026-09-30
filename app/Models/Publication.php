<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/** @property Carbon|null $published_at */
class Publication extends Model
{
    protected $fillable = ['title', 'slug', 'type', 'summary', 'body', 'status', 'published_at', 'editor_id'];

    protected function casts(): array
    {
        return ['published_at' => 'datetime'];
    }
}
