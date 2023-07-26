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
            $table->string('no_transaksi',100)->primary();
            $table->dateTime('tgl_transaksi', $precision = 0);
            $table->string('Nama_Konsumen',255);
            $table->string('Kode_Barang',100);
            $table->decimal('Jumlah', $precision = 22, $scale = 2);
            $table->decimal('Harga_Satuan', $precision = 22, $scale = 2);
            $table->decimal('Harga_Total', $precision = 22, $scale = 2);
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
