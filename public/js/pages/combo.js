// DEFINE VARIABEL
var tot_belanja = 0;
var i = 1;
var row_bar = 1;
var row_d_combo = 1;
var row_combo = 1;
var urutan = "";
var u_dc = "";
var active_dc = 0;
var jml_row_combo = 1;

var array_kode_barang = [];
var array_nama_barang = [];
var array_stok_barang = [];


var items_barang = [];
var items_combo = [];
var all_combo = [];
var all_item = [];
var item_of_combo = [];
var rd_cbo = [];
var all_master_unit = [];
var all_unit = [];
var mereknya = '';
var kategorinya = '';
var unitnya = '';
var cek = 'OK';
// AKHIR DEFINE VARIABEL

// FUNCTIONS


function getUnitByKode(kode, unit_awal) {
  var data_unit = [];
  all_unit.forEach(function(e) {
    if (kode == e.kode) {
      data_unit.push(e);
    }
  });

  var value_unit = 0;
  var json_unit = '';
  data_unit.forEach(function (e) {
    if(unit_awal == e.unit_id){
      json_unit +='<option  value="'+e.unit_id+'" selected>'+e.n_unit+'</option>';
      value_unit = e.qty;
    }
    else {
      json_unit +='<option  value="'+e.unit_id+'">'+e.n_unit+'</option>';
    }
  });

  return json_unit;
}

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

// CEK ALL DETAIL COMBO
// CEK DETAIL PENJUALAN BARANG
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
// AKHIR CEK ALL BARANG

// AKHIR CEK ALL DETAIL COMBO
function cekAllItemsCBO() {
  $.ajax(
      {
          url: 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax-master-combo.php?ajax-combo=cek-item-combo',
          method: 'POST',
          data: {'search': 1},
          dataType: 'JSON',
          success: function (data) {
            item_of_combo = data;
            console.log(item_of_combo);

          },
      }
  );
}
// CEK ALL COMBO ITEM
function cekAllCombo() {
  $.ajax(
      {
          url: 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax-master-combo.php?ajax-combo=cek-all-combo',
          method: 'POST',
          data: {'search': 1},
          dataType: 'JSON',
          success: function (data) {
            all_combo = data;
            console.log(all_combo);

          },
      }
  );
}
// AKHIR CEK ALL COMBO ITEM

// CLICK LIST DETAIL COMBO
function ClickList_DC(){
  $('.cek_br_dc').click(function(){
    var k_br = $(this).attr('id');
    var n_br = $(this).attr('nama');
    var s_br = $(this).attr('stok');
    var dc_mana = $(this).attr('numa');
    $("#c_unit"+dc_mana).html("");
    $("#c_kode"+dc_mana).val(k_br);
    $("#c_nama"+dc_mana).html(n_br);
    $("#c_stok"+dc_mana).val(s_br);
    $("#c_qty"+dc_mana).val("1");

    $.ajax(
        {
            url: 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax-master.php?ajax-master=cek_unit_br',
            method: 'POST',
            data: {k_br : k_br},
            dataType: 'JSON',
            success: function (data) {
                $("#c_unit"+dc_mana).html(data.allunit);
                $("#c_id"+dc_mana).val(data.good_id);
                $("#c_stok_unit"+dc_mana).val($("#c_unit"+dc_mana).val());
                $("#c_response"+dc_mana).html("");
            },

        }
    );
  });
}
// AKHIR CLICK LIST DETAIL COMBO

