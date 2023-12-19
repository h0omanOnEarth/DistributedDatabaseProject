<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengiriman;
use App\Models\Pengirimans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        DB::raw('commit;');

        $pengirimanData = Pengirimans::all();
        return response()->json(['success' => 'Pengiriman added successfully.', 'pengirimanData' => $pengirimanData]);
    }

    public function edit($id)
    {
        // Fetch the Pengiriman data by ID
        $pengiriman = Pengirimans::find($id);

        if (!$pengiriman) {
            return response()->json(['error' => 'Pengiriman not found.'], 404);
        }

        return response()->json($pengiriman);
    }

    public function update(Request $request, $id)
    {
        // Validation
        $request->validate([
            'lokasi' => 'required',
            'estimasi' => 'required|numeric',
        ]);

        // Find the Pengiriman by ID
        $pengiriman = Pengirimans::find($id);

        if (!$pengiriman) {
            return response()->json(['error' => 'Pengiriman not found.'], 404);
        }

        // Update the Pengiriman data
        $pengiriman->update([
            'lokasi' => $request->lokasi,
            'estimasi' => $request->estimasi,
        ]);
        DB::raw('commit;');

        // Return success response
        $pengirimanData = Pengirimans::all();
        return response()->json(['success' => 'Pengiriman updated successfully.', 'pengirimanData' => $pengirimanData]);
    }

    public function destroy($id)
    {
        // Delete record
        Pengirimans::findOrFail($id)->delete();
        DB::raw('commit;');
        $pengirimanData = Pengirimans::all();
        return response()->json(['success' => 'Pengiriman deleted successfully.', 'pengirimanData' => $pengirimanData]);
    }
}
