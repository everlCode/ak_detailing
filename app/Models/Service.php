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
        'short_description',
    ];

    /**
     * Optionally cast price to decimal
     */
    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Связь на главное изображение
    public function mainImage()
    {
        return $this->hasOne(\App\Models\Image::class, 'reference_id')->where('type', 'main');
    }

    // Связь на примеры (примерные изображения)
    public function exampleImages()
    {
        return $this->hasMany(\App\Models\Image::class, 'reference_id')->where('type', 'example');
    }
}