// CLICK DETAIL COMBO
function ClickDetail_Combo() {
        $(".input_c_kode").on('click',function(){
          u_dc = $(this).attr("numa");
          active_dc = u_dc;
              var query = $("#c_kode"+u_dc).val();
              if (query.length >= 0) {
                var re = new RegExp(query,"g");
                var arr2_kode_barang = [];
                var arr2_nama_barang = [];
                var arr2_stok_barang = [];
                var arr2_items_barang = [];
                for (var j = 0; j < array_kode_barang.length; j++) {
                  var matches_array_kode = array_kode_barang_src[j].match(re);
                  var matches_array_nama = array_nama_barang_src[j].match(re);

                  if(matches_array_kode != null){
                    arr2_items_barang.push([ items_barang[j][0], items_barang[j][1], items_barang[j][2] ]);
                  }
                  else if(matches_array_nama != null){
                    arr2_items_barang.push([ items_barang[j][0], items_barang[j][1], items_barang[j][2] ]);
                  }

                }
                $.ajax(
                    {
                        url: 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax-master.php?ajax-master=gethint_detail_combo',
                        method: 'POST',
                        data: {'items_barang' : arr2_items_barang, 'u_dc':u_dc },
                        dataType: 'JSON',
                        success: function (data) {
                            $("#c_response"+u_dc).html(data.response);
                            ClickList_DC();
                        },

                    }
                );
              }
              else {
                $("#c_response"+u_dc).html("");
              }

            });

}
// AKHIR CLICK DETAIL COMBO

// ONKEYUP DETAIL COMBO
function KeyUpDetail_Combo() {
      $(".input_c_kode").keyup(function(){
          u_dc = $(this).attr("numa");
          active_dc = u_dc;
              var query = $("#c_kode"+u_dc).val();
              if (query.length > 0) {
                var re = new RegExp(query,"g");

                var arr2_kode_barang = [];
                var arr2_nama_barang = [];
                var arr2_stok_barang = [];

                var arr2_items_barang = [];

                for (var j = 0; j < array_kode_barang.length; j++) {
                  var matches_array_kode = array_kode_barang_src[j].match(re);
                  var matches_array_nama = array_nama_barang_src[j].match(re);

                  if(matches_array_kode != null){
                    arr2_items_barang.push([ items_barang[j][0], items_barang[j][1], items_barang[j][2] ]);
                  }
                  else if(matches_array_nama != null){
                    arr2_items_barang.push([ items_barang[j][0], items_barang[j][1], items_barang[j][2] ]);
                  }
                }
                $.ajax(
                    {
                        url: 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax-master.php?ajax-master=gethint_detail_combo',
                        method: 'POST',
                        data: {'items_barang' : arr2_items_barang, 'u_dc' : u_dc},
                        dataType: 'JSON',
                        success: function (data) {
                            $("#c_response"+u_dc).html(data.response);
                            ClickList_DC();
                        },

                    }
                );
              }
              else {
                $("#c_response"+u_dc).html("");
              }

        });
}
// AKHIR ONKEYUP DETAIL COMBO

// TAMBAH DETAIL COMBO
function tambahRowDetailCombo(n){
  var row_dc = n.parentNode.parentNode.parentNode;
  var table = row_dc.querySelector('#table_detail_combo');

  var row = table.insertRow(-1);
  var cell1 = row.insertCell(0);
  var cell2 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell4 = row.insertCell(3);
  var cell5 = row.insertCell(4);

  cell1.innerHTML = '<input autocomplete="off" form="insert_form_combo" type="text" numa="" name="c_kode[]" class="form-control-sm form-control input_c_kode" id="c_kode" required><input autocomplete="off"  type="hidden" id="c_id" name="c_id[]" value=""><input autocomplete="off"  type="hidden" id="c_stok" name="c_stok[]" value=""><div  id="c_response" name="c_response" class="panel-default c_list_kode" style="width:300px; overflow: auto;     position: absolute; z-index: 1; display: block; max-height: 400px;">';
  cell2.innerHTML = '<label id="c_nama" name="c_nama"></label>';
  cell3.innerHTML = '<input autocomplete="off"  type="hidden" id="c_stok_unit" name="c_stok_unit[]" value=""><select  numa="" name="c_unit[]" id="c_unit" class="form-control change_unit form-control-sm" required></select>';
  cell4.innerHTML = '<input autocomplete="off"  type="number" name="c_qty[]" class="form-control-sm form-control" id="c_qty" required>';
  cell5.innerHTML = '<div align="center"><button onclick="hapusRowDetailCombo(this)" numa="" class="btn  btn-sm name="HapusBaris_dc" id="HapusBaris_dc" style="color:#fff;"><i class="fas fa-times"></i></button></div>';
}
// AKHIR TAMBAH DETAIL COMBO

