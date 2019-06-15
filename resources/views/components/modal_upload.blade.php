<div class="modal fade" id="modal_upload">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judul_modal_upload">Upload Master Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="upload_master_data" action="{{ route('good.import') }}" enctype="multipart/form-data" method="post">
                  {{ csrf_field() }}
                    <div class="custom-file">
                        <input autocomplete="off" form="upload_master_data" type="file" class="custom-file-input btn" name="file" id="file" required>
                        <label id="label_pilih_file_master" class="custom-file-label" for="file">Choose file</label>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <input autocomplete="off" type="submit" form="upload_master_data" class="btn btn-success" name="upload_data_excel" id="upload_data_excel" value="Upload"></input>
            </div>
        </div>
    </div>

</div>
