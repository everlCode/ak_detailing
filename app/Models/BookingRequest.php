<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingRequest extends Model
{
    protected $table = 'booking_requests';

    protected $fillable = [
        'name',
        'service_id',
        'phone',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
