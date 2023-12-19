<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        /**
     * Run the migrations.
     */
    public function up(): void
    {
        // $viewName = 'products_view_c';
        // $selectQuery = DB::connection('oracle_c')->table('products')->select('*')->toSql();

        // DB::connection('oracle')->statement("CREATE MATERIALIZED VIEW $viewName AS $selectQuery");
        // DB::connection('oracle')->statement("CREATE MATERIALIZED VIEW LOG ON $viewName");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //  DB::connection('oracle')->statement("DROP MATERIALIZED VIEW IF EXISTS products_view_c");
    }
};
