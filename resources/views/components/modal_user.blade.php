<div class="modal fade" id="modal_user" tabindex="-1" role="dialog" aria-labelledby="judul_modal_user" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judul_modal_user">Tambah Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_tambah_user" class="needs-validation" novalidate>
              @csrf {{ method_field("POST") }}
            <div class="modal-body">
                    <div class="form-group">
                        <label for="username" class="col-form-label">Username:</label>
                        <input required type="text" class="form-control" id="username" name="username">
                        <div class="invalid-feedback">
                          Harus diisi.
                        </div>
                    </div>
                    <div class="form-group password">

                    </div>
                    <div class="form-group">
                        <label for="name" class="col-form-label">Nama Lengkap:</label>
                        <input required class="form-control" id="name" name="name">
                        <div class="invalid-feedback">
                          Harus diisi.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">Email:</label>
                        <input required class="form-control" id="email" name="email">
                        <div class="invalid-feedback">
                          Harus diisi.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">Role:</label>
                        <select class="form-control" name="role_id" id="role_id">
                          <option value="">-- Pilih Role --</option>
                          @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                          @endforeach
                        </select>
                        <div class="invalid-feedback">
                          Harus diisi.
                        </div>
                    </div>
                    <input type="hidden" id="user_id" name="user_id" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <input type="submit" value="Simpan" id="simpan_data_user" class="btn btn-primary">
            </div>
          </form>
        </div>
    </div>
</div>
