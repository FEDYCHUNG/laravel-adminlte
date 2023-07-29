@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header h-25 bg-primary text-white">
                Input Transaksi
            </div>
            <div class="card-body">
                <form id="frmadd" method="post" action="">
                    @csrf

                    <div class="@if ($errors->all()) d-block @else d-none @endif mb-2">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="@if (request()->session()->has('message')) d-block @else d-none @endif mb-2">
                        <div class="alert {{ request()->session()->get('success') == true? 'alert-success': 'alert-danger' }} d-flex align-items-center" role="alert">
                            <div><i
                                    class="fa-solid {{ request()->session()->get('success') == true? 'fa-check': 'fa-triangle-exclamation' }} fa-check mr-2"></i>{{ request()->session()->get('message') }}
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label for="no_transaksi" class="col-form-label col-form-label-sm">No Transaksi</label>
                        <input type="text" class="form-control form-control-sm @error('no_transaksi') is-invalid @enderror" id="no_transaksi" name="no_transaksi"
                            value="{{ old('no_transaksi', $bidang->no_transaksi ?? '') }}" placeholder="" readonly>
                        @error('no_transaksi')
                            @foreach ($errors->get('no_transaksi') as $error)
                                <div id="no_transaksi" class="invalid-feedback">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @enderror
                    </div>

                    <div class="col-12 col-md-6 form-group">
                        <label for="tgl_transaksi" class="col-form-label col-form-label-sm">Tgl Transaksi</label>
                        <div class="input-group date" id="tgl_transaksi" data-target-input="nearest">
                            <div class="input-group-append" data-target="#tgl_transaksi" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                            </div>
                            <input id="tgl_transaksi" name="tgl_transaksi" type="text"
                                class="form-control form-control-sm datetimepicker-input @error('tgl_transaksi') is-invalid @enderror" data-target="#tgl_transaksi"
                                value="{{ old('tgl_transaksi') }}" />
                            @error('tgl_transaksi')
                                @foreach ($errors->get('tgl_transaksi') as $error)
                                    <div class="invalid-feedback">
                                        {{ $error }}
                                    </div>
                                @endforeach
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label for="nm_konsumen" class="col-form-label col-form-label-sm">Nama Konsumen</label>
                        <input type="text" class="form-control form-control-sm @error('nm_konsumen') is-invalid @enderror" id="nm_konsumen" name="nm_konsumen"
                            value="{{ old('nm_konsumen', $master_barang->nm_konsumen ?? '') }}" placeholder="Isi Nama Konsumen" required>
                        @error('nm_konsumen')
                            @foreach ($errors->get('nm_konsumen') as $error)
                                <div id="nm_konsumen" class="invalid-feedback">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @enderror
                    </div>

                    <hr class="bg-secondary border-top border-secondary border-2">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <button id="btn-tambah-barang" type="button" class="btn btn-outline-success btn-sm" title="Tambah Barang" data-toggle="modal" data-target="#modal_barang"
                                onclick="tambahBarang()">
                                <i class="fa-solid fa-plus mr-2"></i>Tambah
                            </button>
                        </div>
                    </div>

                    <table id="tdetail_penjualan" class="table-striped table" style="width:100%">
                        <thead>
                            <tr>
                                <th class="action">Action</th>
                                <th class="kode_barang">Kode Barang</th>
                                <th class="jumlah">Jumlah</th>
                                <th class="harga_satuan">Harga Satuan</th>
                                <th class="harga_total">Harga_Total</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4">Total</th>
                                <th id="sum_total" class="bg-success text-right text-black">0</th>
                            </tr>
                        </tfoot>
                    </table>


                    <hr class="bg-secondary border-top border-secondary border-2">
                    <div class="row-inline mb-3 mt-3">
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="simpan()"><i class="fa-solid fa-floppy-disk mr-2"></i>Simpan</button>
                        <a href="{{ route('master_barang.index') }}" class="btn btn-sm btn-outline-warning"><i class="fa-solid fa-arrow-left mr-2"></i>Kembali</a>
                    </div>
                </form>

                <!-- Modal Barang -->
                @include('penjualan.modal_barang')
                <!-- End Modal Barang -->

                <!-- Modal Cari Barang -->
                @include('penjualan.modal_tabel_barang')
                <!-- End Modal Cari Barang -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let tdetail_penjualan;
        let selected_item = {};
        let status_detail;

        $(document).ready(function() {
            $("#tgl_transaksi").datetimepicker({});

            tdetail_penjualan = $("#tdetail_penjualan").DataTable({
                processing: true,
                autoWidth: false,
                scrollX: true,
                scrollY: "200px",
                paging: true,
                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"],
                ],
                searchDelay: 1000,
                columns: [{
                        data: "action",
                        name: "action",
                        width: "8%",
                        orderable: false,
                    },
                    {
                        data: "Kode_Barang",
                        name: "kode_barang",
                        width: "32%",
                    },
                    {
                        data: "Jumlah",
                        name: "jumlah",
                        width: "15%",
                        class: "dt-body-right",
                        render: function(data, type, row) {
                            return new Intl.NumberFormat(["en-US"]).format(data);
                        },
                    },
                    {
                        data: "Harga_Satuan",
                        name: "harga_satuan",
                        width: "32%",
                        class: "dt-body-right",
                        render: function(data, type, row) {
                            return new Intl.NumberFormat(["en-US"]).format(data);
                        },
                    },
                    {
                        data: "Harga_Total",
                        name: "harga_total",
                        width: "15%",
                        class: "dt-body-right",
                        render: function(data, type, row) {
                            return new Intl.NumberFormat(["en-US"]).format(data);
                        },
                    },
                ],
                drawCallback: function(settings) {
                    var api = this.api();
                    let total = api
                        .column("harga_total:name")
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    $(api.column("harga_total:name").footer()).html(new Intl.NumberFormat(["en-US"]).format(total));
                },
            });

            tsaldo_gudang = $("#tsaldo_gudang").DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                scrollX: true,
                paging: true,
                searchDelay: 1000,
                ajax: {
                    url: '{{ route('penjualan.get_saldo_gudang') }}',
                    // data: function(d) {
                    //     d.kd_barang_in_dt_barang = findAllBarangInDtBarang();
                    // },
                },
                select: {
                    style: "single",
                },
                columns: [{
                        data: "Kode_Barang",
                        name: "kode_barang",
                        width: "100px",
                    },
                    {
                        data: "Nama_Barang",
                        name: "nama_barang",
                        width: "120px",
                    },
                    {
                        data: "Harga_Jual",
                        name: "harga_jual",
                        width: "50px",
                        className: "dt-body-right",
                        render: function(data, type, row) {
                            return new Intl.NumberFormat(["en-US"]).format(data);
                        },
                    },
                    {
                        data: "Satuan",
                        name: "satuan",
                        width: "80px",
                    },
                    {
                        data: "Kategori",
                        name: "kategpri",
                        width: "50px",
                    },
                ],
            });

            $(".vol-input").on("keyup", function(event) {
                const vol1 = $.valHooks["#volume1_input"].getRawValue();
                let harga = $.valHooks["#harga_input"].getRawValue();

                let total = vol1 * harga;

                $.valHooks["#total_input"].setRawValue(total);
            });

        });

        function addDetail() {
            let detail = {};
            detail.kode_barang = selected_item.Kode_Barang;
            detail.nm_barang = selected_item.Nama_Barang;
            detail.harga_jual = selected_item.Harga_Jual;
            detail.satuan = selected_item.Satuan;
            detail.kategori = selected_item.Kategori
            detail.volume1 = $.valHooks["#volume1_input"].getRawValue();
            detail.harga_total = parseFloat(detail.harga_jual) * detail.volume1;

            let volume1_id = document.getElementById("volume1_input");
            if (detail.volume1 <= 0) {
                volume1_id.classList.add("is-invalid");
                volume1_id.title = "Volume 1 Tidak Boleh 0";
            } else {
                volume1_id.classList.remove("is-invalid");
                volume1_id.title = "";
            }

            if (status_detail.status == "tambah") {
                addRowDetail(detail);
            } else {
                // updateRowDetail(status_detail.idx, detail);
            }
        }

        function adjustTableDetail() {
            tsaldo_gudang.columns.adjust().draw(false);
        }

        function addRowDetail(detail) {
            document.getElementById("btn-simpan").disabled = true;

            tdetail_penjualan.row
                .add({
                    id: "",
                    action:
                        // '<button type="button" class="btn btn-outline-success btn-sm mr-1 fa-solid fa-pen-to-square btn-edit-barang" title="Edit"></button>' +
                        '<button type="button" class="btn btn-outline-danger btn-sm fa-solid fa-trash-can btn-delete-barang action-button" title="Hapus"></button>',
                    Kode_Barang: detail.kode_barang,
                    Jumlah: detail.volume1,
                    Harga_Satuan: detail.harga_jual,
                    Harga_Total: detail.harga_total,
                })
                .draw(false);

            tdetail_penjualan.columns.adjust().draw(false);

            toastr.success(`${detail.nm_barang} berhasil ditambah.`, "Success");

            document.getElementById("btn-simpan").disabled = false;

            tambahBarang();
        }

        function chooseKdBarang() {
            disableButtonClassName("button.action-button");

            selected_item = tsaldo_gudang.row(".selected").data();

            document.getElementById("kd_barang").value = selected_item.Kode_Barang;
            document.getElementById("nm_barang").value = selected_item.Nama_Barang;
            document.getElementById("kategori").value = selected_item.Kategori;

            $.valHooks["#harga_saldo"].setRawValue(selected_item.Harga_Jual == 0 ? "" : selected_item.Harga_Jual);
            $.valHooks["#harga_input"].setRawValue(selected_item.Harga_Jual == 0 ? "" : selected_item.Harga_Jual);

            document.getElementById("satuan1").value = selected_item.Satuan;

            $(".vol-input").trigger("keyup");

            document.getElementById("volume1_input").focus();

            enableButtonClassName("button.action-button");
        }

        function designModalBarangSubmit(icon, text) {
            let btn_simpan = document.getElementById("btn-simpan");

            btn_simpan.textContent = "";

            i = document.createElement("i");
            i.className = `fa-solid ${icon} mr-2`;
            btn_simpan.appendChild(i);

            span = document.createElement("span");
            span.textContent = text;
            btn_simpan.appendChild(span);
            btn_simpan.title = text;
        }

        function simpan() {
            const token = document.querySelector("[name='_token']").value;

            let formdata = new FormData(document.getElementById("frmadd"));
            formdata.delete("_token");
            formdata.set("data_barang", JSON.stringify(tdetail_penjualan.rows().data().toArray()));

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('penjualan.store') }}',
                type: "post",
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    disableButtonClassName("button.action-button");
                },
                data: formdata,
                success: function(response) {
                    window.location.href = '{{ route('penjualan.index') }}';;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    response = jqXHR.responseJSON;

                    toastr.error(response.message, "Info", {
                        timeOut: 10000,
                    });
                },
                complete: function(data) {
                    enableButtonClassName("button.action-button");
                },
            });
        }


        function tambahBarang() {
            document.getElementById("kd_barang").value = "";
            document.getElementById("nm_barang").value = "";
            document.getElementById("kategori").value = "";

            document.getElementById("volume1_saldo").value = "";
            document.getElementById("harga_saldo").value = "";

            document.getElementById("volume1_input").value = "";
            document.getElementById("harga_input").value = "";
            $.valHooks["#total_input"].setRawValue(0);

            document.getElementById("satuan1").value = "";

            status_detail = {
                status: "tambah",
                idx: ""
            };

            designModalBarangSubmit("fa-floppy-disk", "Tambah Item");
        }
    </script>
@endpush
