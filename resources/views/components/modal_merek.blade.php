<div class="modal fade " id="modal_tambah_merek">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judul_modal_tambah_merek">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_tambah_merek" class="needs-validation" novalidate>
                  @csrf {{ method_field("POST") }}
                    <div class="form-group">
                        <label for="mereknya">Nama Merek</label>
                        <input required type="text" name="nama" class="form-control" id="nama">
                        <div class="invalid-feedback">
                          Harus diisi.
                        </div>
                    </div>
                    <input type="hidden" name="merek_id" id="merek_id">

                </form>


            </div>
            <div class="modal-footer">

                <input type="submit" class="btn btn-primary" name="insert_data_merek" id="insert_data_merek" value="Update" form="form_tambah_merek">
            </div>

        </div>
    </div>
</div>
