<script type="text/javascript">

var table_histori_penjualan = $('#tabel_histori_penjualan').DataTable({
  processing:true,
  serverSide:true,
  order : [[ 0, "asc" ]],
  ajax: "{{ route('all.sales') }}",
  columns: [
    {data:'DT_RowIndex', name:'id'},
    {data:'customer.nama', name :'customer.nama'},
    {data:'invoice', name :'invoice'},
    {data:'created_at', name :'created_at'},
    {data:'grandtotal', name :'grandtotal'},
    {data:'employee.name', name :'employee.name'},
    {data:'action', name :'action', orderable:false, searchable:false}
  ],
  columnDefs: [
    { className: 'text-center', targets: [0, 2] },
    { render: $.fn.dataTable.render.number(".", ".", 0, 'Rp. '),  targets: [4] }
  ],
  dom: 'lBfrtip',
  buttons: [
          { extend: 'copy', className: 'btn btn-sm btn-dark' },
          { extend: 'excel', className: 'btn btn-sm btn-success' },
          { extend: 'pdf', className: 'btn btn-sm btn-danger' },
          { extend: 'print', className: 'btn btn-sm btn-info' }
      ],
});


function editSalesForm(id){
  $.ajax({
    url : "/create-sales/"+id,
    type : "GET",
    dataType : "JSON",
    success : function(data){
      location.href = "penjualan";
    }
  });

}

function deleteSalesForm(id){
  url_hapus_data = 'penjualan';
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

@if (Session::has('message'))
        $.notify("{{ session('message') }}",
          {
            align:"right", verticalAlign:"top",
            close: true, delay:3000,
            color: "#fff", background: "#28c341",
            icon:"check",
            blur: 0.2,
          });
@endif



</script>
