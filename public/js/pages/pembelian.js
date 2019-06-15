// DEFINE VARIABEL
var row_p = 1;
var row_bar = 1;
var tot_pembelian = 0;
var urutan = "";
var array_kode_barang = [];
var array_nama_barang = [];
var array_stok_barang = [];
var cache_click_item = '';

var array_kode_barang_src = [];
var array_nama_barang_src = [];
var array_stok_barang_src = [];
var all_item = [];
var all_unit = [];
var all_master_unit = [];
var items_barang = [];
// AKHIR DEFINE VARIABEL


// FUNGSI UPDATE TANGGAL
function updateTanggal() {
  var now = new Date(),
    months = ['01', '02', '03',
      '04', '05', '06',
      '07', '08', '09',
      '10', '11', '12'
    ];
  time = now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds();
  date = [now.getFullYear(), months[now.getMonth()], now.getDate()].join('-');
  $('#datetimepicker').val([date, time].join('   '));
  $('#tanggal_waktu').val($('#datetimepicker').val());
  $('#tanggal_pembelian').val(date);
  setTimeout(updateTanggal, 1000);
}
// AKHIR FUNGSI UPDATE TANGGAL

// FUNGSI UPDATE NOMOR PEMBELIAN
function updateNoPembelian() {
  var okay = "Ok";
  var now = new Date(),
    months = ['I', 'II', 'III',
      'IV', 'V', 'VI',
      'VII', 'VIII', 'IX',
      'X', 'XI', 'XII'
    ];
  var m = months[now.getMonth()];
  var y = now.getFullYear();
  $.ajax({
    url: "http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax-pembelian.php?ajax-pembelian=cek-last-pembelian",
    method: "POST",
    data: {
      'okay': okay,
      'month': m,
      'year': y
    },
    dataType: 'JSON',
    success: function(data) {
      $("#inv_pembelian").val(data.lastCustHex);

    }
  });
}
// AKHIR FUNGSI UPDATE NOMOR PEMBELIAN
function cekAllUnit() {
  $.ajax({
    url: 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax.php?ajax=cek-all-unit',
    method: 'POST',
    data: {
      'search': 1
    },
    dataType: 'JSON',
    success: function(data) {
      all_unit = data;
    },

  });
}
// FUNGSI CEK ALL UNIT


function cekMasterUnit() {
  $.ajax({
    url: 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax.php?ajax=cek-master-unit',
    method: 'POST',
    data: {
      'search': 1
    },
    dataType: 'JSON',
    success: function(data) {
      all_master_unit = data;
    },

  });
}

// FUNGSI CEK ALL BARANG
function cekAllBarang() {
  $.ajax({
    url: 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax-pembelian.php?ajax-pembelian=cek_all_barang',
    method: 'POST',
    data: {
      'search': 1
    },
    dataType: 'JSON',
    success: function(data) {
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
      console.log(array_kode_barang_src);

      items_barang = [];
      for (var j = 0; j < array_kode_barang.length; j++) {
        items_barang.push([array_kode_barang[j], array_nama_barang[j], array_stok_barang[j]]);
      }
    },

  });
}
// AKHIR FUNGSI CEK ALL BARANG

// FUNGSI TAMBAH ROW BARANG PEMBELIAN
function tambahRowBarangPembelian() {
  var table = document.getElementById("tabel_tambah_barang");
  row_bar = row_bar + 1;
  console.log(row_bar);
  var row = table.insertRow(-1);
  var cell1 = row.insertCell(0);
  var cell2 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell4 = row.insertCell(3);

  $.ajax({
    url: "http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax-pembelian.php?ajax-pembelian=tambah-row-barang",
    method: "POST",
    data: {
      'row_bar': row_bar,
      'kategorinya': kategorinya,
      'mereknya': mereknya,
      'unitnya': unitnya
    },
    dataType: "JSON",
    success: function(data) {
      cell1.innerHTML = '<p  id="number_rowBar" valign="center" align="center"> ' + row_bar + ' </p>';
      cell2.innerHTML = data.deskripsi;
      cell3.innerHTML = data.detail;
      cell4.innerHTML = '<button onclick="hapusRowBarangPembelian(this)" class="btn btn-danger btn-sm" id="HapusBaris" style="color:#fff;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
    }
  });

}
// AKHIR FUNGSI TAMBAH ROW BARANG PEMBELIAN

