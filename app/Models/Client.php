<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $casts = [
        'phone' => 'array'
    ];


    protected $fillable = [
        'name',
        'mobile',
        'second_mobile',
        'address',
    ];
}
