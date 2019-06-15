<script type="text/javascript">

var table_merek = $('#tabel_merek').DataTable({
  processing:true,
  serverSide:true,
  order : [[ 0, "asc" ]],
  ajax: "{{ route('all.brand') }}",
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

function editBrandForm(id){
  save_method = 'edit';
  $('input[name = _method]').val('PATCH');
  $('#judul_modal_tambah_merek').text('Edit Data Merek');
  $('#insert_data_merek').val('Edit Data');
  $('#form_tambah_merek')[0].reset();
  $('#merek_id').val(id);
  $.ajax({
    url : "{{ url('brand') }}" + '/' + id + "/edit",
    type : "GET",
    dataType : "JSON",
    success : function(data){
      console.log(data);
      $('#merek_id').val(data.id);
      $('#form_tambah_merek').find('#nama').val(data.nama);
      $('#modal_tambah_merek').modal('show');
    }
  });
}

function deleteBrandForm(id){
  url_hapus_data = 'brand';
  $('#hapus_data_id').val(id);
  $('input[name = _method]').val('DELETE');
}

function tambahBrandForm(){
  save_method = 'add';
  $('input[name = _method]').val('POST');
  $('#judul_modal_tambah_merek').text('Tambah Data Merek');
  $('#insert_data_merek').val('Tambah Data');
  $('#form_tambah_merek')[0].reset();
}

$(document).ready(function(){

  $('#form_tambah_merek').submit(function (event) {
    event.preventDefault();
    if ($('#form_tambah_merek')[0].checkValidity() === false) {
        event.stopPropagation();
    } else {
      var id = $('#merek_id').val();
      if (save_method == 'add') url = "{{ url('brand') }}";
      else url = "{{ url('brand') . '/' }}" + id;
      $.ajax({
        url : url,
        type : "POST",
        data : new FormData($('#form_tambah_merek')[0]),
        contentType : false,
        processData : false,
        success : function(data){

          $('#modal_tambah_merek').modal('hide');
          table_merek.ajax.reload();
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
    $('#form_tambah_merek').addClass('was-validated');
  });

});




</script>
