<div class="modal fade" id="modal_tabel_barang" aria-hidden="true" aria-labelledby="modal_tabel_barangToggleLabel2" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header pt-1 pb-1">
                <span class="modal-title" id="modal_tabel_barangToggleLabel2">Pilih Kd Barang</span>
                <button type="button" class="btn-close btn-sm pt-3" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid justify-content-center p-0">
                    <table id="tsaldo_gudang" class="table-bordered dt-responsive table" style="width:100%">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th class="kode_barang text-center">Kode Barang</th>
                                <th class="nm_barang text-center">Nm Barang</th>
                                <th class="harga_jual text-center">harga_jual</th>
                                <th class="satuan text-center">Satuan</th>
                                <th class="kategori text-center">Kategori</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-success btn-sm action-button" data-target="#modal_tabel_barang" data-toggle="modal" title="Pilih" onclick="chooseKdBarang()"><i
                        class="fa-solid fa-check mr-2"></i>Pilih</button>
                <button class="btn btn-outline-warning btn-sm" data-target="#modal_tabel_barang" data-toggle="modal" title="Kembali"
                    onclick='enableButtonClassName("button.action-button")'><i class="fa-solid fa-arrow-left-long mr-2"></i>Kembali</button>
            </div>
        </div>
    </div>
</div>
