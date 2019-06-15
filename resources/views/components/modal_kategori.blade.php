<div class="modal fade " id="modal_tambah_kategori">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judul_modal_tambah_kategori">Tambah Data Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_tambah_kategori" class="needs-validation" novalidate>
                  @csrf {{ method_field("POST") }}
                    <div class="form-group">
                        <label for="mereknya">Nama Kategori</label>
                        <input required type="text" name="nama" class="form-control" id="nama">
                        <div class="invalid-feedback">
                          Harus diisi.
                        </div>
                    </div>
                    <input type="hidden" name="kategori_id" id="kategori_id">
                </form>


            </div>
            <div class="modal-footer">

                <input type="submit" class="btn btn-primary" name="insert_data_kategori" id="insert_data_kategori" value="Update" form="form_tambah_kategori">
            </div>

        </div>
    </div>
</div>
