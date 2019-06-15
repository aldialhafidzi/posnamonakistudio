<script type="text/javascript">
  var row_bar = 1;
  var deskripsi_barang = $('.deskripsi-form-tambah-barang').html();
  var detail_barang = $('.detail-form-tambah-barang').html();

  $('.auto-save').savy('load');

  var table_master = $('#master-table').DataTable({
    processing:true,
    serverSide:true,
    order : [[ 0, "asc" ]],
    ajax: "{{ route('all.good') }}",
    columns: [
      {data:'DT_RowIndex', name:'id'},
      {data:'kode', name :'kode'},
      {data:'nama', name :'nama'},
      {data:'stok_unit', name :'stok_unit'},
      {data:'unit.nama', name :'unit.nama'},
      {data:'h_jual', name :'h_jual'},
      {data:'action', name :'action', orderable:false, searchable:false}
    ],
    columnDefs: [
      { className: 'text-center', targets: [0, 1, 3, 4, 6] },
      { render: $.fn.dataTable.render.number(".", ".", 0, 'Rp. '),  targets: [5] }
    ],
    dom: 'lBfrtip',
    buttons: [
            { extend: 'copy', className: 'btn btn-sm btn-dark' },
            { extend: 'excel', className: 'btn btn-sm btn-success' },
            { extend: 'pdf', className: 'btn btn-sm btn-danger' },
            { extend: 'print', className: 'btn btn-sm btn-info' }
        ],

  });




  function check_kode(x) {
    var div_nya = x.parentNode;
    var kode = $(div_nya).find('#g_kode').val();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
      url : '{{ route('check.kode') }}',
      type : 'POST',
      data : {'kode' : kode, '_token' : CSRF_TOKEN},
      dataType : 'JSON',
      success : function(data){
        if (data == 1){
          $('#g_kode_error').text('Kode sudah digunakan.');
          $(div_nya).find('#g_kode').addClass('is-invalid');
        }
        else {
          $('#g_kode_error').text('Harus diisi.');
          $(div_nya).find('#g_kode').removeClass('is-invalid');
        }
      }
    });

  }

  function deleteBarangForm(id){
    url_hapus_data = 'good';
    $('#hapus_data_id').val(id);
    $('input[name = _method]').val('DELETE');
  }


  function editBarangForm(id){
    save_method = 'edit';
    $('input[name = _method]').val('PATCH');
    $('#modal_tambah_barang form')[0].reset();
    $('.hapus-baris-barang').each(function(){
      if ($('.hapus-baris-barang').length > 1){
        hapusRowBarang(this);
        row_bar = 1;
      }
    });


    $.ajax({
      url : "{{ url('good') }}" + '/' + id + "/edit",
      type : "GET",
      dataType : "JSON",
      success : function(data){
        $('#modal_tambah_barang').modal('show');
        $('#judul_modal_tambah_barang').text('Edit Data Barang');
        $('#insert_data_barang').val('Update Data');
        $('#btn_newline_barang').hide();
        $('#HapusBaris').hide();

        $('#good_id').val(data.id);
        $('#g_kode').val(data.kode);
        $('#g_nama').val(data.nama);
        $('#g_kategori').val(data.kategori_id);
        $('#g_merek').val(data.merek_id);
        $('#g_h_jual').val(data.h_jual);
        $('#g_unit_awal').val(data.unit_awal);
        $('#g_min_qty').val(data.min_qty);
        $('#g_stok_unit').val(data.stok_unit);
        $('#g_unit_jual').val(data.unit_jual);


        if (data.cbo == "N") {
          $('#g_unit_beli').removeAttr('disabled');
          $('#g_h_beli').removeAttr('disabled');
          $('#g_unit_beli').val(data.unit_beli);
          $('#g_h_beli').val(data.h_beli);
        }
        else {
          $('#g_unit_beli').attr('disabled', 'disabled');
          $('#g_h_beli').attr('disabled', 'disabled');
        }


        for (var i = 0; i < data.detail_unit.length; i++) {
          if (data.detail_unit[i].unit_id = data.unit_jual){
            $('#g_du_qty').val(data.detail_unit[i].qty);
            break;
          }
        }

      },
      error : function(){
        alert("Not working properly!");
      }

    });
  }


  function tambahBarangForm(){
    console.log("ANJIR");
    save_method = 'add';
    $('input[name = _method]').val('POST');
    $('#judul_modal_tambah_barang').text('Tambah Data Barang');
    $('#modal_tambah_barang').modal('show');
    $('#insert_data_barang').val('Tambah Data');
    $('#modal_tambah_barang form')[0].reset();
    $('#btn_newline_barang').show();
    $('#HapusBaris').show();

    @if (!empty($cooc_barang) != "")
      row_bar = {{ count($cooc_barang->g_kode) }}
    @else
      $('.hapus-baris-barang').each(function(){
        if ($('.hapus-baris-barang').length > 1){
          hapusRowBarang(this);
          row_bar = 1;
        }
      });
    @endif
  }

  function tambahRowBarang(){
    var table = document.getElementById("tabel_tambah_barang");
    var row = table.insertRow(-1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);

    row_bar = row_bar + 1;

    cell1.innerHTML = '<p  class="number_rowBar" valign="center" align="center"> '+row_bar+' </p>';
    cell2.innerHTML = deskripsi_barang;
    cell3.innerHTML = detail_barang;
    cell4.innerHTML = '<button onclick="hapusRowBarang(this)" class="btn btn-danger btn-sm hapus-baris-barang" id="HapusBaris" style="color:#fff;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';

    $(row).find('#g_kode').val('');
    $(row).find('#g_nama').val('');
    $(row).find('#g_h_beli').val('');
    $(row).find('#g_h_jual').val('');
    $(row).find('#g_stok_unit').val('');
    $(row).find('#g_min_qty').val('');
    $(row).find('#g_du_qty').val('');
  }

  function hapusRowBarang(r) {
    var x = r.parentNode.parentNode.rowIndex;
    document.getElementById("tabel_tambah_barang").deleteRow(x);

    var no = 1;
    $('.number_rowBar').each(function(){
      $(this).html(no);
      no++;
    });

    row_bar--;

    if (row_bar < 1) {
      tambahRowBarang();
    }
  }




  $(document).ready(function(){

    $('.batal-tabel-tambah-barang').on('click', function () {
      $('#modal_tambah_barang').modal('show');
    });

    $('.hapus-tabel-tambah-barang').on('click', function(){
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
        url : '{{ route('hapus.cookie_barang') }}',
        type : 'POST',
        data : {'_token' : CSRF_TOKEN},
        success : function(data){
          location.reload();
        }
      });

    });

    $('.close-modal-barang').on('click', function(){
      $('#modal_tambah_barang').modal('hide');
    });

    $('.save-tabel-tambah-barang').on('click', function(){
      $('input[name = _method]').val('POST');
      $.ajax({
        url : '{{ route('good.save.form') }}',
        type : 'POST',
        data : new FormData($('#form_tambah_barang')[0]),
        contentType : false,
        processData : false,
        success : function(data){
          location.reload();
        },
        error : function (data){

        }
      });
    });

    $('#form_hapus_data').submit(function(event) {
      event.preventDefault();
      var id = $('#hapus_data_id').val();
      if (url_hapus_data == 'good') url = '{{ url('good') }}' + '/' + id;
      else if (url_hapus_data == 'combo') url = "{{ url('combo') . '/' }}" + id;
      else if (url_hapus_data == 'brand') url = '{{ url('brand') . '/' }}' + id;
      else if (url_hapus_data == 'category') url = '{{ url('category') . '/' }}' + id;
      else if (url_hapus_data == 'user') url = '{{ url('user') . '/' }}' + id;
      else if (url_hapus_data == 'penjualan') url = '{{ url('penjualan') . '/' }}' + id;
      else if (url_hapus_data == 'customer') url = '{{ url('customer') . '/' }}' + id;
      else if (url_hapus_data == 'pembelian') url = '{{ url('pembelian') . '/' }}' + id;
      else if (url_hapus_data == 'supplier') url = '{{ url('supplier') . '/' }}' + id;
      $.ajax({
        url : url,
        type : "POST",
        data : new FormData($('#form_hapus_data')[0]),
        contentType : false,
        processData : false,
        success : function(data){
          $('#modal_hapus_data').modal('hide');

          if(url_hapus_data == 'good'){
            table_master.ajax.reload();
          }
          else if(url_hapus_data == 'combo'){
            table_combo.ajax.reload();
          }
          else if(url_hapus_data == 'brand'){
            table_merek.ajax.reload();
          }
          else if(url_hapus_data == 'category'){
            table_kategori.ajax.reload();
          }
          else if(url_hapus_data == 'user'){
            table_user.ajax.reload();
          }
          else if(url_hapus_data == 'penjualan'){
            table_histori_penjualan.ajax.reload();
          }
          else if(url_hapus_data == 'pembelian'){
            table_histori_pembelian.ajax.reload();
          }
          else if(url_hapus_data == 'customer'){
            table_pelanggan.ajax.reload();
          }
          else if(url_hapus_data == 'supplier'){
            table_supplier.ajax.reload();
          }


          $.notify(" "+data.message,
            {
              align:"right", verticalAlign:"bottom",
              close: true, delay:3000,
              color: "#fff", background: "#41a845",
              icon:"check"
            });
        },
        error : function(data){
          $.notify("  Data gagal dihapus !",
            {
              align:"right", verticalAlign:"bottom",
              close: true, delay:3000,
              color: "#fff", background: "#c3383f",
              icon:"close"
            });
        }
      });
    });

    $('#form_tambah_barang').submit(function (event) {
      event.preventDefault();
      if ($('#form_tambah_barang')[0].checkValidity() === false) {
          event.stopPropagation();
      } else {
        var id = $('#good_id').val();
        if (save_method == 'add') url = "{{ url('good') }}";
        else url = "{{ url('good') . '/' }}" + id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#modal_tambah_barang form')[0]),
          contentType : false,
          processData : false,
          success : function(data){
            console.log(data);
            $('#modal_tambah_barang').modal('hide');
            table_master.ajax.reload();
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
      $('#form_tambah_barang').addClass('was-validated');
    });

  });



















</script>
