<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    use HasFactory;


public function station()
{
return $this->belongsTo(Station::class);
} 

public function province()
{
return $this->belongsTo(Province::class, 'province_id', 'id');
}

    public function city()
    {
    return $this->belongsTo(City::class);
    }
}
