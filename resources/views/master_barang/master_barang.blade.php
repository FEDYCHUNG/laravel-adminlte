@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header h-25 bg-primary text-white">
                List Barang
            </div>
            <div class="card-body">
                <form method="" action="">

                    <div class="@if (request()->session()->has('message')) d-block @else d-none @endif mb-2">
                        <div class="alert {{ request()->session()->get('success') == true? 'alert-success': 'alert-danger' }} d-flex align-items-center" role="alert">
                            <div><i
                                    class="fa-solid {{ request()->session()->get('success') == true? 'fa-check': 'fa-triangle-exclamation' }} fa-check mr-2"></i>{{ request()->session()->get('message') }}
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-3">
                            <a href="{{ route('master_barang.create') }}" class="btn btn-sm btn-outline-success"><i class="fa-solid fa-plus mr-2"></i>Tambah</a>

                        </div>
                    </div>

                    <hr class="bg-secondary border-top border-secondary border-2">
                    <table id="tmaster_barang" class="table-striped table" style="width:100%">
                        <thead>
                            <tr>
                                <th class="kode_barang">Kode Barang</th>
                                <th class="nm_barang">Nama Barang</th>
                                <th class="harga_jual text-right">Harga Jual</th>
                                <th class="harga_beli text-right">Harga Beli</th>
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

    <script type="text/javascript" src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendor/datatables1.12/datatables.min.js') }}"></script>

    <script type="module">
        let tmaster_barang;

        $(document).ready(function() {
            tmaster_barang = $("#tmaster_barang").DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '{{ route('master_barang.get_master_barang') }}',
                columns: [{
                        data: "Kode_Barang",
                        name: "kode_barang",
                    },
                    {
                        data: "Nama_Barang",
                        name: "nm_barang",
                    },
                    {
                        data: "Harga_Jual",
                        name: "harga_jual",
                        render: function (data, type, row) {
                            return Intl.NumberFormat('id-ID', {minimumFractionDigits: 2}).format(data);
                        },
                    },
                    {
                        data: "Harga_Beli",
                        name: "harga_beli",
                        render: function (data, type, row) {
                            return Intl.NumberFormat('id-ID', {minimumFractionDigits: 2}).format(data);
                        },
                    },
                    {
                        data: "Satuan",
                        name: "satuan",
                    },
                    {
                        data: "Kategori",
                        name: "kategori",
                    },
                    {
                        data: "action",
                        name: "action",
                    },
                ],
            });

            tmaster_barang.on("click", ".btn-delete-datatable", function () {
                let data = tmaster_barang.row($(this).parents("tr")).data();

                Swal.fire({
                    title: "Hapus Data ?",
                    html: `Anda Yakin Hapus <b> ${data.Nama_Barang} </b>. <br/> Data yang sudah dihapus tidak bisa dikembalikan!`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya",
                    cancelButtonText: `Tidak`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        hapus(data);
                    }
                });
            });
        });

        function hapus(data) {

            // console.log( '{{ route('master_barang.destroy', ':kode_barang') }}'.replace(":kode_barang", data.Kode_Barang_encrypt));return;

            $.ajax({
                headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content') },
                url: '{{ route('master_barang.destroy', ':kode_barang') }}'.replace(":kode_barang", data.Kode_Barang_encrypt),
                type: "delete",
                dataType: "json",
                beforeSend: function () {
                    disableButtonClassName("button.action-button");
                },
                success: function (response) {
                    toastr.success(response.message, "Success");
                    tmaster_barang.ajax.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    response = jqXHR.responseJSON;

                    toastr.error(response.message, "Info", {
                        timeOut: 10000,
                        extendedTimeOut: 10000,
                    });
                },
                complete: function (data) {
                    enableButtonClassName("button.action-button");
                },
            });
        }
    </script>
@endsection
