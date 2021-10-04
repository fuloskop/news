<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['author_id','category_id','title','body','published_at'];

    public function Author()
    {// 'App\Models\Quiz'
        return $this->belongsTo(User::class, 'author_id');
    }
}
