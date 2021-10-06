<?php

namespace App\Repositories;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class LogsRepository
{
    public function store($message, $status)
    {
        $ip = request()->getClientIp();
        $agent = request()->userAgent();
        $user = auth()->user();
        //$role = Role::where('user_id', $user->id)->first();
        Log::create([
            'user_id' => $user->id,
            'role_type' => getRoleTypeByUserId($user->id),
            'message' => $message,
            'status' => $status,
            'ip' => $ip,
            'user_agent' => $agent,
        ]);
    }
}
