<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $fillable = [
        'uuid',
        'data',
        'key'
    ];

    public $casts = [
        'data' => 'array'
    ];
}
