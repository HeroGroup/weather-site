<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DegreeDayPest extends Model
{
    use HasFactory;
    protected $fillable = ['station_id', 'pest_id', 'start_date'];

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function pest()
    {
        return $this->belongsTo(Pest::class);
    }
}
