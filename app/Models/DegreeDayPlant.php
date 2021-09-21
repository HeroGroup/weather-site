<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DegreeDayPlant extends Model
{
    use HasFactory;
    protected $fillable = ['station_id', 'plant_id', 'start_date'];

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }
}
