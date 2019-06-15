<script type="text/javascript">
var table_user = $('#tabel_user').DataTable({
  processing:true,
  serverSide:true,
  order : [[ 0, "asc" ]],
  ajax: "{{ route('all.user') }}",
  columns: [
    {data:'DT_RowIndex', name:'id'},
    {data:'username', name :'username'},
    {data:'role.name', name :'role.name'},
    {data:'name', name :'name'},
    {data:'email', name :'email'},
    {data:'action', name :'action', orderable:false, searchable:false}
  ],
  columnDefs: [
    { className: 'text-center', targets: [0, 5] }
  ]

});

function deleteUserForm(id){
  url_hapus_data = 'user';
  $('#hapus_data_id').val(id);
  $('input[name = _method]').val('DELETE');
}

function tambahUserForm()
{
  $('#form_tambah_user .password').html('<label for="username" class="col-form-label">Password:</label><input required type="password" class="form-control" id="password" name="password"><div class="invalid-feedback">Harus diisi.</div>');
  save_method = 'add';
  $('input[name = _method]').val('POST');
  $('#judul_modal_user').text('Tambah Data User');
  $('#simpan_data_user').val('Tambah');
  $('#form_tambah_user')[0].reset();
  $('#modal_user').modal('show');
}

function editUserForm(id){
  save_method = 'edit';
  $('input[name = _method]').val('PATCH');
  $('#judul_modal_user').text('Edit Data User');
  $('#simpan_data_user').val('Simpan');
  $('#form_tambah_user .password').html('');
  $.ajax({
    url : "{{ url('user') }}" + '/' + id + "/edit",
    type : "GET",
    dataType : "JSON",
    success : function(data){
      $('#modal_user').modal('show');
      $('#user_id').val(id);
      $('#form_tambah_user').find('#role_id').val(data.role.id);
      $('#form_tambah_user').find('#username').val(data.username);
      $('#form_tambah_user').find('#name').val(data.name);
      $('#form_tambah_user').find('#email').val(data.email);
    }
  });
}


$(document).ready(function(){

  $('#form_tambah_user').submit(function (event) {
    event.preventDefault();
    if ($('#form_tambah_user')[0].checkValidity() === false) {
        event.stopPropagation();
    } else {
      var id = $('#user_id').val();
      if (save_method == 'add') url = "{{ url('user') }}";
      else url = "{{ url('user') . '/' }}" + id;
      $.ajax({
        url : url,
        type : "POST",
        data : new FormData($('#form_tambah_user')[0]),
        contentType : false,
        processData : false,
        success : function(data){
          $('#modal_user').modal('hide');
          table_user.ajax.reload();
          $.notify(" "+data.message,
            {
              align:"right", verticalAlign:"bottom",
              close: true, delay:3000,
              color: "#fff", background: "#41a845",
              icon:"check"
            });
        },
        error : function(data){
          $.notify("  Data gagal ditambahkan !",
            {
              align:"right", verticalAlign:"bottom",
              close: true, delay:3000,
              color: "#fff", background: "#c3383f",
              icon:"close"
            });
        }
      });
    }
    $('#form_tambah_user').addClass('was-validated');
  });

});

</script>
