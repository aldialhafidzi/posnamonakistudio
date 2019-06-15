<script type="text/javascript">

var table_pelanggan = $('#tabel_pelanggan').DataTable({
  processing:true,
  serverSide:true,
  order : [[ 0, "asc" ]],
  ajax: "{{ route('all.customer') }}",
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

function editCustomerForm(id){
  save_method = 'edit';
  $('input[name = _method]').val('PATCH');
  $('#judul_modal_pelanggan').text('Edit Data Pelanggan');
  $('#insert_data_pelanggan').val('Edit Data');
  $('#form_tambah_pelanggan')[0].reset();
  $('#customer_id').val(id);
  $.ajax({
    url : "{{ url('customer') }}" + '/' + id + "/edit",
    type : "GET",
    dataType : "JSON",
    success : function(data){
      $('#customer_id').val(data.id);
      $('#form_tambah_pelanggan').find('#nama').val(data.nama);
      $('#form_tambah_pelanggan').find('#alamat').val(data.alamat);
      $('#form_tambah_pelanggan').find('#no_telp').val(data.no_telp);
      $('#modal_pelanggan').modal('show');
    }
  });
}

function deleteCustomerForm(id){
  url_hapus_data = 'customer';
  $('#hapus_data_id').val(id);
  $('input[name = _method]').val('DELETE');
}

function tambahCustomerForm(){
  save_method = 'add';
  $('input[name = _method]').val('POST');
  $('#judul_modal_pelanggan').text('Tambah Data Pelanggan');
  $('#insert_data_pelanggan').val('Tambah Data');
  $('#form_tambah_pelanggan')[0].reset();
}

$(document).ready(function(){

  $('#form_tambah_pelanggan').submit(function(e){
    e.preventDefault();
    if($('#form_tambah_pelanggan')[0].checkValidity() === false){
    }else {
      var id = $('#customer_id').val();
      if (save_method == 'add') url = "{{ url('customer') }}";
      else url = "{{ url('customer') . '/' }}" + id;
      $.ajax({
        url : url,
        type : "POST",
        data : new FormData($('#form_tambah_pelanggan')[0]),
        contentType : false,
        processData : false,
        success : function(data){
          $('#modal_pelanggan').modal('hide');
          $('#form_tambah_pelanggan')[0].reset();
          $('#modal_pelanggan').modal('hide');
          $.notify(" "+data.message,
            {
              align:"right", verticalAlign:"bottom",
              close: true, delay:3000,
              color: "#fff", background: "#41a845",
              icon:"check"
            });
            
            if (table_pelanggan != null) {
              table_pelanggan.ajax.reload();
            }
        },
        error : function(data){
          $.notify("  Data pelanggan gagal ditambahkan !!",
            {
              align:"right", verticalAlign:"bottom",
              close: true, delay:3000,
              color: "#fff", background: "#c3383f",
              icon:"close"
            });
        }
      });

    }
    $('#form_tambah_pelanggan').addClass('was-validated');
  });

});




</script>
