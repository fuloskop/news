<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApiTokenController extends Controller
{

    public function getToken(Request $request)
    {
        if ($request->input('email') && $request->input('password')) {
            if (Auth::attempt($request->only('email', 'password'))) {
                $apiToken = Hash::make(md5(sha1(Auth::user()->created_at, Str::random(60))));
                $user = User::find(Auth::id());
                $user->update(['api_token' => $apiToken]);
                return response()->json(['status' => 'login success.', 'token' => $apiToken], 200, []);
            } else {
                return response()->json(['status' => 'login failed.'], 401, []);
            }
        } else {
            return response()->json(['status' => 'email and password needed.'], 400, []);
        }
    }
}