// FUNGSI HAPUS ROW BARANG PEMBELIAN
function hapusRowBarangPembelian(r) {
  var x = r.parentNode.parentNode.rowIndex;
  document.getElementById("tabel_tambah_barang").deleteRow(x);

  var afterx = x + 1;
  var changeNumber = row_bar;

  while (x < changeNumber) {
    $('#number_rowBar' + afterx).text('' + x);
    var newidrow = 'number_rowBar' + x;

    var newidkode_brg = 'kode' + x;
    var newidnama_brg = 'nama' + x;
    var newidkategori_brg = 'kategori' + x;
    var newidmerek_brg = 'merek' + x;
    var newidunit_brg = 'unit' + x;
    var newidstok_brg = 'stok' + x;
    var newidharga_brg = 'harga' + x;

    $('#kode' + afterx).attr('name', newidkode_brg);
    $('#nama' + afterx).attr('name', newidnama_brg);
    $('#kategori' + afterx).attr('name', newidkategori_brg);
    $('#merek' + afterx).attr('name', newidmerek_brg);
    $('#unit' + afterx).attr('name', newidunit_brg);
    $('#stok' + afterx).attr('name', newidstok_brg);
    $('#harga' + afterx).attr('name', newidharga_brg);

    $('#kode' + afterx).attr('id', newidkode_brg);
    $('#nama' + afterx).attr('id', newidnama_brg);
    $('#kategori' + afterx).attr('id', newidkategori_brg);
    $('#merek' + afterx).attr('id', newidmerek_brg);
    $('#stok' + afterx).attr('id', newidstok_brg);
    $('#unit' + afterx).attr('id', newidunit_brg);
    $('#harga' + afterx).attr('id', newidharga_brg);

    $('#number_rowBar' + afterx).attr('id', newidrow);
    x++;
    afterx++;
  }
  row_bar--;
}
// AKHIR FUNGSI HAPUS ROW BARANG PEMBELIAN


// FUNGSI HITUNG TOTAL PEMBELIAN
function hitung_total_pembelian() {
  var total = 0;

  $('.subtotal').each(function(e) {
    value = parseInt($(this).val());
    if ($(this).val() == '') {
      value = 0;
    }
    total = total + parseInt(value);
  });

  var potongan = 0;
  $('.potongan').each(function(e) {
    value = parseInt($(this).val());
    if ($(this).val() == '') {
      value = 0;
    }
    total = total - parseInt(value);
  });

  $('#total_belanjaNya').val(total);
  var tot_currency = 'Rp. ' + total.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
  $("#total_belanja").html("Total : " + tot_currency + ",-");


}
// AKHIR FUNGSI HITUNG TOTAL PEMBELIAN

