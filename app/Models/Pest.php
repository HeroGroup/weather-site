<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pest extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'base_temperature',
        'max_temperature',
        'total_temperature',
        'description'
    ];
}
