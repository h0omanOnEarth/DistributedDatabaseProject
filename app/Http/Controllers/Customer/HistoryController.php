<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Htrans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function gotohistory()
    {
        $user = Auth::user();
        $htrans = Htrans::where('users_id', $user->id)->get();
        return view('screens.customer.history', ["user" => $user, "htrans" => $htrans]);
    }
}