// FUNGSI TAMBAH ROW PEMBELIAN
function tambahRowPembelian() {
  var table = document.getElementById("tabel_pembelian");
  row_p = row_p + 1;
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
  cell1.innerHTML = '<div class="baris-tr" style="width : 30px; color :#212529;" id="number_row" valign="center" align="center">' + row_p + '</div>';
  cell2.innerHTML = '<div class="ui-widget coeg"><input type="hidden" form="form_pembelian" name="cbo[]" id="cbo" value=""><input form="form_pembelian" type="hidden" name="id_barang[]" id="id_barang" value=""><input form="form_pembelian" numa="" style="width : 200px;"  type="text" class="keyUpEx_pembelian click_kode_pembelian form-control" id="hintkode" name="hintkode[]" autocomplete="off" placeholder="Ketik Kode / Nama Barang" required></div><div id="response" class="panel-default list_kode_br" style="width:300px; overflow: auto;     position: absolute; z-index: 1; display: block; max-height: 400px;"></div>';
  cell3.innerHTML = '<label style="color :#212529; width: 150px;" id="label_nama"> </label>';
  cell4.innerHTML = '<input form="form_pembelian" type="hidden" id="base_unit" name="base_unit[]" value=""><input form="form_pembelian" type="hidden" id="qty_unit" name="qty_unit[]" value=""><select form="form_pembelian" numa="" name="unit[]" id="unit" class="form-control  change_unit_p" required=""></select>';
  cell5.innerHTML = '<input form="form_pembelian" disabled style="width:60px;" type="number" numa="" class="form-control  qty_disabled edit_qty_p" id="jumlah_beli" name="jumlah_beli[]" >';
  cell6.innerHTML = '<label style="width : 100px; color :#212529;"   id="label_harga"> </label><input form="form_pembelian" type="hidden" id="harga_barang" name="harga_barang[]" value=""> <input form="form_pembelian" type="hidden" id="stok_barang" name="stok_barang[]" value="">';
  cell7.innerHTML = '<input type="number" form="form_pembelian" style="width:100px;" id="potongan" name="potongan[]" disabled  class="form-control potongan edit_potongan_tr" name="" value="">';
  cell8.innerHTML = '<label style="width : 120px; color :#212529;"    id="label_subtotal"> </label> <input form="form_pembelian" type="hidden" class="subtotal" id="sub_total" name="sub_total[]">';
  cell9.innerHTML = '<button onclick="hapusRowPembelian(this)" class="btn btn-danger btn-sm" id="HapusBaris" name="HapusBaris" style="color:#fff;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
  // keyUpEx_pembelian();
  // click_kode_pembelian();
}
// AKHIR FUNGSI TAMBAH ROW PEMBELIAN

// FUNGSI HAPUS ROW PEMBELIAN
function hapusRowPembelian(r) {
  var table_row = r.parentNode.parentNode;
  var x = r.parentNode.parentNode.rowIndex;
  var xx = row_p;
  var kode_in = $(table_row).find("#hintkode").val();
  var nama_in = $(table_row).find('#label_nama').text();
  var stok_in = $(table_row).find('#stok_barang').val();

  if ((kode_in != '') && (nama_in != '') && (stok_in != '')) {
    array_nama_barang.push(nama_in);
    array_kode_barang.push(kode_in);
    array_stok_barang.push(stok_in);
    array_nama_barang_src.push(nama_in.toLowerCase());
    array_kode_barang_src.push(kode_in.toLowerCase());
    array_stok_barang_src.push(stok_in.toLowerCase());
    items_barang.push([kode_in, nama_in, stok_in]);
    items_barang.sort();
  }
  document.getElementById("tabel_pembelian").deleteRow(x - 1);
  var no = 1;
  $('.baris-tr').each(function() {
    $(this).html(no);
    no++;
  });
  row_p--;
  hitung_total_pembelian();
  if (xx == 1) {
    tambahRowPembelian();
  }
}
// AKHIR FUNGSI HAPUS ROW PEMBELIAN

// FUNGSI CETAK BUKTI PEMBELIAN
// function cetakInvoicePembelian() {
//   var invoice = $("#inv_pembelian").val();
//   var ret = invoice.replace(/\//g, "");
//   invoice = 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/Laporan/invoice-pembelian/' + ret + '.xls';
//   var cek_total_belanja = $("#total_belanjaNya").val();
//   if (cek_total_belanja == '') {
//     $("#hintkode1").addClass("is-invalid");
//     $("#kode_barang_error").html("input barang !");
//   } else {
//     $.ajax({
//       url: "http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax-pembelian.php?ajax-pembelian=cetak-invoice-pembelian",
//       async: false,
//       method: "POST",
//       data: $("#form_pembelian").serialize(),
//       dataType: "JSON",
//       success: function(data) {}
//     });
//
//     $("#a_tr").attr("href", invoice);
//     $("#a_tr").click(function(e) {
//       e.preventDefault();
//       window.open(invoice, '_blank');
//     });
//     setTimeout(function() {
//       $("#a_tr").click();
//       simpanPembelian();
//     }, 300);
//   }
//
// }
// AKHIR FUNGSI CETAK BUKTI PEMBELIAN

