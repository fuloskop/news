<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function getAdminPanel()
    {
        return view('frontend.AdminPanel.AdminPanel');
    }

    public function changeRoles()
    {
        $users = User::all();
        return view('frontend.AdminPanel.AdminRoles',compact('users'));
    }

    public function updateRoles(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'added' => 'required|boolean',
            'roletype' => 'required|in:admin,moderator,editor',
        ]);

        $result = ['status' => 200];
        try {
            $user = User::findOrFail($request->user_id);
            if ($request->added==1) {
                $user->assignRole($request->roletype);
            } else {
                $user->removeRole($request->roletype);
            }
        }catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
                'test'=>$request->all()
            ];
        }

        return response()->json($result,$result['status']);
    }
}
