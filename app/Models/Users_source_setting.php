<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users_source_setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'lebel',
        'status'
    ];
}