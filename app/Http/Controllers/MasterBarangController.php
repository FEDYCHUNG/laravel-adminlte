<?php

namespace App\Http\Controllers;

use App\Http\Requests\MasterBarang\MasterBarangStoreRequest;
use App\Models\MasterBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class MasterBarangController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("master_barang.master_barang");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("master_barang.add_master_barang");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MasterBarangStoreRequest $request)

    {
        try {
            MasterBarang::create(
                [
                    'Kode_Barang' => $request->kode_barang,
                    'Nama_Barang' => $request->nm_barang,
                    'Harga_Jual' => floatval($request->harga_jual_number),
                    'Harga_Beli' => floatval($request->harga_beli_number),
                    'Satuan' => $request->satuan,
                    'Kategori' => $request->kategori,
                    'Username_Created' => Auth::user()->id,
                    'Username_Updated' => Auth::user()->id,
                ]
            );
            return redirect()->route('master_barang.index')->with('success', true)->with('message', $request->nama_barang . " Berhasil Disimpan");
        } catch (\Throwable $th) {
            Log::error($th);
            return back()->withInput()->with('success', false)->with('success', false)->with('message', "Server Error !!!");
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
            MasterBarang::where("Kode_Barang", Crypt::decryptString($id))->delete();

            return response()->json(array("success" => true, "message" => "Data Berhasil Dihapus"), 200);
        } catch (\Throwable $th) {
            return response()->json(array("message" => "Server Error !!!"), 500);
        }
    }

    public function getMasterBarang(Request $request)
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
                return '<a href="' . route('master_barang.edit', ['master_barang' => Crypt::encryptString($item->master_barang)]) . '" class="btn btn-outline-success btn-sm mr-1 fa-solid fa-pen-to-square btn-edit-datatable" title="Edit"></a>
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
