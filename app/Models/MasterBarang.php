<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBarang extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'master_barang';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'Kode_Barang';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Kode_Barang',
        'Nama_Barang',
        'Harga_Jual',
        'Harga_Beli',
        'Satuan',
        'Kategori',
        'Username_Created',
        'Username_Updated',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'Username_Created',
        'Username_Updated',
        'created_at',
        'updated_at',
    ];
}
