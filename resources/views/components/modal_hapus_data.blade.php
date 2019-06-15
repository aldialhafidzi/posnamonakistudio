<div class="modal fade" id="modal_hapus_data" tabindex="-1" role="dialog" aria-labelledby="modal_hapus_dataLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_hapus_dataLabel">Hapus Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Anda yakin ingin menghapus data ini ?
        <form id="form_hapus_data" class="needs-validation" novalidate>
          @csrf {{ method_field('DELETE') }}
          <input type="hidden" name="hapus_data_id" id="hapus_data_id" value="">
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" form="form_hapus_data" class="btn btn-danger">Hapus</button>
      </div>
    </div>
  </div>
</div>
