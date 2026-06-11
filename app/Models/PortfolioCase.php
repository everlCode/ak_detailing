<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioCase extends Model
{
    protected $fillable = [
        'slug',
        'car_make',
        'car_model',

        'service_id',
        'description',
        'meta_description',
        'views',
    ];

    public function getTitleAttribute(): string
    {
        $parts = array_filter([$this->car_make, $this->car_model]);
        $title = implode(' ', $parts);
        if ($this->relationLoaded('service') && $this->service) {
            $title .= ' — ' . $this->service->name;
        }
        return $title;
    }

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
