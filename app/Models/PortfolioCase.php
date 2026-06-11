<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioCase extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'car_make',
        'car_model',
        'car_year',
        'service_id',
        'description',
        'meta_description',
        'views',
    ];

    protected $casts = [
        'views' => 'integer',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'reference_id')
            ->where('type', 'portfolio_case')
            ->orderBy('id');
    }

    public function mainImage()
    {
        return $this->hasOne(Image::class, 'reference_id')
            ->where('type', 'portfolio_case')
            ->orderBy('id');
    }
}
