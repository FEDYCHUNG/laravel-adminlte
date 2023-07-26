<div class="modal fade" id="modal_barang" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modal_barangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header pt-1 pb-1">
                <span class="modal-title" id="modal_barangLabel">Isi Data Barang</span>
                <button type="button" class="btn-close btn-sm pt-3" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <section id="section_modal_barang">
                    @csrf
                    <div class="row pt-0 pb-0">
                        <div class="col-md-12">
                            <button type="button" class="col-md-3 btn btn-outline-secondary btn-sm" title="Cari Kd Barang" data-target="#modal_tabel_barang" data-toggle="modal"
                                onclick="adjustTableDetail()"><i class="fa-solid fa-magnifying-glass mr-2"></i>Cari Kd Barang</button>
                        </div>
                    </div>
                    <hr class="bg-secondary border-top border-secondary m-2 border-2">
                    <div class="row">
                        <label for="kd_barang" class="col-sm-2 form-label col-form-label-sm pr-0">Kd Barang</label>
                        <div class="col-sm-10 pl-0">
                            <input type="text" class="form-control form-control-sm" id="kd_barang" name="kd_barang" placeholder="Tekan Tombol 'Cari' diatas" value=""
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="nm_barang" class="col-sm-2 form-label col-form-label-sm pr-0">Nm Barang</label>
                        <div class="col-sm-10 pl-0">
                            <textarea class="form-control form-control-sm" id="nm_barang" name="nm_barang" rows="2" readonly></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="kategori" class="col-sm-2 form-label col-form-label-sm pr-0">Kategori</label>
                        <div class="col-sm-10 pl-0">
                            <textarea class="form-control form-control-sm" id="kategori" name="kategori" rows="2" readonly></textarea>
                        </div>
                    </div>
                    <div class="row pl-2 pr-2 pt-1 pb-1">
                        <label class="col-sm-4 form-label col-form-label-sm bg-light border">Saldo</label>
                        <label class="col-sm-4 form-label col-form-label-sm bg-light border">Penjualan</label>
                        <label class="col-sm-4 form-label col-form-label-sm bg-light border">Satuan</label>
                    </div>
                    <div class="row pl-2 pr-2">
                        <label for="volume1_saldo" class="col-sm-1 form-label col-form-label-sm mx-0 pl-1 pr-0">Vol1</label>
                        <input type="text" class="col-sm-3 form-control form-control-sm cleave-thousand vol-saldo mr-0 text-right" id="volume1_saldo" name="volume1_saldo"
                            readonly>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm cleave-thousand vol-input modal-barang-validate-me text-right" id="volume1_input"
                                name="volume1_input" placeholder="Input Vol 1">
                            <div class="invalid-feedback volume1_input">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm" id="satuan1" name="satuan1" readonly>
                        </div>
                    </div>
                    <div class="row pl-2 pr-2">
                        <label for="harga_saldo" class="col-sm-1 form-label col-form-label-sm mx-0 pl-1 pr-0">Harga</label>
                        <input type="text" class="col-sm-3 form-control form-control-sm vol-saldo cleave-thousand mr-0 text-right" id="harga_saldo" name="harga_saldo" readonly>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm cleave-thousand vol-input text-right" id="harga_input" name="harga_input" readonly>
                        </div>
                    </div>
                    <div class="row pl-2 pr-2">
                        <label for="total_saldo" class="col-sm-1 form-label col-form-label-sm mx-0 pl-1 pr-0">Total</label>
                        <div class="col-sm-3"></div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm cleave-thousand text-right" id="total_input" name="total_input" readonly>
                        </div>
                    </div>
                </section>
            </div>
            <div class="modal-footer pt-1 pb-1">
                <button type="button" id="btn-simpan" class="btn btn-outline-success btn-sm action-button" title="Simpan" onclick="addDetail()"><i
                        class="fa-solid fa-check mr-2"></i>Tambah Item</button>
                <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal" title="Close"><i class="fa-solid fa-xmark mr-2"></i>Close</button>
            </div>
        </div>
    </div>
</div>