// EXECUTE
$(document).ready(function() {
  updateNoPembelian();
  updateTanggal();
  // keyUpEx_pembelian();
  // click_kode_pembelian();
  cekAllUnit();
  cekAllBarang();
  cekMasterUnit();

  $(document).on('click', '#add_supplier_baru', function() {
    $('#add_dataSupplier').modal('show');
  });

  $(document).on('keyup', '#hintkode', function(e) {

    var parent_table = this.parentNode.parentNode.parentNode;
    var resp = $(parent_table).find(".list_kode_br");
    var query = $(this).val();
    if (query.length > 0) {
      if (((query != cache_click_item) || (query != cache_click_item.toLowerCase())) && (cache_click_item != '')) {
        var kode_in = cache_click_item;
        var nama_in = $('#label_nama' + urutan).text();
        var stok_in = $('#stok_barang' + urutan).val();
        for (var i = 0; i < array_nama_barang.length; i++) {
          if (array_nama_barang[array_nama_barang.length - 1] != nama_in) {
            array_nama_barang.push(nama_in);
            array_kode_barang.push(kode_in);
            array_stok_barang.push(stok_in);
            array_nama_barang_src.push(nama_in.toLowerCase());
            array_kode_barang_src.push(kode_in.toLowerCase());
            array_stok_barang_src.push(stok_in.toLowerCase());
            items_barang.push([kode_in, nama_in, stok_in]);

          }
        }
      }
      var re = new RegExp(query, "g");
      var arr2_kode_barang = [];
      var arr2_nama_barang = [];
      var arr2_stok_barang = [];
      var arr2_items_barang = [];
      for (var j = 0; j < array_kode_barang.length; j++) {
        var matches_array_kode = array_kode_barang_src[j].match(re);
        var matches_array_nama = array_nama_barang_src[j].match(re);

        var matches_array_kode_upper = array_kode_barang[j].match(re);
        var matches_array_nama_upper = array_nama_barang[j].match(re);
        if ((matches_array_kode != null) || (matches_array_kode_upper != null)) {
          arr2_items_barang.push([items_barang[j][0], items_barang[j][1], items_barang[j][2]]);
        } else if ((matches_array_nama != null) || (matches_array_nama_upper != null)) {
          arr2_items_barang.push([items_barang[j][0], items_barang[j][1], items_barang[j][2]]);
        }
      }
      if (arr2_items_barang != '') {
        $.ajax({
          url: 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax-pembelian.php?ajax-pembelian=gethint_input',
          method: 'POST',
          data: {
            'items_barang': arr2_items_barang
          },
          dataType: 'JSON',
          success: function(data) {
            resp.html(data.response);
          },
        });
      } else {
        resp.html("");
      }
    } else {
      $(this).click();
    }
  });

  $(document).on('click', '#hintkode', function(e) {
    var parent_table = this.parentNode.parentNode.parentNode;
    var resp = $(parent_table).find(".list_kode_br");
    var query = $(this).val();

    var re = new RegExp(query, "g");
    var arr2_kode_barang = [];
    var arr2_nama_barang = [];
    var arr2_stok_barang = [];
    var arr2_items_barang = [];
    for (var j = 0; j < array_kode_barang.length; j++) {
      var matches_array_kode = array_kode_barang_src[j].match(re);
      var matches_array_nama = array_nama_barang_src[j].match(re);

      var matches_array_kode_upper = array_kode_barang[j].match(re);
      var matches_array_nama_upper = array_nama_barang[j].match(re);
      if ((matches_array_kode != null) || (matches_array_kode_upper != null)) {
        arr2_items_barang.push([items_barang[j][0], items_barang[j][1], items_barang[j][2]]);
      } else if ((matches_array_nama != null) || (matches_array_nama_upper != null)) {
        arr2_items_barang.push([items_barang[j][0], items_barang[j][1], items_barang[j][2]]);
      }
    }
    if (arr2_items_barang != '') {
      $.ajax({
        url: 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax-pembelian.php?ajax-pembelian=gethint_input',
        method: 'POST',
        data: {
          'items_barang': arr2_items_barang
        },
        dataType: 'JSON',
        success: function(data) {
          resp.html(data.response);
        },
      });
    } else {
      resp.html("");
    }
  });

  // HILANGKAN FOCUS RESPON
  $('body').click(function(evt) {
    if (!$(evt.target).is('.cek_br_tr_pemb')) {
      $('.list_kode_br').each(function(ex) {
        $(this).html("");
      });
    }
  });
  // AKHIR HILANGKAN FOCUS RESPON
  // HILANGKAN CACHE
  $('.click_kode_pembelian').focusout(function() {
    cache_click_item = '';
  });
  // AKHIR HILANGKAN CACHE

  // PILIH SUPPLIER
  $(document).on('change', '#id_supplier', function(event) {
    event.preventDefault();
    var idNya = $(this).find(":selected").val();
    $.ajax({
      type: "POST",
      url: 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax-pembelian.php?ajax-pembelian=cek-supplier',
      data: {
        'idNya': idNya
      },
      dataType: "JSON",
      success: function(data) {
        var datanya = data;
        $('#nomor_hp_supplier').val(datanya[0].no_telp);
        $("#alamat_supplier").val(datanya[0].alamat);
      }
    });
  });
  // AKHIR PILIH SUPPLIER

  // GANTI USER
  $(document).on('change', '#id_user', function(event) {
    event.preventDefault();
    var id_kasir = $(this).find(":selected").val();
    $.ajax({
      type: "POST",
      url: 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax.php?ajax=session_kasir',
      data: {
        'id_kasir': id_kasir
      },
      success: function(data) {
        // DO SOMETHING
      }
    });
  });
  // AKHIR GANTI USER

  $(document).on('submit', '#form_new_product', function(e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax-pembelian.php?ajax-pembelian=new-product',
      data: $('#form_new_product').serialize(),
      success: function(data) {
        cekAllBarang();
        cekAllUnit();
        cekMasterUnit();

        setTimeout(function() {
          $('.kode_new_barang').each(function() {
            var kode = $(this).val();

            var lastRow = $('#tabel_pembelian tr:last');

            if ($(lastRow).find('#hintkode').val() == "") {
              lastRow = $('#tabel_pembelian tr:last');
            } else {
              tambahRowPembelian();
              lastRow = $('#tabel_pembelian tr:last');
            }

            $(lastRow).find('#hintkode').val(kode);
            $(lastRow).find('#hintkode').click();
            setTimeout(function() {
              $(lastRow).find('a', '#' + kode).click();
            }, 100);


            // cache_click_item = kode;
            // // GET DATA ITEM YANG DI PILIH
            // var data_item = [];
            // all_item.forEach(function(e) {
            //   if(kode == e.kode){
            //     data_item.push(e);
            //   }
            // });
            //
            // // HILANGKAN DATA ITEM YANG DIPILIH
            // for (var j = 0; j < items_barang.length; j++)
            //  if (items_barang[j][0] === kode) {
            //     items_barang.splice(j, 1);
            //     array_kode_barang.splice(j, 1);
            //     array_nama_barang.splice(j, 1);
            //     array_stok_barang.splice(j, 1);
            //     array_kode_barang_src.splice(j, 1);
            //     array_nama_barang_src.splice(j, 1);
            //     array_stok_barang_src.splice(j, 1);
            //     break;
            //  }
            // // CEK DATA UNIT
            // var data_unit = [];
            // all_unit.forEach(function (e) {
            //   if(kode == e.kode){
            //     data_unit.push(e);
            //   }
            // });
            //
            // var value_unit = 0;
            // var json_unit = '';
            // all_master_unit.forEach(function (e) {
            //   if(data_item[0].unit_beli == e.id){
            //     json_unit +='<option  value="'+e.unit_beli+'" selected>'+e.nama+'</option>';
            //     value_unit = e.qty;
            //   }
            //   else {
            //     json_unit +='<option  value="'+e.unit_beli+'">'+e.nama+'</option>';
            //   }
            // });
            //
            // $(lastRow).find("#unit").html(json_unit);
            // $(lastRow).find("#hintkode").removeClass("is-invalid");
            // $(lastRow).find("#kode_barang_error").html("");
            // var harga = parseInt(data_item[0].h_beli);
            // var harga_currency = 'Rp. ' + harga.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
            // $(lastRow).find('#cbo').val(data_item[0].cbo);
            // $(lastRow).find("#id_barang").val(data_item[0].id);
            // $(lastRow).find("#label_nama").html(data_item[0].nama);
            // $(lastRow).find("#harga_barang").val(harga);
            // $(lastRow).find("#label_harga").html(harga_currency);
            // $(lastRow).find("#stok_barang").val(data_item[0].stok_unit);
            // $(lastRow).find("#jumlah_beli").prop("disabled", false);
            // $(lastRow).find("#potongan").prop("disabled",false);
            // $(lastRow).find("#qty_unit").val(value_unit);
            // $(lastRow).find('#base_unit').val(value_unit);
            // $(lastRow).find("#jumlah_beli").val(1);
            // $(lastRow).find("#jumlah_beli").focus();
            // var qty = $(lastRow).find("#jumlah_beli").val();
            // var subtotal = qty * harga;
            // var sub_currency = 'Rp. ' + subtotal.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
            // $(lastRow).find("#sub_total").val(data_item[0].h_beli);
            // tot_pembelian = tot_pembelian + subtotal;
            // $(lastRow).find("#label_subtotal").html(sub_currency);
            // hitung_total_pembelian();
            // $(lastRow).find("#response").html("");
          });
          $('#add_dataBarang').modal('hide');
        }, 2000);
      }
    });
  });


  // EDIT POTONGAN PEMBELIAN
  $(document).on('input', '.edit_potongan_tr', function() {
    hitung_total_pembelian();
  });
  // AKHIR EDIT POTONGAN PEMBELIAN

  // EDIT QTY PEMBELIAN
  $(document).on('input', '.edit_qty_p', function() {
    var yg_mana = $(this).attr('numa');
    var qty = $("#jumlah_beli" + yg_mana).val();
    var h_unit = parseInt($("#harga_barang" + yg_mana).val()) * (parseInt($("#qty_unit" + yg_mana).val()) / parseInt($("#base_unit" + yg_mana).val()));

    var sub_unit = parseInt(h_unit) * parseInt(qty);
    $("#sub_total" + yg_mana).val(sub_unit);
    // console.log("TEST");
    hitung_total_pembelian();
  });
  // AKHIR EDIT QTY PEMBELIAN

  // CHANGE UNIT PEMBELIAN
  $(document).on('change', '.change_unit_p', function() {
    var yg_mana = $(this).attr('numa');
    var unit_tr = $("#unit" + yg_mana).val();
    var kode_barang = $("#hintkode" + yg_mana).val();
    var qty = $("#jumlah_beli" + yg_mana).val();
    $.ajax({
      url: 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax.php?ajax=cek_unit_tr',
      method: 'POST',
      data: {
        'k_bar': kode_barang,
        'u_bar': unit_tr
      },
      dataType: 'JSON',
      success: function(data) {
        $("#qty_unit" + yg_mana).val(data.value_unit);
        var h_unit = parseInt($("#harga_barang" + yg_mana).val()) * (parseInt($("#qty_unit" + yg_mana).val()) / parseInt($("#base_unit" + yg_mana).val()));
        var h_currency = 'Rp. ' + h_unit.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
        $("#label_harga" + yg_mana).html(h_currency);

        var sub_unit = parseInt(h_unit) * parseInt(qty);
        var s_currency = 'Rp. ' + sub_unit.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
        $("#label_subtotal" + yg_mana).html(s_currency);
        $("#sub_total" + yg_mana).val(sub_unit);
        console.log(sub_unit + "SUB UNIT B");
        hitung_total_pembelian();
      }
    });
  });
  // AKHIR CHANGE UNIT PEMBELIAN

  // KLIK LIST BARANG
  $(document).on('click', '.cek_br_tr_pemb', function() {
    var rowTable = this.parentNode.parentNode.parentNode.parentNode.parentNode;

    var kode = $(this).attr('id');
    cache_click_item = kode;
    // GET DATA ITEM YANG DI PILIH
    var data_item = [];
    all_item.forEach(function(e) {
      if (kode == e.kode) {
        data_item.push(e);
      }
    });

    // HILANGKAN DATA ITEM YANG DIPILIH
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
    all_unit.forEach(function(e) {
      if (kode == e.kode) {
        data_unit.push(e);
      }
    });

    var value_unit = 0;
    var json_unit = '';
    all_master_unit.forEach(function(e) {
      if (data_item[0].unit_beli == e.id) {
        json_unit += '<option  value="' + e.id + '" selected>' + e.nama + '</option>';
        value_unit = e.qty;
      } else {
        json_unit += '<option  value="' + e.id + '">' + e.nama + '</option>';
      }
    });

    $(rowTable).find("#unit").html(json_unit);
    $(rowTable).find("#hintkode").removeClass("is-invalid");
    $(rowTable).find("#kode_barang_error").html("");
    var harga = parseInt(data_item[0].h_beli);
    var harga_currency = 'Rp. ' + harga.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
    $(rowTable).find('#cbo').val(data_item[0].cbo);
    $(rowTable).find("#id_barang").val(data_item[0].id);
    $(rowTable).find("#label_nama").html(data_item[0].nama);
    $(rowTable).find("#harga_barang").val(harga);
    $(rowTable).find("#label_harga").html(harga_currency);
    $(rowTable).find("#stok_barang").val(data_item[0].stok_unit);
    $(rowTable).find("#jumlah_beli").prop("disabled", false);
    $(rowTable).find("#potongan").prop("disabled", false);
    $(rowTable).find("#qty_unit").val(value_unit);
    $(rowTable).find('#base_unit').val(value_unit);
    $(rowTable).find("#jumlah_beli").val(1);
    $(rowTable).find("#jumlah_beli").focus();
    var qty = $(rowTable).find("#jumlah_beli").val();
    var subtotal = qty * harga;
    var sub_currency = 'Rp. ' + subtotal.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
    $(rowTable).find("#sub_total").val(data_item[0].h_beli);
    tot_pembelian = tot_pembelian + subtotal;
    $(rowTable).find("#label_subtotal").html(sub_currency);
    hitung_total_pembelian();
    $(rowTable).find("#response").html("");
  });

  // AKHIR KLIK LIST BARANG

  // SUKSES PEMBELIAN
  $("#btn_transaksiSukses").on('click', function() {
    location.reload();
  });

  // SHOW MODAL NEW PRODUCT
  $("#btn_new_product").on('click', function() {
    $("#add_dataBarang").modal('show');
  });


  // SHOW USER LOGIN
  $("#p_penjualan").removeClass("active");
  $("#p_laporan").removeClass("active");
  $("#p_user").removeClass("active");
  $("#p_pembelian").addClass("active");
  $("#p_gantipassword").removeClass("active");
  $("#p_master").removeClass("active");


  $(document).on('click', '#cetak_pembelian', function(e) {
    $('#form_pembelian').attr('action', 'http://localhost:8080/hijrahmandirimvc/public/pembelian/setCetakPurchases');
  });

  // FUNGSI KEYUP
  $('body').on('keyup', function(e) {
    if (e.key == "F7") {
      tambahRowPembelian();
    }
    if (e.key == "F9") {
      $('#cetak_pembelian').click();
    }
    if (e.key == "F10") {
      $('#simpan_pembelian').click();
    }
  });
  // AKHIR FUNGSI KEYUP

});
