<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;


class Vehicle extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'vehicles';

    protected $fillable = [
        'manufactured_at', 'color', 'price', 'type', 'detailedInfo', 'stock'
    ];
}
