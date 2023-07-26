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
        Schema::create('master_barang', function (Blueprint $table) {
            $table->string('Kode_Barang',100)->primary();
            $table->string('Nama_Barang',255);
            $table->decimal('Harga_Jual', $precision = 22, $scale = 2);
            $table->decimal('Harga_Beli', $precision = 22, $scale = 2);
            $table->string('Satuan',50);
            $table->string('Kategori',100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_barang');
    }
};
