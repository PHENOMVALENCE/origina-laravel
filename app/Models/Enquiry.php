<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $fillable = ['name', 'email', 'topic', 'message', 'status', 'consented_at'];

    protected function casts(): array
    {
        return ['consented_at' => 'datetime'];
    }
}
