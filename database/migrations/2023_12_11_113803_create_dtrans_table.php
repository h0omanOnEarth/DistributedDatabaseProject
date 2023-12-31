<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dtrans', function (Blueprint $table) {
            $table->id();
            $table->string('htrans_kode');
            $table->foreign('htrans_kode', 'fk_dtrans_to_htrans')->references('kode')->on('htrans')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreignId('products_id')->constrained();
            $table->integer('qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dtrans');
    }
};
