<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeleteAccountRequest extends Model
{
    use HasFactory;

    protected $table = 'delete_account_requests';

    protected $fillable = ['user_id', 'body', 'request_status', 'answer'];

    public function User()
    {// 'App\Models\User'
        return $this->belongsTo(User::class);
    }

}
