<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Info extends Model
{
    use HasFactory;
    protected $fillables = [
        'phone',
        'email',
        'adress'
    ];
}
