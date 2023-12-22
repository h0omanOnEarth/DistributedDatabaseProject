<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $raw = DB::select("SELECT OBJECT_NAME, TIMESTAMP, SQL_TEXT, STATEMENT_TYPE FROM DBA_FGA_AUDIT_TRAIL WHERE OBJECT_NAME IN ('CART', 'PRODUCTS', 'DTRANS', 'HTRANS', 'PENGIRIMANS', 'USERS')");
        return view('screens.admin.manage_logs', ["user" => $user, "raw" => $raw]);
    }

    public function manualLog()
    {
        $user = Auth::user();

        // Fetch data from productsLog using Eloquent
        $productLogs = ProductLog::all();

        return view('screens.admin.manage_manualLog', [  // Updated view name
            "user" => $user,
            "productLogs" => $productLogs,  // Updated variable name
        ]);
    }
}
