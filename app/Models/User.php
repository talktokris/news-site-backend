<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// use App\Models\User_authors_setting;
// use App\Models\User_category_setting;
// use App\Models\User_source_setting;


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
        return $this->hasMany(Users_category_setting::class, 'user_id', 'id');
       // return $this->hasOne(Country::class, 'foreign_key', 'local_key');
     }
     public function source(){
         return $this->hasMany(Users_source_setting::class, 'user_id', 'id');
     }

     public function author(){
        return $this->hasMany(Users_authors_setting::class, 'user_id', 'id');
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