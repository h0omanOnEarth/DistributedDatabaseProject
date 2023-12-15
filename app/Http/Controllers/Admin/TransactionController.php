<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function transactionsPage()
    {
        $user = Auth::user();
        $users = User::get();
        return view('screens.admin.manage_transactions', ["user" => $user, "items" => $users]);
    }
}
