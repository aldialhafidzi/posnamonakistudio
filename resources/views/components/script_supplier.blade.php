<script type="text/javascript">

var table_supplier = $('#table_supplier').DataTable({
  processing:true,
  serverSide:true,
  order : [[ 0, "asc" ]],
  ajax: "{{ route('all.supplier') }}",
  columns: [
    {data:'DT_RowIndex', name:'id'},
    {data:'nama', name :'nama'},
    {data:'alamat', name :'alamat'},
    {data:'no_telp', name :'no_telp'},
    {data:'action', name :'action', orderable:false, searchable:false}
  ],
  columnDefs: [
    { className: 'text-center', targets: [0, 3, 4] }
  ],
  dom: 'lBfrtip',
  buttons: [
          { extend: 'copy', className: 'btn btn-sm btn-dark' },
          { extend: 'excel', className: 'btn btn-sm btn-success' },
          { extend: 'pdf', className: 'btn btn-sm btn-danger' },
          { extend: 'print', className: 'btn btn-sm btn-info' }
      ],

});

function editSupplierForm(id){
  save_method = 'edit';
  $('input[name = _method]').val('PATCH');
  $('#judul_modal_supplier').text('Edit Data Supplier');
  $('#insert_data_supplier').val('Edit Data');
  $('#form_tambah_supplier')[0].reset();
  $('#supplier_id').val(id);
  $.ajax({
    url : "{{ url('supplier') }}" + '/' + id + "/edit",
    type : "GET",
    dataType : "JSON",
    success : function(data){
      $('#supplier_id').val(data.id);
      $('#form_tambah_supplier').find('#nama').val(data.nama);
      $('#form_tambah_supplier').find('#alamat').val(data.alamat);
      $('#form_tambah_supplier').find('#no_telp').val(data.no_telp);
      $('#modal_supplier').modal('show');
    }
  });
}

function deleteSupplierForm(id){
  url_hapus_data = 'supplier';
  $('#hapus_data_id').val(id);
  $('input[name = _method]').val('DELETE');
}

function tambahSupplierForm(){
  save_method = 'add';
  $('input[name = _method]').val('POST');
  $('#judul_modal_supplier').text('Tambah Data Supplier');
  $('#insert_data_supplier').val('Tambah Data');
  $('#form_tambah_supplier')[0].reset();
}

$(document).ready(function(){

  $('#form_tambah_supplier').submit(function(e){
    e.preventDefault();
    if($('#form_tambah_supplier')[0].checkValidity() === false){
    }else {
      var id = $('#supplier_id').val();
      if (save_method == 'add') url = "{{ url('supplier') }}";
      else url = "{{ url('supplier') . '/' }}" + id;
      $.ajax({
        url : url,
        type : "POST",
        data : new FormData($('#form_tambah_supplier')[0]),
        contentType : false,
        processData : false,
        success : function(data){
          $('#modal_supplier').modal('hide');
          $('#form_tambah_supplier')[0].reset();
          $('#modal_supplier').modal('hide');
          $.notify(" "+data.message,
            {
              align:"right", verticalAlign:"bottom",
              close: true, delay:3000,
              color: "#fff", background: "#41a845",
              icon:"check"
            });

            if (table_supplier != null) {
              table_supplier.ajax.reload();
            } else {
              location.reload();
            }
        },
        error : function(data){
          $.notify("  Data supplier gagal ditambahkan !!",
            {
              align:"right", verticalAlign:"bottom",
              close: true, delay:3000,
              color: "#fff", background: "#c3383f",
              icon:"close"
            });
        }
      });

    }
    $('#form_tambah_supplier').addClass('was-validated');
  });

});




</script>
