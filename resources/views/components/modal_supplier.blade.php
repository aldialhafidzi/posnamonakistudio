<div class="modal fade " id="modal_supplier">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judul_modal_supplier">Tambah Data Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="form_tambah_supplier" class="needs-validation" novalidate>
                  @csrf {{ method_field('POST') }}
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input placeholder="Nama Pelanggan" type="text" name="nama" class="form-control" id="nama">
                    </div>
                    <div class="form-group">
                        <label for="akses">Nomor HP / Telp</label>
                        <input placeholder="Nomor Telp" type="text" name="no_telp" class="form-control" id="no_telp">
                    </div>
                    <div class="form-group">
                        <label for="status">Alamat</label>
                        <textarea form="form_tambah_supplier" placeholder="Alamat Pelanggan" type="text" name="alamat" class="form-control" id="alamat"></textarea>
                    </div>
                    <input type="hidden" name="supplier_id" id="supplier_id" value="">
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <input type="submit" class="btn btn-primary" name="insert_data_supplier" id="insert_data_supplier" value="Tambah" form="form_tambah_supplier">
            </div>

        </div>
    </div>
</div>
