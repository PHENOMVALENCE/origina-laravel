<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'slug', 'sku', 'division', 'description', 'ingredients', 'usage', 'evidence_note', 'image_path', 'price', 'stock', 'published'];

    protected function casts(): array
    {
        return ['price' => 'integer', 'stock' => 'integer', 'published' => 'boolean'];
    }
}
