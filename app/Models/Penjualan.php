<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'penjualan';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'No_Transaksi';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = 'No_Transaksi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'No_Transaksi',
        'Tgl_Transaksi',
        'Nama_Konsumen',
        'Total_Transaksi',
        'Username_Created',
        'Username_Updated',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'Username_Created',
        'Username_Updated',
        'created_at',
        'updated_at'
    ];
}
