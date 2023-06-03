<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\News_category;
use App\Models\News_author;


class News_source extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lebel',
        'status'
    ];

    public function category(){
        return $this->hasOne(User_source_setting::class, 'id', 'user_id');
    }

    public function author(){
        return $this->hasOne(User_author_setting::class, 'id', 'user_id');
    }
}