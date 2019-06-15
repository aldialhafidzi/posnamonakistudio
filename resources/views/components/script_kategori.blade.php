<script type="text/javascript">

var table_kategori = $('#tabel_kategori').DataTable({
  processing:true,
  serverSide:true,
  order : [[ 0, "asc" ]],
  ajax: "{{ route('all.category') }}",
  columns: [
    {data:'DT_RowIndex', name:'id'},
    {data:'nama', name :'nama'},
    {data:'action', name :'action', orderable:false, searchable:false}
  ],
  columnDefs: [
    { className: 'text-center', targets: [0, 2] }
  ],
  dom: 'lBfrtip',
  buttons: [
          { extend: 'copy', className: 'btn btn-sm btn-dark' },
          { extend: 'excel', className: 'btn btn-sm btn-success' },
          { extend: 'pdf', className: 'btn btn-sm btn-danger' },
          { extend: 'print', className: 'btn btn-sm btn-info' }
      ],

});

function editCategoryForm(id){
  save_method = 'edit';
  $('input[name = _method]').val('PATCH');
  $('#judul_modal_tambah_kategori').text('Edit Data Kategori');
  $('#insert_data_kategori').val('Edit Data');
  $('#form_tambah_kategori')[0].reset();
  $('#kategori_id').val(id);
  $.ajax({
    url : "{{ url('category') }}" + '/' + id + "/edit",
    type : "GET",
    dataType : "JSON",
    success : function(data){
      $('#kategori_id').val(data.id);
      $('#form_tambah_kategori').find('#nama').val(data.nama);
      $('#modal_tambah_kategori').modal('show');
    }
  });
}

function deleteCategoryForm(id){
  url_hapus_data = 'category';
  $('#hapus_data_id').val(id);
  $('input[name = _method]').val('DELETE');
}

function tambahCategoryForm(){
  save_method = 'add';
  $('input[name = _method]').val('POST');
  $('#judul_modal_tambah_kategori').text('Tambah Data Kategori');
  $('#insert_data_kategori').val('Tambah Data');
  $('#form_tambah_kategori')[0].reset();
}

$(document).ready(function(){

  $('#form_tambah_kategori').submit(function (event) {
    event.preventDefault();
    if ($('#form_tambah_kategori')[0].checkValidity() === false) {
        event.stopPropagation();
    } else {
      var id = $('#kategori_id').val();
      if (save_method == 'add') url = "{{ url('category') }}";
      else url = "{{ url('category') . '/' }}" + id;
      $.ajax({
        url : url,
        type : "POST",
        data : new FormData($('#form_tambah_kategori')[0]),
        contentType : false,
        processData : false,
        success : function(data){
          console.log(data);
          $('#modal_tambah_kategori').modal('hide');
          table_kategori.ajax.reload();
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
    $('#form_tambah_kategori').addClass('was-validated');
  });

});




</script>
