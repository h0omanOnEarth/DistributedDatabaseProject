<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function usersPage()
    {
        $user = Auth::user();
        $users = User::get();
        return view('screens.admin.manage_users', ["user" => $user, "items" => $users]);
    }

    public function blockUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Pengguna tidak ditemukan'], 404);
        }

        if ($user->status == 1) {
            $user->status = 0;
            $message = 'User successfully blocked!';
        } elseif ($user->status == 0) {
            $user->status = 1;
            $message = 'User successfully unblocked!';
        }
        $user->save();
        return back()->with('success', $message);
    }
}
