<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author_list extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'news_source_id',
        'lebel',
        'status'
    ];
}