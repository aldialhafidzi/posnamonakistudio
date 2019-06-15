var tot_belanja = 0;
var row_tr = 1;
var urutan = "";
var array_kode_barang = [];
var array_nama_barang = [];
var array_stok_barang = [];
var array_kode_barang_src = [];
var array_nama_barang_src = [];
var array_stok_barang_src = [];
var all_item = [];
var all_unit = [];
var items_barang = [];

var items_combo = [];
var detail_item_combo = [];

var cache_click_item = '';
var mereknya = '';
var kategorinya = '';
var unitnya = '';
var cek = 'OK';
// =====================================================================

// DEFINE FUNCTIONS
  // CEK ITEM COMBO
  function cekItemCombo() {
    $.ajax({
            url: 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax.php?ajax=cek-item-combo',
            method: 'POST',
            data: {'search': 1},
            dataType: 'JSON',
            success: function (data) {
              detail_item_combo = data;
              console.log(detail_item_combo);
            },
        });
  }
  // AKHIR CEK ITEM COMBO
  // CEK ALL COMBO
  function cekAllCombo() {
    $.ajax({
            url: 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax.php?ajax=cek-all-combo',
            method: 'POST',
            data: {'search': 1},
            dataType: 'JSON',
            success: function (data) {
              items_combo = data;
              console.log(items_combo);
            },
        });
  }
  // AKHIR CEK ALL COMBO
  // CEK ALL BARANG
  function cekAllBarang() {
    $.ajax({
            url: 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax.php?ajax=cek_all_barang',
            method: 'POST',
            data: {'search': 1},
            dataType: 'JSON',
            success: function (data) {
              all_item = data;
              array_kode_barang = [];
              array_nama_barang = [];
              array_kode_barang_src = [];
              array_nama_barang_src = [];
              array_stok_barang = [];
              all_item.forEach(function(e) {
                array_kode_barang.push(e.kode);
                array_nama_barang.push(e.nama);
                array_stok_barang.push(e.stok_unit);
                array_kode_barang_src.push(e.kode.toLowerCase());
                array_nama_barang_src.push(e.nama.toLowerCase());
              });
              items_barang = [];
              for (var j = 0; j < array_kode_barang.length; j++) {
                items_barang.push([ array_kode_barang[j],array_nama_barang[j],array_stok_barang[j] ]);
              }
            },
        });
  }
  // AKHIR CEK ALL BARANG

  // CEK ALL KATEGORI
  function cekAllKategori(){
    $.ajax({
      url:"http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax.php?ajax=cek_all_kategori",
      method:"POST",
      data:{'cek':cek},
      dataType:"JSON",
      success:function(data){
        kategorinya = data.allkategori;
      }
    });
  }
  // AKHIR CEK ALL KATEGORI

  // FUNGSI CEK ALL UNIT
  function cekAllUnit(){
    $.ajax({
      url:"http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax.php?ajax=cek-all-unit",
      method:"POST",
      data:{'search':cek},
      dataType:"JSON",
      success:function(data){
        all_unit = data;
      }
    });
  }
  // AKHIR FUNGSI CEK ALL UNIT

  // FUNGSI CEK ALL MEREK
  function cekAllMerek() {
    $.ajax({
      url:"http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax.php?ajax=cek_all_merek",
      method:"POST",
      data:{'cek':cek},
      dataType:"JSON",
      success:function(data){
        mereknya = data.allmerek;
      }
    });
  }
  // AKHIR FUNGSI CEK ALL MEREK

  // FUNGSI UPDATE INVOICE
  function updateNota(){
    var okay = "Ok";
    var now = new Date(),
        months = ['I', 'II', 'III' ,
                  'IV', 'V', 'VI',
                  'VII', 'VIII', 'IX',
                  'X', 'XI', 'XII'];
    var m = months[now.getMonth()];
    var y = now.getFullYear();
    $.ajax({
      url:"http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax.php?ajax=cek_LastCust",
      method:"POST",
      data : {'okay':okay,'month':m, 'year':y},
      dataType : 'JSON',
      success:function(data)
      {
        $("#nomor_nota").val(data.lastCustHex);
      }
    });
  }
  // AKHIR FUNGSI UPDATE INVOICE

  // FUNGSI TAMBAH ROW TRANSAKSI
  function tambahRowTransaksi() {
    row_tr ++;
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

    cell1.innerHTML = '<div style="width : 30px; color :#212529;" class="baris-tr" id="number" valign="center" align="center">'+row_tr+'</div> <input type="hidden" form="form_transaksi" name="cbo[]" id="cbo" value="">';
    cell2.innerHTML = '<div class="ui-widget coeg"><input autocomplete="off" form="form_transaksi" type="hidden" name="id_barang[]" id="id_barang" value=""><input autocomplete="off" form="form_transaksi" numa="" style="width : 200px;"  type="text" class="keyUpEx click_kode_br form-control" id="hintkode" name="hintkode[]" autocomplete="off" placeholder="Ketik Kode / Nama Barang" required></div><div id="response" class="panel-default response_TR" style="width:300px; overflow: auto;     position: absolute; z-index: 1; display: block; max-height: 400px;"></div>';
    cell3.innerHTML = '<label style="color :#212529; width: 150px;" id="label_nama"> </label>';
    cell4.innerHTML = '<input autocomplete="off" form="form_transaksi" type="hidden" id="base_unit" name="base_unit[]" value=""><input autocomplete="off" form="form_transaksi" type="hidden" id="qty_unit" name="qty_unit[]" value=""><select form="form_transaksi" numa="" name="unit[]" id="unit" class="form-control  change_unit_tr" required=""></select>';
    cell5.innerHTML = '<input autocomplete="off" form="form_transaksi" disabled style="width:60px;" type="number" numa="" class="form-control  qty_disabled edit_qty_tr" id="jumlah_beli" name="jumlah_beli[]" >';
    cell6.innerHTML = '<label style="width : 100px; color :#212529;"   id="label_harga"> </label><input autocomplete="off" form="form_transaksi" type="hidden" id="harga_barang" name="harga_barang[]" value=""> <input autocomplete="off" form="form_transaksi" type="hidden" id="stok_barang" name="stok_barang[]" value="">';
    cell7.innerHTML = '<input autocomplete="off" type="number" form="form_transaksi" style="width:100px;" id="potongan" name="potongan[]" disabled  class="form-control edit_potongan_tr potongan" name="" value="">';
    cell8.innerHTML = '<label style="width : 120px; color :#212529;"    id="label_subtotal"> </label> <input autocomplete="off" form="form_transaksi" type="hidden" class="subtotal" id="sub_total" name="sub_total[]">';
    cell9.innerHTML = '<button onclick="hapusRowTransaksi(this)" class="btn btn-danger btn-sm" id="HapusBaris"  style="color:#fff;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
    // munKeyUp();
    // mundiklik();
  }
  // AKHIR FUNGSI TAMBAH ROW TRANSAKSI


  // FUNGSI HAPUS ROW TRANSAKSI
  function hapusRowTransaksi(r) {
    var table_row = r.parentNode.parentNode;
    var x = r.parentNode.parentNode.rowIndex;
    var xx = row_tr;
    var kode_in = $(table_row).find("#hintkode").val();
    var nama_in = $(table_row).find('#label_nama').text();
    var stok_in = $(table_row).find('#stok_barang').val();


    if((kode_in !='') && (nama_in !='') && (stok_in != '')){
      array_nama_barang.push(nama_in);
      array_kode_barang.push(kode_in);
      array_stok_barang.push(stok_in);

      array_nama_barang_src.push(nama_in.toLowerCase());
      array_kode_barang_src.push(kode_in.toLowerCase());
      array_stok_barang_src.push(stok_in.toLowerCase());
      items_barang.push([ kode_in, nama_in, stok_in ]);
    }

    document.getElementById("tabel_transaksi").deleteRow(x-1);
    var no = 1;
    $('.baris-tr').each(function() {
      $(this).html(no);
      no++;
    });

    row_tr--;
    hitung_total_belanja();

    if(xx == 1){
      tambahRowTransaksi();
    }
  }
  // AKHIR FUNGSI HAPUS ROW TRANSAKSI

  // FUNGSI UPDATE TANGGAL
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
  // AKHIR FUNGSI UPDATE TANGGAL

  // FUNGSI HITUNG TOTAL BELANJA
  function hitung_total_belanja() {

    var total = 0;
    $('.subtotal').each(function (e) {
      value = parseInt($(this).val());
      if($(this).val() == ''){
        value = 0;
      }
      total = total + parseInt(value);
    });

    var potongan = 0;
    $('.potongan').each(function(e) {
      value = parseInt($(this).val());
      if($(this).val() == ''){
        value = 0;
      }
      total = total - parseInt(value);
    });

      $('#total_belanjaNya').val(total);
      var tot_currency = 'Rp. ' + total.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
      $("#total_belanja").html("Total : "+tot_currency+",-");
  }
  // AKHIR FUNGSI HITUNG TOTAL BELANJA

