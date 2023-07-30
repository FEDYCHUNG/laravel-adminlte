@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header h-25 bg-primary text-white">
                List Penjualan
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
                            <a href="{{ route('penjualan.create') }}" class="btn btn-sm btn-outline-success"><i class="fa-solid fa-plus mr-2"></i>Tambah</a>

                        </div>
                    </div>

                    <hr class="bg-secondary border-top border-secondary border-2">
                    <table id="tpenjualan" class="table-striped table" style="width:100%">
                        <thead>
                            <tr>
                                <th class="no_transaksi text-center">No Transaksi</th>
                                <th class="tgl_transaksi text-center">Tgl Transaksi</th>
                                <th class="nm_konsumen text-center">Nama Konsumen</th>
                                <th class="total_transaksi text-center">Total Transaksi</th>
                                <th class="action text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>

    <script type="module">
        let tpenjualan;

        $(document).ready(function() {
            tpenjualan = $("#tpenjualan").DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '{{ route('penjualan.get_penjualan') }}',
                columns: [{
                        data: "No_Transaksi",
                        name: "no_transaksi",
                    },
                    {
                        data: "Tgl_Transaksi",
                        name: "tgl_transaksi",
                    },
                    {
                        data: "Nama_Konsumen",
                        name: "nm_konsumen",
                    },
                    {
                        data: "Total_Transaksi",
                        name: "total_transaksi",
                        class:"dt-body-right",
                        render: function (data, type, row) {
                            return Intl.NumberFormat('id-ID', {minimumFractionDigits: 2}).format(data);
                        },
                    },
                    {
                        data: "action",
                        name: "action",
                        class:"dt-body-center",
                    },
                ],
            });

            tpenjualan.on("click", ".btn-delete-datatable", function () {
                let data = tpenjualan.row($(this).parents("tr")).data();

                Swal.fire({
                    title: "Hapus Data ?",
                    html: `Anda Yakin Hapus <b> ${data.No_Transaksi} </b>. <br/> Data yang sudah dihapus tidak bisa dikembalikan!`,
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
            $.ajax({
                headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content') },
                url: '{{ route('penjualan.destroy', ':penjualan') }}'.replace(":penjualan", data.No_Transaksi_encrypt),
                type: "delete",
                dataType: "json",
                beforeSend: function () {
                    disableButtonClassName("button.action-button");
                },
                success: function (response) {
                    toastr.success(response.message, "Success");
                    tpenjualan.ajax.reload();
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
