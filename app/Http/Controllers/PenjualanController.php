<?php

namespace App\Http\Controllers;

use App\Models\MasterBarang;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
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
        Penjualan::create(
            [
                'Tgl_Transaksi' => ($request->tgl_transaksi == "" || is_null($request->tgl_transaksi)) ? '' : Carbon::createFromFormat('d-m-Y', $request->tgl_transaksi)->format('Y-m-d'),
                'Nama_Konsumen' => $request->nm_konsumen,
                'Total_Transaksi' => 0,
                'Username_Created' => Auth::user()->id,
                'Username_Updated' => Auth::user()->id,
            ]
        );
        exit;

        try {


            DB::transaction(function () use ($request) {
                $insert_detail = [];
                $sum_total = 0;

                Penjualan::create(
                    [
                        'Tgl_Transaksi' => ($request->tgl_transaksi == "" || is_null($request->tgl_transaksi)) ? '' : Carbon::createFromFormat('d-m-Y', $request->tgl_transaksi)->format('Y-m-d'),
                        'Nama_Konsumen' => $request->nm_konsumen,
                        'Total_Transaksi' => 0,
                        'Username_Created' => Auth::user()->id,
                        'Username_Updated' => Auth::user()->id,
                    ]
                );

                // foreach ($request->data_barang as $row) {
                //     $total = $row->volume1 *  $row->harga_satuan;
                //     $sum_total += $total;

                //     $insert_detail[] = array(
                //         'kd_skpd' => $request->kd_skpd,
                //         'kd_barang' => $row->kd_barang,
                //         'uraian_barang' => $row->uraian_barang,
                //         'spesifikasi' => $row->spesifikasi,
                //         'keterangan' => $row->keterangan,
                //         'keperluan' => $row->keperluan,
                //         'volume1_adm' => floatval($row->volume1_adm),
                //         'volume1_saldo' => floatval($row->volume1_saldo),
                //         'satuan1_adm' => $row->satuan1_adm,
                //         'harga_adm' => floatval($row->harga_adm),
                //         'total_adm' => floatval($total_adm),
                //     );
                // }
                // foreach (array_chunk($insert_detail, 20) as $chunk) {
                //     TrdNpb::insert($chunk);
                // }
            });

            if (!$result["success"]) return response()->json($result, 400);

            session()->flash('success', true);
            session()->flash('message', $result["message"]);
            session()->keep(['status', 'message']);
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            Log::error($th);
            Debugbar::error($th);
            return response()->json("Server Persediaan Error", 500);
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
        //
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
