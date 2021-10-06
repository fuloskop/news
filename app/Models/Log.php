<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','role_type','message','status','ip','user_agent'];

    public function User()
    {// 'App\Models\User'
        return $this->belongsTo(User::class);
    }
}
