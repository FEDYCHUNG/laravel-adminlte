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
                            value="{{ old('no_transaksi', $bidang->no_transaksi ?? '') }}" placeholder="Isi Kode Barang" required>
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
                    <div class="row-inline mb-3 mt-3">
                        <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-floppy-disk mr-2"></i>Simpan</button>
                        <a href="{{ route('master_barang.index') }}" class="btn btn-sm btn-outline-warning"><i class="fa-solid fa-arrow-left mr-2"></i>Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script type="module">
        $(document).ready(function() {
            $("#frmadd").on('submit', function(e) {
                e.preventDefault();
                document.getElementById('harga_jual_number').value = $.valHooks["#harga_jual"].getRawValue();
                document.getElementById('harga_beli_number').value = $.valHooks["#harga_beli"].getRawValue();


                document.getElementById('frmadd').submit();
            });

            $("#tgl_transaksi").datetimepicker({});
        })
    </script>
@endsection
