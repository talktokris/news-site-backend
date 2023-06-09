<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users_authors_setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'lebel',
        'status'
    ];


    public function getUserInfo(){

        return $this->belongsTo(User::class, 'user_id', 'id');

    }
}