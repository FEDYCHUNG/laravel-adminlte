@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header h-25 bg-primary text-white">
                List Barang
            </div>
            <div class="card-body">
                <form method="" action="">
                    @csrf
                    <div class="@if (request()->session()->has('message')) d-block @else d-none @endif mb-2">
                        <div class="alert {{ request()->session()->get('success') == true? 'alert-success': 'alert-danger' }} d-flex align-items-center"
                            role="alert">
                            <div><i
                                    class="fa-solid {{ request()->session()->get('success') == true? 'fa-check': 'fa-triangle-exclamation' }} fa-check mr-2"></i>{{ request()->session()->get('message') }}
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-3">
                            <a href="{{ route('master_barang.create') }}" class="btn btn-sm btn-outline-success"><i
                                    class="fa-solid fa-plus mr-2"></i>Tambah</a>

                        </div>
                    </div>

                    <hr class="bg-secondary border-top border-secondary border-2">
                    <table id="tmaster_barang" class="table-striped table" style="width:100%">
                        <thead>
                            <tr>
                                <th class="kode_barang">Kode Barang</th>
                                <th class="nm_barang">Nama Barang</th>
                                <th class="harga_jual">Harga Jual</th>
                                <th class="harga_beli">Harga Beli</th>
                                <th class="satuan">Satuan</th>
                                <th class="kategori">Kategori</th>
                                <th class="action">Action</th>
                            </tr>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>


    <script type="module">
        let tmaster_barang;

        $(document).ready(function() {
            tmaster_barang = $("#tmaster_barang").DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '{{ route('master_barang.get_master_barang') }}',
                columns: [{
                        data: "kode_barang",
                        name: "kode_barang",
                    },
                    {
                        data: "nm_barang",
                        name: "nm_barang",
                    },
                    {
                        data: "harga_jual",
                        name: "harga_jual",
                    },
                    {
                        data: "harga_beli",
                        name: "harga_beli",
                    },
                    {
                        data: "satuan",
                        name: "satuan",
                    },
                    {
                        data: "kategori",
                        name: "kategori",
                    },
                    {
                        data: "action",
                        name: "action",
                    },
                ],
            });

        });
    </script>
@endsection
