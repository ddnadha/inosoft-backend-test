<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

// use Illuminate\Database\Eloquent\Model;

class Transact extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'transactions';

    protected $fillable = [
        'name', 'price', 'items',
    ];
}
