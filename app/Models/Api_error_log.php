<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Api_error_log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'lebel',
        'status'
    ];
}