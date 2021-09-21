<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;
    protected $fillable = [
        'city_id',
        'device_code',
        'device_type',
        'device_title',
        'serial_number',
        'mobile_number',
        'communication_type',
        'sea_level',
        'IP',
        'latitude',
        'longitude',
        'last_online',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