// TAMBAH ROW COMBO
function tambahRowCombo(){
  var table = document.getElementById("tabel_tambah_combo");
    row_combo++;
    jml_row_combo = row_combo;

    $.ajax({
      url:"http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax-master-combo.php?ajax-combo=tambah_row_combo",
      method:"POST",
      data : {'row_combo' : row_combo, 'unitnya' : unitnya },
      dataType : "JSON",
      success:function(data)
      {
        var row = table.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        cell1.innerHTML = '<div  id="number_cbo" class="baris-combo" align="center">'+row_combo+'</div><input autocomplete="off" form="insert_form_combo" type="hidden" id="id_cbo" name="id_cbo[]" value="">';
        cell2.innerHTML = data.deskripsi;
        cell3.innerHTML = data.detail;
        cell4.innerHTML = '<div align="center"><button onclick="hapusRowCombo(this)" class="btn btn-danger btn-sm" id="HapusBaris" style="color:#fff;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></div>';
        // KeyUpDetail_Combo();
        // ClickDetail_Combo();
      }
    });


    }
// AKHIR TAMBAH ROW COMBO

// HAPUS DETAIL COMBO
function hapusRowDetailCombo(r) {
  var tr_dc = r.parentNode.parentNode.parentNode.rowIndex;
  var table = r.parentNode.parentNode.parentNode.parentNode.parentNode;
  table.deleteRow(tr_dc);
}
// AKHIR HAPUS DETAIL COMBO

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

// HAPUS ROW COMBO
function hapusRowCombo(r) {
  var x = r.parentNode.parentNode.parentNode.rowIndex;
  document.getElementById("tabel_tambah_combo").deleteRow(x);

  var no = 1;
  $('.baris-combo').each(function() {
    $(this).html(no);
    no++;
  });
  row_combo--;
}
// AKHIR HAPUS ROW COMBO
// AKHIR FUNCTIONS

// TAMBAH ROW DETAIL UNIT

// AKHIR TAMBAH ROW DETAIL UNIT

