<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\MasterBarang;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("penjualan.penjualan");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("penjualan.add_penjualan");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $no_transaksi = 0;

            DB::transaction(function () use ($request, &$no_transaksi) {
                $penjualan = Penjualan::create(
                    [
                        'Tgl_Transaksi' => ($request->tgl_transaksi == "" || is_null($request->tgl_transaksi)) ? '' : Carbon::createFromFormat('d-m-Y', $request->tgl_transaksi)->format('Y-m-d H:i:s'),
                        'Nama_Konsumen' => $request->nm_konsumen,
                        'Total_Transaksi' => 0,
                        'Username_Created' => Auth::user()->id,
                        'Username_Updated' => Auth::user()->id,
                    ]
                );

                $no_transaksi = $penjualan->No_Transaksi;

                $insert_detail = [];
                $sum_total = 0;

                $request->data_barang = json_decode($request->data_barang);

                foreach ($request->data_barang as $row) {
                    $total = $row->Jumlah *  $row->Harga_Satuan;
                    $sum_total += $total;

                    $insert_detail[] = array(
                        'No_Transaksi' => $no_transaksi,
                        'Kode_Barang' => $row->Kode_Barang,
                        'Jumlah' => floatval($row->Jumlah),
                        'Harga_Satuan' => floatval($row->Harga_Satuan),
                        'Harga_Total' => floatval($total),
                    );
                }
                foreach (array_chunk($insert_detail, 20) as $chunk) {
                    DetailPenjualan::insert($chunk);
                }


                Penjualan::where('No_Transaksi', $no_transaksi)->update(['Total_Transaksi' => $sum_total]);
            });

            session()->flash('success', true);
            session()->flash('message', "Transaksi Berhasil Disimpan dengan No " . $no_transaksi);
            session()->keep(['success', 'message']);

            return response()->json(array("success" => true, "message" => "Transaksi Berhasil Disimpan dengan No " . $no_transaksi), 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json("Server Error", 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::transaction(function () use ($id) {
                Penjualan::where("No_Transaksi", Crypt::decryptString($id))->delete();
                DetailPenjualan::where("No_Transaksi", Crypt::decryptString($id))->delete();
            });

            return response()->json(array("success" => true, "message" => "Data Berhasil Dihapus"), 200);
        } catch (\Throwable $th) {
            return response()->json(array("message" => "Server Error !!!"), 500);
        }
    }

    public function getPenjualan(Request $request)
    {
        $start = $request->input('start');
        $length = $request->input('length');
        $search = $request->input("search.value");

        $query = Penjualan::select('No_Transaksi as No_Transaksi_encrypt', 'No_Transaksi', 'Tgl_Transaksi', 'Nama_Konsumen', 'Total_Transaksi')
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('No_Transaksi', 'like', '%' . $search . '%')->orWhere('Nama_Konsumen', 'like', '%' . $search . '%');
                });
            });

        $recordsFiltered = $query->count();
        $recordsTotal = $recordsFiltered;
        $result = $query->skip($start)->take($length)->orderBy("No_Transaksi")->get();

        return DataTables::of($result)->with([
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
        ])
            ->editColumn('No_Transaksi_encrypt', '{{Crypt::encryptString($No_Transaksi_encrypt)}}')
            ->addColumn('action', function ($item) {
                return '<a href="' . route('penjualan.edit', ['penjualan' => Crypt::encryptString($item->No_Transaksi)]) . '" class="btn btn-outline-success btn-sm mr-1 fa-solid fa-pen-to-square btn-edit-datatable" title="Edit"></a>
                <button type="button" class="btn btn-outline-danger btn-sm btn-delete-datatable action-button" title="Hapus"><i class="fa-solid fa-trash-can"></i></button>';
            })
            ->order(function ($query) {
                if (request()->has('No_Transaksi')) {
                    $query->orderBy('No_Transaksi', 'asc');
                }
            })
            ->setOffset($start)->make(true);
    }

    public function getSaldoGudang(Request $request)
    {
        $start = $request->input('start');
        $length = $request->input('length');
        $search = $request->input("search.value");

        $query = MasterBarang::select('Kode_Barang as Kode_Barang_encrypt', 'Kode_Barang', 'Nama_Barang', 'Harga_Jual', 'Harga_Beli', 'Satuan', 'Kategori')
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('Kode_Barang', 'like', '%' . $search . '%')->orWhere('Nama_Barang', 'like', '%' . $search . '%')
                        ->orWhere('Satuan', 'like', '%' . $search . '%')->orWhere('Kategori', 'like', '%' . $search . '%');
                });
            });

        $recordsFiltered = $query->count();
        $recordsTotal = $recordsFiltered;
        $result = $query->skip($start)->take($length)->orderBy("Kode_Barang")->get();

        return DataTables::of($result)->with([
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
        ])
            ->editColumn('Kode_Barang_encrypt', '{{Crypt::encryptString($Kode_Barang_encrypt)}}')
            ->addColumn('action', function ($item) {
                return '<a href="' . route('master_barang.edit', ['master_barang' => Crypt::encryptString($item->Kode_Barang)]) . '" class="btn btn-outline-success btn-sm mr-1 fa-solid fa-pen-to-square btn-edit-datatable" title="Edit"></a>
                <button type="button" class="btn btn-outline-danger btn-sm btn-delete-datatable action-button" title="Hapus"><i class="fa-solid fa-trash-can"></i></button>';
            })
            ->order(function ($query) {
                if (request()->has('Kode_Barang')) {
                    $query->orderBy('Kode_Barang', 'asc');
                }
            })
            ->setOffset($start)->make(true);
    }
}
