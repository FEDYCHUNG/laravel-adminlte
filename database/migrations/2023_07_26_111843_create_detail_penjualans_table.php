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
        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->string('No_Transaksi', 100);
            $table->string('Kode_Barang', 100);
            $table->decimal('Jumlah', $precision = 22, $scale = 2);
            $table->decimal('Harga_Satuan', $precision = 22, $scale = 2);
            $table->decimal('Harga_Total', $precision = 22, $scale = 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penjualan');
    }
};
