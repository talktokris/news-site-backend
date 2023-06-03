<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\User_author_setting;
use App\Models\User_category_setting;
use App\Models\User_source_setting;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function category(){
        return $this->hasOne(User_category_setting::class, 'id', 'user_id');
       // return $this->hasOne(Country::class, 'foreign_key', 'local_key');
     }
     public function source(){
         return $this->hasOne(User_source_setting::class, 'id', 'user_id');
     }

     public function author(){
        return $this->hasOne(User_author_setting::class, 'id', 'user_id');
    }



    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



 
}