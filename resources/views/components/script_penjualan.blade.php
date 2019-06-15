<script type="text/javascript">

  var row_transaksi = 1;
  var data_cart = [];

  @if (!empty($carts))
    row_transaksi = {{ count($carts) }};
    @foreach ($carts as $key => $value)
      data_cart.push({{ $carts[$key]->good->id }});
    @endforeach
  @endif

  var p_field_kode = '<select required style="width : 120px;" onchange="check_detail_barang_penjualan(this)" onclick="check_list_barang_penjualan(this)" placeholder="Kode / Nama Barang" class="form-control " id="p_kode" name="p_kode[]"> </select> <input required class="" type="hidden" name="p_good_id[]" id="p_good_id" value="">';
  var p_field_nama = '<label class="" style="width : 150px;" scope="col" id="p_nama_good"></label>';
  var p_field_unit = '<select onchange="hitung_total()" required numa="1" name="p_unit_good[]" id="p_unit_good" class="form-control change_unit_tr"=""> </select> <input type="hidden" name="p_qty_unit[]" id="p_qty_unit" value="">';
  var p_field_qty = '<input onchange="hitung_total()" required  style="width:60px;" scope="col"  type="number" numa="1" class="form-control  qty_1 edit_qty_tr" id="p_qty_good" name="p_qty_good[]" style="width:60px;">';
  var p_field_harga = '<label style="width : 120px;" scope="col" class="" id="p_harga_good_label"> </label> <input class="" type="hidden" name="p_harga_good[]" id="p_harga_good" value="">';
  var p_field_potongan = '<input onchange="hitung_total()" type="number"  class=" form-control edit_potongan_tr potongan" id="p_potongan" name="p_potongan[]" style="width:100px;" value="">';
  var p_field_subtotal = '<label style="width : 120px;" scope="col" class="" id="p_subtotal_label"> </label><input type="hidden" class="subtotal" class="" name="p_subtotal[]" id="p_subtotal" value="">';

  var subtotal = 0;

  function updateTanggal() {
      var now = new Date(),
          months = ['01', '02', '03' ,
                    '04', '05', '06',
                    '07', '08', '09',
                    '10', '11', '12'];
          time = now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds();
          date = [now.getFullYear(),months[now.getMonth()],now.getDate()].join('-');
      $('#datetimepicker').val([date, time].join('   '));
      $('#tanggal_waktu').val($('#datetimepicker').val());
      $('#tanggal_transaksi').val(date);
      setTimeout(updateTanggal, 1000);
  }

  function hitung_total()
  {
    subtotal = 0;
    $('.subtotal').each(function(){

      var tr_ = this.parentNode.parentNode.parentNode;

      var harga    = 0;
      var unit_qty = 0;
      var req_qty  = 0;
      var potongan = 0;

      if ( $(tr_).find('#p_unit_good option:selected').attr('qty') != '' ) {
        unit_qty = $(tr_).find('#p_unit_good option:selected').attr('qty');
        $(tr_).find('#p_qty_unit').val(unit_qty);
      }

      if ( $(tr_).find('#p_potongan').val() != '' ) {
        potongan = $(tr_).find('#p_potongan').val();
      }

      if ( ($(tr_).find('#p_qty_good').val() != '') && (parseInt($(tr_).find('#p_qty_good').val()) > 0) ) {
        req_qty  = $(tr_).find('#p_qty_good').val();
      }

      else if ( parseInt($(tr_).find('#p_qty_good').val()) < 1 ){
        req_qty = 1;
        $(tr_).find('#p_qty_good').val('1');
      }

      if( $(tr_).find('#p_harga_good').val() != '' ){
        harga    = $(tr_).find('#p_harga_good').val();
      }

      var new_harga = parseInt(harga) * unit_qty * parseInt(req_qty);
      var sub_ = parseInt(harga) * unit_qty * parseInt(req_qty) - parseInt(potongan);

      subtotal  = subtotal +  sub_;

      $(tr_).find('#p_harga_good_label').html('Rp. ' + parseInt(harga).toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.")+',-');
      $(tr_).find('#p_subtotal').val(sub_);
      $(tr_).find('#p_subtotal_label').html('Rp. ' + parseInt(sub_).toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.")+',-');

    });

    $('#grandtotal_label').html('Rp. ' + parseInt(subtotal).toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.")+',-');
    $('#grandtotal').val(subtotal);
  }


  function hapusRowTransaksi(r) {
    var table_row = r.parentNode.parentNode;
    var x = r.parentNode.parentNode.rowIndex;

    for (var i = 0; i < data_cart.length; i++) {
      if(data_cart[i] == parseInt($(table_row).find('#p_good_id').val())){
        if (i > -1) {
          data_cart.splice([i], 1);
          break;
        }
      }
    }

    document.getElementById("tabel_transaksi").deleteRow(x-1);

    hitung_total();

    var no = 1;
    $('.baris-tr').each(function() {
      $(this).html(no);
      no++;
    });

    row_transaksi--;

    if(row_transaksi < 1){
      tambahRowTransaksi();
    }


  }

function tambahRowTransaksi() {

  row_transaksi ++;

  var table = document.getElementById("tabel_transaksi");

  var row = table.insertRow(-1);
  var cell1 = row.insertCell(0);
  var cell2 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell4 = row.insertCell(3);
  var cell5 = row.insertCell(4);
  var cell6 = row.insertCell(5);
  var cell7 = row.insertCell(6);
  var cell8 = row.insertCell(7);
  var cell9 = row.insertCell(8);

  cell1.innerHTML = '<div style="width : 30px;" class="baris-tr" valign="center" align="center">'+row_transaksi+'</div>';
  cell2.innerHTML = '<div class="p-field-kode">'+p_field_kode+'</div>';
  cell3.innerHTML = '<div class="p-field-nama">'+p_field_nama+'</div>';
  cell4.innerHTML = '<div class="p-field-unit">'+p_field_unit+'</div>';
  cell5.innerHTML = '<div class="p-field-qty">'+p_field_qty+'</div>';
  cell6.innerHTML = '<div class="p-field-harga">'+p_field_harga+'</div>';
  cell7.innerHTML = '<div class="p-field-potongan">'+p_field_potongan+'</div>';
  cell8.innerHTML = '<div class="p-field-subtotal">'+p_field_subtotal+'</div>';
  cell9.innerHTML = '<button onclick="hapusRowTransaksi(this)" class="btn btn-danger btn-sm" id="HapusBaris"  style="color:#fff;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';

  $(row).find('#p_kode').click();
}



function check_detail_barang_penjualan(x)
{
  $(x).on('select2:select', function (e) {

    var div_nya = e.currentTarget.parentElement.parentNode.parentNode;
    var tr_ = e.currentTarget.parentElement.parentNode.parentNode;
    var data = e.params.data;
    var id = data.good_id;

    if($(tr_).find('#p_kode').val() != ""){
      if(id != $(tr_).find('#p_kode').val()){
        for (var i = 0; i < data_cart.length; i++) {
          if(data_cart[i] == parseInt($(tr_).find('#p_good_id').val())){
            if (i > -1) {
              data_cart.splice([i], 1);
              break;
            }
          }
        }
      }
    }

    $(tr_).find('#p_good_id').val(data.good_id);
    $(tr_).find('#p_nama_good').html(data.text);
    var detail_unit = data.detail_unit;

    var option_unit = '';
    var qty_unit = 0;
    for (var i = 0; i < detail_unit.length; i++) {
      if (data.unit.id == detail_unit[i].unit_id) {
        option_unit = option_unit + '<option qty="'+detail_unit[i].qty+'" selected value="'+detail_unit[i].unit_id+'">'+detail_unit[i].unit.nama+'</option>';
        qty_unit = detail_unit[i].qty;
      } else {
        option_unit = option_unit + '<option qty="'+detail_unit[i].qty+'" value="'+detail_unit[i].unit_id+'">'+detail_unit[i].unit.nama+'</option>';
      }
    }

    $(tr_).find('#p_unit_good').html(option_unit);
    $(tr_).find('#p_qty_good').val('1');
    $(tr_).find('#p_harga_good_label').html('Rp. ' + parseInt(data.h_jual).toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
    $(tr_).find('#p_harga_good').val(data.h_jual);
    $(tr_).find('#p_subtotal').val(data.h_jual);
    $(tr_).find('#p_subtotal_label').html('Rp. ' + parseInt(data.h_jual).toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.")+',-');

    hitung_total();


    function removeDuplicates(arr){
        let unique_array = [];
        for(let i = 0;i < arr.length; i++){
            if(unique_array.indexOf(arr[i]) == -1){
                unique_array.push(arr[i]);
            }
        }
        return unique_array;
    }

    data_cart.push(data.good_id);
    data_cart = removeDuplicates(data_cart);

  });
}

function check_list_barang_penjualan(x)
{
  $(x).select2({
      ajax: {
      url: '/all/good_detail',
      dataType: 'json',
      delay: 250,
      data: function (params) {
        var z = parseInt($(x).attr('baris'));
        return {
          q: params.term,
          page: params.page,
          temp: data_cart
        };
      },
      processResults: function (data, params) {
        params.page = params.page || 1;
        return {
          results: data,
          pagination: {
            more: (params.page * 30) < data.total_count
          }
        };
      },
      cache: true
    },
    placeholder: 'Kode / Nama Barang',
    escapeMarkup: function (markup) { return markup; },
    templateResult: formatRepo,
    templateSelection: formatRepoSelection,
    dropdownCssClass : 'bigdrop',
    theme : "bootstrap",
    width: 'element'
  });
}


function check_detail_customer(x)
{
  $(x).on('select2:select', function (e) {
    var data = e.params.data;

    $('#nomor_hp').val(data.no_telp);
    $('#alamat_cust').val(data.alamat);
  });
}

function check_list_customer(x)
{
  $(x).select2({
      ajax: {
      url: '/all/find_customer',
      dataType: 'json',
      delay: 250,
      data: function (params) {
        return {
          q: params.term,
          page: params.page
        };
      },
      processResults: function (data, params) {
        params.page = params.page || 1;
        return {
          results: data,
          pagination: {
            more: (params.page * 30) < data.total_count
          }
        };
      },
      cache: true
    },
    placeholder: 'Pilih Pelanggan',
    // escapeMarkup: function (markup) { return markup; },
    // templateResult: formatRepo,
    // templateSelection: formatRepoSelection,
    theme : "bootstrap",
    width: 'element'
  });
}

function download_excel(location)
{
  this.document.location.href = location;
}

@if (Session::has('invoice'))
  $('.link-download-excel').click();
@endif

@if (Session::has('laporan_barang'))
  $('.link-download-excel').click();
@endif

$(document).ready(function(){


  $('#p_kode').click();
  $('#id_customer').click();
  $('#CetakStruk').on('click', function(){
    $('#cetak_invoice').val('200OK');
  });
  updateTanggal();

  $('#add_pelanggan_baru').on('click', function(){
    save_method = 'add';
    $('input[name = _method]').val('POST');
    $('#judul_modal_pelanggan').text('Tambah Data Pelanggan');
    $('#insert_data_pelanggan').val('Simpan');
    $('#form_tambah_pelanggan')[0].reset();
  });



});

@if ($errors->any())
            @foreach ($errors->all() as $error)
                $.notify("{{ $error }}",
                  {
                    align:"center", verticalAlign:"top",
                    close: true, delay:3000,
                    color: "#fff", background: "#c3383f",
                    icon:"close",
                    blur: 0.2,
                  });
            @endforeach
@endif

@if (Session::has('status_penjualan'))
        $.notify("{{ session('status_penjualan') }}",
          {
            align:"right", verticalAlign:"top",
            close: true, delay:3000,
            color: "#fff", background: "#28c341",
            icon:"check",
            blur: 0.2,
          });
@endif
















</script>
