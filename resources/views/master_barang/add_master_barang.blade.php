@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header h-25 bg-primary text-white">
                Input Barang
            </div>
            <div class="card-body">
                <form id="frmadd" method="post" action="{{ route('master_barang.store') }}">
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

                    <input type="hidden" name="harga_jual_number" id="harga_jual_number">
                    <input type="hidden" name="harga_beli_number" id="harga_beli_number">

                    <div class="form-group mb-2">
                        <label for="kode_barang" class="col-form-label col-form-label-sm">Kode Barang</label>
                        <input type="text" class="form-control form-control-sm @error('kode_barang') is-invalid @enderror" id="kode_barang" name="kode_barang"
                            value="{{ old('kode_barang', $bidang->kode_barang ?? '') }}" placeholder="Isi Kode Barang" required>
                        @error('kode_barang')
                            @foreach ($errors->get('kode_barang') as $error)
                                <div id="kode_barang" class="invalid-feedback">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label for="nm_barang" class="col-form-label col-form-label-sm">Nama Barang</label>
                        <input type="text" class="form-control form-control-sm @error('nm_barang') is-invalid @enderror" id="nm_barang" name="nm_barang"
                            value="{{ old('nm_barang', $master_barang->nm_barang ?? '') }}" placeholder="Isi Nama Barang" required>
                        @error('nm_barang')
                            @foreach ($errors->get('nm_barang') as $error)
                                <div id="nm_barang" class="invalid-feedback">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label for="harga_jual" class="col-form-label col-form-label-sm">Harga Jual</label>
                        <input type="text" class="form-control form-control-sm text-right cleave-thousand @error('harga_jual') is-invalid @enderror" id="harga_jual"
                            name="harga_jual" value="{{ old('harga_jual', $master_barang->harga_jual ?? '') }}" placeholder="Isi Harga Jual" required>
                        @error('harga_jual')
                            @foreach ($errors->get('harga_jual') as $error)
                                <div id="harga_jual" class="invalid-feedback">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label for="harga_beli" class="col-form-label col-form-label-sm">Harga Beli</label>
                        <input type="text" class="form-control form-control-sm text-right cleave-thousand @error('harga_beli') is-invalid @enderror" id="harga_beli"
                            name="harga_beli" value="{{ old('harga_beli', $master_barang->harga_beli ?? '') }}" placeholder="Isi Harga Beli" required>
                        @error('harga_beli')
                            @foreach ($errors->get('harga_beli') as $error)
                                <div id="harga_beli" class="invalid-feedback">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label for="satuan" class="col-form-label col-form-label-sm">Satuan</label>
                        <input type="text" class="form-control form-control-sm @error('satuan') is-invalid @enderror" id="satuan" name="satuan"
                            value="{{ old('satuan', $master_barang->satuan ?? '') }}" placeholder="Isi Satuan" required>
                        @error('satuan')
                            @foreach ($errors->get('satuan') as $error)
                                <div id="satuan" class="invalid-feedback">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label for="kategori" class="col-form-label col-form-label-sm">Kategori</label>

                        <textarea id="kategori" name="kategori" cols="30" rows="3" class="form-control form-control-sm @error('kategori') is-invalid @enderror" placeholder="Isi Kategori"
                            required>{{ old('kategori', $master_barang->kategori ?? '') }}</textarea>
                        @error('kategori')
                            @foreach ($errors->get('kategori') as $error)
                                <div id="kategori" class="invalid-feedback">
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
        })
    </script>
@endsection
