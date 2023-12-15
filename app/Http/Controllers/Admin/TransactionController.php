<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Htrans;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function transactionsPage()
    {
        $user = Auth::user();
        dd($user);
        // return view('screens.admin.manage_transactions', ["user" => $user]);
    }
}
