<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'alias',
        'description',
    ];

    /**
     * Optionally cast price to decimal
     */
    protected $casts = [
        'price' => 'decimal:2',
    ];
}

