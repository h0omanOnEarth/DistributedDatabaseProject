<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengiriman;
use App\Models\Pengirimans;
use Illuminate\Support\Facades\Auth;

class PengirimanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pengirimanData = Pengirimans::all();
        return view('screens.seller.master_locations', ['user' => $user, 'pengirimanData' => $pengirimanData,]);
    }

    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'lokasi' => 'required',
            'estimasi' => 'required|numeric',
        ]);

        // Create new record
        Pengirimans::create([
            'lokasi' => $request->lokasi,
            'estimasi' => $request->estimasi,
        ]);

        $pengirimanData = Pengirimans::all();
        return response()->json(['success' => 'Pengiriman added successfully.', 'pengirimanData' => $pengirimanData]);
    }

    public function update(Request $request, $id)
    {
        // Validation
        $request->validate([
            'lokasi' => 'required',
            'estimasi' => 'required|numeric',
        ]);

        // Update record
        $pengiriman = Pengirimans::findOrFail($id);
        $pengiriman->update([
            'lokasi' => $request->lokasi,
            'estimasi' => $request->estimasi,
        ]);

        return response()->json(['success' => 'Pengiriman updated successfully.']);
    }

    public function destroy($id)
    {
        // Delete record
        Pengirimans::findOrFail($id)->delete();

        return response()->json(['success' => 'Pengiriman deleted successfully.']);
    }
}
