<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
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
        //
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
}
