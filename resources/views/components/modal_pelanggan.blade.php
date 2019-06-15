<div class="modal fade " id="modal_pelanggan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judul_modal_pelanggan">Tambah Data Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_tambah_pelanggan" class="needs-validation" novalidate>
                  @csrf {{ method_field('POST') }}

                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input required placeholder="Nama Pelanggan" type="text" name="nama" class="form-control" id="nama">
                    </div>
                    <div class="form-group">
                        <label for="akses">Nomor HP / Telp</label>
                        <input placeholder="Nomor Telp" type="text" name="no_telp" class="form-control" id="no_telp">
                    </div>
                    <div class="form-group">
                        <label for="status">Alamat</label>
                        <textarea  placeholder="Alamat Pelanggan" type="text" name="alamat" class="form-control" id="alamat"></textarea>
                    </div>
                    <input type="hidden" name="customer_id" id="customer_id" value="">

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <input type="submit" class="btn btn-primary" name="insert_data_pelanggan" id="insert_data_pelanggan" value="Tambah" form="form_tambah_pelanggan">
            </div>

        </div>
    </div>
</div>