// END OF DEFINE FUNCTIONS

// ========================================= EXECUTE
$(document).ready(function() {
  cekAllCombo();
  cekItemCombo();
  cekAllBarang();
  cekAllUnit();
  cekAllMerek();
  updateNota();
  cekAllKategori();
  updateTanggal();
  // munKeyUp();
  // mundiklik();


  // KEYUP HINTKODE
  $(document).on('keyup','#hintkode', function (e) {
    var parent_table = this.parentNode.parentNode.parentNode;
    resp = $(parent_table).find(".response_TR");
    var query = $(this).val();
    if (query.length > 0) {

      var re = new RegExp(query,"g");
      var arr2_kode_barang = [];
      var arr2_nama_barang = [];
      var arr2_stok_barang = [];
      var arr2_items_barang = [];

      for (var j = 0; j < array_kode_barang.length; j++) {
        var matches_array_kode = array_kode_barang_src[j].match(re);
        var matches_array_nama = array_nama_barang_src[j].match(re);

        var matches_array_kode_upper = array_kode_barang[j].match(re);
        var matches_array_nama_upper = array_nama_barang[j].match(re);
        if((matches_array_kode != null) || (matches_array_kode_upper != null)){
          arr2_items_barang.push([ items_barang[j][0], items_barang[j][1], items_barang[j][2] ]);
        }
        else if((matches_array_nama != null) || (matches_array_nama_upper != null)){
          arr2_items_barang.push([ items_barang[j][0], items_barang[j][1], items_barang[j][2] ]);
        }
      }
      if(arr2_items_barang != ''){
        $.ajax({
                url: 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax.php?ajax=gethint_input',
                method: 'POST',
                data: {'items_barang' : arr2_items_barang},
                dataType: 'JSON',
                success: function (data) {
                    resp.html(data.response);
                },
            }
        );
      }
      else {
        resp.html("");
      }
    }
    else {
      $(this).click();
    }
  });
  // AKHIR KEYUP HINTKODE

  // KLIK HINTKODE
  $(document).on('click','#hintkode', function(e) {
    var parent_table = this.parentNode.parentNode.parentNode;

    num = $(this);
    query = $(this).val();
    resp = $(parent_table).find(".response_TR");

    var re = new RegExp(query,"g");
    var arr2_kode_barang = [];
    var arr2_nama_barang = [];
    var arr2_stok_barang = [];
    var arr2_items_barang = [];
    for (var j = 0; j < array_kode_barang.length; j++) {
      var matches_array_kode = array_kode_barang_src[j].match(re);
      var matches_array_nama = array_nama_barang_src[j].match(re);
      var matches_array_kode_upper = array_kode_barang[j].match(re);
      var matches_array_nama_upper = array_nama_barang[j].match(re);
      if((matches_array_kode != null) || (matches_array_kode_upper != null)){
        arr2_items_barang.push([ items_barang[j][0], items_barang[j][1], items_barang[j][2] ]);
      }
      else if((matches_array_nama != null) || (matches_array_nama_upper != null)){
        arr2_items_barang.push([ items_barang[j][0], items_barang[j][1], items_barang[j][2] ]);
      }
    }
    if(arr2_items_barang != ''){
      $.ajax({
              url: 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax.php?ajax=gethint_input',
              method: 'POST',
              data: {'items_barang' : arr2_items_barang, 'items_combo' : items_combo, 'all_item' : all_item, 'detail_item_combo' : detail_item_combo},
              dataType: 'JSON',
              success: function (data) {
                resp.html(data.response);
              },
          }
      );
    }
    else {
      $("#response").html("");
    }
  });
  // AKHIR KLIK HINTKODE

  // HILANGKAN RESPONSE
  $('body').click(function(evt){
      if(!$(evt.target).is('.cek_br_tr')) {
          $('.response_TR').each(function(ex) {
            $(this).html("");
          });
      }
  });
  // AKHIR HILANGKAN RESPONSE

  // OUT FOCUS INPUT KODE BARANG
  $('.click_kode_br').focusout(function(){
    cache_click_item = '';
    console.log(cache_click_item);
  });
  // AKHIR OUT FOCUS INPUT KODE BARANG
  // FUNGSI KEYBOARD
  $('body').on('keyup', function (e){
    if(e.key == "F7"){
      tambahRowTransaksi();
    }
  });
  // AKHIR FUNGSI KEYBOARD

  // TAMBAH CUSTOMER
  $("#add_pelanggan_baru").on('click', function(event){
    $("#add_dataPelanggan").modal('show');
  });

  // KLIK LIST RESPONSE
  $(document).on('click', '.cek_br_tr', function (e) {
    var rowTable = this.parentNode.parentNode.parentNode.parentNode.parentNode;
    console.log(rowTable);
    var kode = $(this).attr('id');
    cache_click_item = kode;

    var data_item = [];
    all_item.forEach(function(e) {
      if(kode == e.kode){
        data_item.push(e);
      }
    });

    for (var j = 0; j < items_barang.length; j++)
     if (items_barang[j][0] === kode) {
        items_barang.splice(j, 1);
        array_kode_barang.splice(j, 1);
        array_nama_barang.splice(j, 1);
        array_stok_barang.splice(j, 1);

        array_kode_barang_src.splice(j, 1);
        array_nama_barang_src.splice(j, 1);
        array_stok_barang_src.splice(j, 1);

        break;
     }


    $(rowTable).find('#hintkode').val(data_item[0].kode);
    // CEK DATA UNIT
    var data_unit = [];
    all_unit.forEach(function (e) {
      if(kode == e.kode){
        data_unit.push(e);
      }
    });

    var value_unit = 0;
    var json_unit = '';
    data_unit.forEach(function (e) {
      if(data_item[0].unit_awal == e.unit_id){
        json_unit +='<option  value="'+e.unit_id+'" selected>'+e.n_unit+'</option>';
        value_unit = e.qty;
      }
      else {
        json_unit +='<option  value="'+e.unit_id+'">'+e.n_unit+'</option>';
      }
    });

    $(rowTable).find("#unit").html(json_unit);
    $(rowTable).find("#hintkode").removeClass("is-invalid");
    $(rowTable).find("#kode_barang_error").html("");

    var harga = parseInt(data_item[0].h_jual);
    var harga_currency = 'Rp. ' + harga.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");

    $(rowTable).find("#id_barang").val(data_item[0].id);
    $(rowTable).find("#label_nama").html(data_item[0].nama);
    $(rowTable).find("#harga_barang").val(harga);
    $(rowTable).find("#label_harga").html(harga_currency);
    $(rowTable).find("#stok_barang").val(data_item[0].stok_unit);
    $(rowTable).find("#jumlah_beli").prop("disabled", false);
    $(rowTable).find("#potongan").prop("disabled",false);
    $(rowTable).find('#cbo').val(data_item[0].cbo);
    $(rowTable).find("#qty_unit").val(value_unit);
    $(rowTable).find('#base_unit').val(value_unit);
    $(rowTable).find("#jumlah_beli").val(1);
    $(rowTable).find("#jumlah_beli").focus();

    var qty = $(rowTable).find("#jumlah_beli").val();
    var subtotal = qty * harga;
    var sub_currency = 'Rp. ' + subtotal.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");

    $(rowTable).find("#sub_total").val(data_item[0].h_jual);
    tot_belanja = tot_belanja + subtotal;
    $(rowTable).find("#label_subtotal").html(sub_currency);

    hitung_total_belanja();


    $(rowTable).find("#response").html("");


  });
  // AKHIR KLIK LIST RESPONSE

  // EDIT ITEM TRANSAKSI
  $(document).on('input','.edit_potongan_tr',function(){
    hitung_total_belanja();
  });

  $(document).on('change','.change_unit_tr',function(){
    var yg_mana = $(this).attr('numa');
    var unit_tr = $("#unit"+yg_mana).val();
    var kode_barang = $("#hintkode"+yg_mana).val();
    var qty = $("#jumlah_beli"+yg_mana).val();
    $.ajax({
      url : 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax.php?ajax=cek_unit_tr',
      method : 'POST',
      data : {'k_bar':kode_barang, 'u_bar':unit_tr},
      dataType : 'JSON',
      success : function(data){
        $("#qty_unit"+yg_mana).val(data.value_unit);
        var h_unit = parseInt($("#harga_barang"+yg_mana).val()) *  (parseInt($("#qty_unit"+yg_mana).val()) / parseInt($("#base_unit"+yg_mana).val()));
        var h_currency = 'Rp. ' + h_unit.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
        $("#label_harga"+yg_mana).html(h_currency);
        var sub_unit = parseInt(h_unit) * parseInt(qty);
        var s_currency = 'Rp. ' + sub_unit.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
        $("#label_subtotal"+yg_mana).html(s_currency);
        $("#sub_total"+yg_mana).val(sub_unit);
        hitung_total_belanja();
      }
    });
  });

  $(document).on('input','.edit_qty_tr',function(){
    var yg_mana = $(this).attr('numa');
    var qty = $("#jumlah_beli"+yg_mana).val();
    var h_unit = parseInt($("#harga_barang"+yg_mana).val()) *  (parseInt($("#qty_unit"+yg_mana).val()) / parseInt($("#base_unit"+yg_mana).val()));

    var sub_unit = parseInt(h_unit) * parseInt(qty);
    $("#sub_total"+yg_mana).val(sub_unit);
    // console.log("TEST");
    hitung_total_belanja();
  });
  // AKHIR EDIT ITEM TRANSAKSI

  // PILIH COSTOMER
  $(document).on('change','#id_customer',function(event){
    event.preventDefault();
    var idNya = $(this).find(":selected").val();
    $.ajax({
      type: "POST",
      url: 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax.php?ajax=cek_detail_pelanggan',
      data: { idNya : idNya },
      dataType : "JSON",
      success: function(data)
      {
        $('#alamat_cust').val(data.alamat);
        $("#nomor_hp").val(data.nomor_hp);
      }
    });
  });
  // AKHIR PILIH CUSTOMER

  // PILIH USER
  $(document).on('change','#id_kasir',function(event){
    event.preventDefault();
    var id_kasir = $(this).find(":selected").val();
    $.ajax({
      type: "POST",
      url: 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax.php?ajax=session_kasir',
      data: { 'id_kasir' : id_kasir },
      success: function(data)
      {
        // DO SOMETHING
      }
    });
  });
  // AKHIR PILIH USER

  // PEMBAYARAN
  $(document).on('input','#UangCash',function(){
    hitung_total_belanja();
  });
  // AKHIR PEMBAYARAN

  // SUKSES TRANSAKSI
  $('#transaksi_sukses').on('click', function(){
    $("#transaksi_sukes").modal('hide');
     $('#form_transaksi')[0].reset();
    location.reload();
  });

  $('#transaksi_sukses').on('hidden.bs.modal', function () {
     $('#form_transaksi')[0].reset();
    location.reload();
  });
  // AKHIR SUKSES TRANSAKSI

});
