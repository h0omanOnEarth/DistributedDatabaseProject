<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Htrans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function konfirmasiOrder($kode){
        $htrans = Htrans::where('kode', $kode)->first();
        $htrans->status = "done";
        $htrans->save();
        DB::raw('commit;');
        return back();
    }

    public function bayarOrder($kode){
        $htrans = Htrans::where('kode', $kode)->first();
        $htrans->status = "delivery";
        $htrans->save();
        DB::raw('commit;');

        return back();
    }
}