$(document).ready(function () {
  cekAllBarang();
  // KeyUpDetail_Combo();
  // ClickDetail_Combo();
  // ClickList_DC();
  cekAllCombo();
  cekAllItemsCBO();
  cekAllUnit();

  $('body').click(function(evt) {
    if (!$(evt.target).is('.cek_br_tr_pemb')) {
      $('.c_list_kode').each(function(ex) {
        $(this).html("");
      });
    }
  });

  $(document).on('click', '.cek_br_tr_pemb', function(){
    var row_table = this.parentNode.parentNode.parentNode.parentNode.parentNode;
    var kode = $(this).attr('id');

    var data_item = [];
    all_item.forEach(function(e) {
      if (kode == e.kode) {
        data_item.push(e);
      }
    });

    var data_unit = [];
    all_unit.forEach(function(e) {
      if (kode == e.kode) {
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

    console.log(json_unit);

    $(row_table).find('#c_kode').val(kode);
    $(row_table).find('#c_nama').html(data_item[0].nama);
    $(row_table).find('#c_unit').html(json_unit);
    $(row_table).find('#c_qty').val(1);
    $(row_table).find('#c_id').val(data_item[0].id);

    $(row_table).find('#c_response').html('');
  });

  $(document).on('click', '#c_kode', function(){
    var parent_table = this.parentNode.parentNode;
    console.log(parent_table);
    var resp = $(parent_table).find('#c_response');
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

  $('#tabel_combo').DataTable(
    {
      columnDefs: [
       { type: 'currency', targets: 7 }
     ]
    }
  );

  $('body').click(function(evt){
      if(!$(evt.target).is('.cek_br_dc')) {
          $("#c_response"+active_dc).html("");

      }
  });

  // KLIK BUTTON TAMBAH COMBO
  $(document).on('click','.tambah_data_combo', function(){
    $('#id_cbo1').val("");
    $('#kode_cbo1').val("");
    $('#nama_cbo1').val("");
    $('#minstok_cbo1').val("");
    $('#h_jual_cbo1').val("");
    $('#unit_jual_cbo1').val("");

    $('#judul_modal_combo').text("New Combo");
    $('#btn_newline_combo').show();
    $('#btn_insert_combo').val("Simpan");
  });
  // AKHIR KLIK BUTTON TAMBAH COMBO

  // HAPUS ITEM COMBO
  $(document).on('click','.hapus_data_combo', function(){
    var id = $(this).attr("id");
    $('#hapus_dataCombo').modal('show');
    $('#hapuscombo_id').val(id);
  });


  // AKHIR HAPUS ITEM COMBO

  // SIMPAN COMBO
  $("#insert_form_combo").on('submit', function(e){
    e.preventDefault();
    var action = $('#insert_form_combo').attr('url');
    // console.log(action);
    var detail_combo = [];
    var combo = [];
    $('.baris-combo').each(function(e) {
      var tr = this.parentNode.parentNode;

      var kode_cbo =  $(tr).find('#kode_cbo').val();
      var nama_cbo =  $(tr).find('#nama_cbo').val();
      var minstok_cbo =  $(tr).find('#minstok_cbo').val();
      var unit_jual_cbo =  $(tr).find('#unit_jual_cbo').val();
      var h_jual_cbo =  $(tr).find('#h_jual_cbo').val();
      var id_cbo =  $(tr).find('#id_cbo').val();

      combo.push({
        'kode_cbo' : kode_cbo, 'nama_cbo' : nama_cbo,
        'minstok_cbo' : minstok_cbo, 'unit_jual_cbo' : unit_jual_cbo,
        'h_jual_cbo' : h_jual_cbo, 'id_cbo' : id_cbo
      });

      detail_combo.push([]);
      $(tr).find('.input_c_kode').each(function(i, el) {
        var child_tr = this.parentNode.parentNode;
        var c_kode = $(child_tr).find('#c_kode').val();
        var c_nama = $(child_tr).find('#c_nama').text();
        var c_unit = $(child_tr).find('#c_unit').val();
        var c_qty = $(child_tr).find('#c_qty').val();
        var c_id = $(child_tr).find('#c_id').val();
        detail_combo[e].push({'c_id':c_id , 'c_kode':c_kode , 'c_nama':c_nama , 'c_unit':c_unit, 'c_qty':c_qty});
      });

    });

    $.ajax({
      url : action,
      method : 'POST',
      data : {'combo' : combo, 'detail_combo' : detail_combo},
      dataType : 'JSON',
      success : function (data) {
        location.reload();
      }
    });

  });


  // AKHIR SIMPAN COMBO

  // CHANGE UNIT DETAIL COMBO
  $(".change_unit").change(function(){
    var yg_mana = $(this).attr('numa');
    var u_id = $("#c_unit"+yg_mana).val();
    var g_code = $("#c_kode"+yg_mana).val();
    // CEK QTY OF UNIT
    $.ajax(
      {
            url: 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax-master.php?ajax-master=cek-qty-unit',
            method: 'POST',
            data: {'u_id' : u_id, 'g_code' : g_code},
            dataType: 'JSON',
            success: function (data) {
              $("#c_stok_unit"+yg_mana).val(data.qty_of_unit);
            }
    });
  });
  // AKHIR CHANGE UNIT DETAIL COMBO

  // PAGINITION COMBO
  $(document).on('change','#jmlData_combo',function(event){
      event.preventDefault();

      var jumlahData_combo = $(this).find(":selected").val();
      $.ajax({
              type: "POST",
              url: 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax-master-combo.php?ajax-combo=paginition_combo',
              data: { 'jumlahData_combo' : jumlahData_combo },
              dataType : "JSON",
              success: function(data){
                  $('#goods_table').html(data.table);
                  $("#paging_combo").html(data.page);
                  $('#keterangan-tabel-combo').html(data.keterangan);
              }
            });
    });
  // AKHIR PAGINITION COMBO

  // CARI COMBO
  $(document).on('input','#keywordcombo',function(event){
    event.preventDefault();

    var keywordcombo = $('#keywordcombo').val();
    var jumlahDatacombo = $('#jmlData_combo').val();
    $.ajax({
      type: "POST",
      url: 'http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax-master-combo.php?ajax-combo=cari_combo',
      data: { 'keywordcombo' : keywordcombo, 'jumlahDatacombo':jumlahDatacombo },
      dataType : "JSON",
      success: function(data)
      {
        $('#goods_table').html(data.table);
        $("#paging_combo").html(data.page);
        $('#keterangan-tabel-combo').html(data.keterangan);
      }
    });
  });
  // AKHIR CARI COMBO

  $(document).on('click', '#btn_tambahCombo', function() {
    $('#judul_modal_combo').html('Tambah Data Combo');
    $('#btn_insert_combo').val('Simpan');
    $('#btn_newline_combo').show();
    $('#insert_form_combo').attr('url', 'http://localhost:8080/hijrahmandirimvc/public/master/setSimpanCombo');
    $('#kode_cbo').val('');
    $('#nama_cbo').val('');
    $('#minstok_cbo').val('');
    $('#unit_jual_cbo').val('');
    $('#h_jual_cbo').val('');

    $('#c_kode').val('');
    $('#c_nama').text('');
    $('#c_unit').html('');
    $('#c_unit').val('');
    $('#c_qty').val('');
    $('#c_id').val('');

    $("#tbody_detail_combo td").remove();
    $('#btnTambah_DC').click();
  });



  // EDIT DATA COMBO
  $(document).on('click','.edit_data_combo', function(){
    var id = $(this).attr('id');
    $('#insert_form_combo').attr('url', 'http://localhost:8080/hijrahmandirimvc/public/master/setEditCombo');
    $("#tbody_detail_combo td").remove();
    $('#btnTambah_DC').click();
    $('#add_dataCombo').modal('show');
    $('#judul_modal_combo').html('Edit Data Combo');
    $('#btn_insert_combo').val('Edit');
    $('#btn_newline_combo').hide();

    $.ajax({
      url : 'http://localhost:8080/hijrahmandirimvc/public/master/getEditCombo',
      method : 'POST',
      data : {'id' : id},
      dataType : 'JSON',
      success : function(data) {

        $('#id_cbo').val(data.combo.id);
        $('#kode_cbo').val(data.combo.kode);
        $('#nama_cbo').val(data.combo.nama);
        $('#minstok_cbo').val(data.combo.min_qty);
        $('#unit_jual_cbo').val(data.combo.unit_jual);
        $('#h_jual_cbo').val(data.combo.h_jual);


        i = 0;
        while (i < data.detail_combo.length) {
          var lastRow = $('#table_detail_combo tr:last');
          var kode = data.detail_combo[i].kode;
          var unit_awal = data.detail_combo[i].unit_awal;
          var json_unit = getUnitByKode(kode, unit_awal);

          $(lastRow).find('#c_kode').val(data.detail_combo[i].kode);
          $(lastRow).find('#c_nama').text(data.detail_combo[i].nama);
          $(lastRow).find('#c_unit').html(json_unit);
          $(lastRow).find('#c_unit').val(data.detail_combo[i].unit_id);
          $(lastRow).find('#c_qty').val(data.detail_combo[i].qty);
          $(lastRow).find('#c_id').val(data.detail_combo[i].good_id);

          if(i < data.detail_combo.length - 1){
            $('#btnTambah_DC').click();
          }
          i++;
        }

      }
    });

  });
  // AKHIR EDIT DATA COMBO
});
