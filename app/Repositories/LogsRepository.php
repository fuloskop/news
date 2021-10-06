<?php

namespace App\Repositories;

use App\Models\Log;

class LogsRepository
{
    public function store($message, $status)
    {
        $ip = request()->getClientIp();
        $agent = request()->userAgent();
        $user = auth()->user();
        Log::create([
            'user_id' => $user->id,
            'message' => $message,
            'status' => $status,
            'ip' => $ip,
            'user_agent' => $agent,
        ]);
    }
}
