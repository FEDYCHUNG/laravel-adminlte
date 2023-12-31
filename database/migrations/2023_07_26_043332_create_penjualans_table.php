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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->bigIncrements('No_Transaksi');
            $table->dateTime('Tgl_Transaksi', $precision = 0);
            $table->string('Nama_Konsumen', 255);
            $table->decimal('Total_Transaksi', $precision = 22, $scale = 2);
            $table->string('Username_Created', 50);
            $table->string('Username_Updated', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
