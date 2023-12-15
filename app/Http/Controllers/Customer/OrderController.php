<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Htrans;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function konfirmasiOrder($kode){
        $htrans = Htrans::where('kode', $kode)->first();
        $htrans->status = "done";
        $htrans->save();

        return back();
    }
}
