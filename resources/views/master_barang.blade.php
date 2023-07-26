@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header h-25 bg-primary text-white">
                List Bidang SKPD
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
                    <table id="tbidang" class="table-striped table" style="width:100%">
                        <thead>
                            <tr>
                                <th class="action">Action</th>
                                <th class="kd_skpd">Kd SKPD</th>
                                <th class="kd_bidang">Kd Bidang</th>
                                <th class="nm_bidang">Nm Bidang</th>
                            </tr>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
@endsection
