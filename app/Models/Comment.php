<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','news_id','body','is_hidden'];

    public function User()
    {// 'App\Models\User'
        return $this->belongsTo(User::class, 'user_id');
    }

    public function News()
    {// 'App\Models\News'
        return $this->belongsTo(News::class, 'news_id');
    }
}
