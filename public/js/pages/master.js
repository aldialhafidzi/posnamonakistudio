
// DEFINE VARIABEL
  var row_bar = 1;
  var urutan = "";
  var mereknya = '';
  var kategorinya = '';
  var unitnya = '';
  var cek = 'OK';

  var rcu = 1; //Jumlah Row ConvertUnit
  var array_kode_barang = [];
  var array_nama_barang = [];
  var array_stok_barang = [];
  var array_kode_barang_src = [];
  var array_nama_barang_src = [];
  var array_stok_barang_src = [];
  var all_item = [];
  var all_unit = [];
  var all_detailUnits = [];
  var items_barang = [];
  var items_combo = [];
  var detail_item_combo = [];

  function cekAllUnit() {
    $.ajax({
      url:"phpfiles/ajax.php?ajax=cek_all_unit",
      method:"POST",
      data:{cek:cek},
      dataType:"JSON",
      success:function(data){
        unitnya = data.allunit;

      }
    });
  }

// AKHIR DEFINE VARIABEL
function tambahRowDetailUnit(n) {
  var row_du = n.parentNode.parentNode;
  var table = row_du.querySelector('#table_detail_unit');

  var row = table.insertRow(-1);
  var cell1 = row.insertCell(0);
  var cell2 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell4 = row.insertCell(3);

  cell1.innerHTML = '<select numa="" name="u_id[]" id="u_id" class="form-control d_unit_id  form-control-sm" required>'+unitnya+'</select>';
  cell2.innerHTML = '<input autocomplete="off" type="number" name="u_qty[]" class="form-control-sm form-control" id="u_qty" required>';
  cell3.innerHTML = '<label id="u_ket" name="u_ket"></label>';
  cell4.innerHTML = '<div align="center"><button onclick="hapusRowDetailUnit(this)" numa="" class="btn  btn-sm" name="HapusBaris_dc" id="HapusBaris_dc" style="color:#fff;"><i class="fas fa-times"></i></button></div>';
}

function hapusRowDetailUnit(r) {
  var tr_du = r.parentNode.parentNode.parentNode.rowIndex;
  var table = r.parentNode.parentNode.parentNode.parentNode.parentNode;
  table.deleteRow(tr_du);
}

function reloadPage() {
  location.reload();
}

// =======================================================================

// FUNGSI KLIK LIST RESPONSE

// AKHIR FUNGSI KLIK RESPONSE

// CEK DETAIL UNITS
function cekDetailUnits() {
  $.ajax({
    url : 'phpfiles/ajax.php?ajax=cek-detail-units',
    method : "POST",
    data : {'ok':1},
    dataType : "JSON",
    success : function(data) {
      all_detailUnits = data;
      console.log(all_detailUnits);
    }
  });
}
// AKHIR CEK DETAIL UNITS

// CEK ITEM COMBO
function cekItemCombo() {
  $.ajax({
          url: 'phpfiles/ajax.php?ajax=cek-item-combo',
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
          url: 'phpfiles/ajax.php?ajax=cek-all-combo',
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
          url: 'phpfiles/ajax-pembelian.php?ajax-pembelian=cek_all_barang',
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
// =======================================================================
// FUNGSI TAMBAH ROW CONVERT UNITS
  function tambahRowConvertUnit() {
    rcu = rcu + 1;
    var table = document.getElementById("tabelConvertUnit");
    var row = table.insertRow(-1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);

    console.log(unitnya);

    $.ajax({
      url : "phpfiles/ajax-master.php?ajax-master=tambah-row-convert-unit",
      method : "POST",
      data : {'jmlRowRCU':rcu, 'unitnya':unitnya},
      dataType : "JSON",
      success:function(data) {
        cell1.innerHTML = '<div class="baris_RDU" align="center">'+rcu+'</div>';
        cell2.innerHTML = data.cell2_;
        cell3.innerHTML = data.cell3_;
        cell4.innerHTML = '<div align="center"><button type="button" onclick="hapusRowConvertUnit(this)" class="btn btn-danger btn-sm" name="btnHapusRowConvertUnit" id="btnHapusRowConvertUnit"><i class="fas fa-times"></i></button></div>';
      }
    });
  }
// AKHIR FUNGSI TAMBAH ROW CONVERT UNITS

// FUNGSI HAPUS ROW CONVERT UNITS
  function hapusRowConvertUnit(r) {
    var x = r.parentNode.parentNode.parentNode.rowIndex;
    var numana = r.parentNode.parentNode.parentNode;
    var kode_in = $(numana).find("#kode").val();
    var nama_in = $(numana).find("#nama").val();
    var stok_in = '';

    if((kode_in !='') && (nama_in !='')){
      array_nama_barang.push(nama_in);
      array_kode_barang.push(kode_in);
      array_stok_barang.push(stok_in);

      array_nama_barang_src.push(nama_in.toLowerCase());
      array_kode_barang_src.push(kode_in.toLowerCase());
      array_stok_barang_src.push(stok_in.toLowerCase());
      items_barang.push([ kode_in, nama_in, stok_in ]);
    }

    document.getElementById("tabelConvertUnit").deleteRow(x);
    var no = 1;
    $('.baris_RCU').each(function() {
      $(this).html(no);
      no++;
    });
    rcu--;
  }
// AKHIR FUNGSI HAPUS ROW CONVERT UNITS

// FUNGSI TAMBAH ROW MASTER
  function tambahRowBarang(){
    var table = document.getElementById("tabel_tambah_barang");
    row_bar = row_bar + 1;
    var row = table.insertRow(-1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    $.ajax({
      url:"phpfiles/ajax-master.php?ajax-master=tambah_row_barang",
      method:"POST",
      data : {'row_bar' : row_bar, 'kategorinya' : kategorinya, 'mereknya' : mereknya, 'unitnya' : unitnya },
      dataType : "JSON",
      success:function(data)
      {
        cell1.innerHTML = '<p  class="number_rowBar" valign="center" align="center"> '+row_bar+' </p>';
        cell2.innerHTML = data.deskripsi;
        cell3.innerHTML = data.detail;
        cell4.innerHTML = '<button onclick="hapusRowBarang(this)" class="btn btn-danger btn-sm" id="HapusBaris" style="color:#fff;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
      }
    });

  }
// AKHIR FUNGSI TAMBAH ROW MASTER

// FUNGSI HAPUS ROW MASTER
  function hapusRowBarang(r) {
    var x = r.parentNode.parentNode.rowIndex;
    document.getElementById("tabel_tambah_barang").deleteRow(x);

    var no = 1;
    $('.number_rowBar').each(function(){
      $(this).html(no);
      no++;
    });

    row_bar--;
  }
// AKHIR FUNGSI HAPUS ROW MASTER

// FUNGSI CEK ITEM COMBO
  function cekItemCombo() {
    $.ajax({
            url: 'phpfiles/ajax.php?ajax=cek-item-combo',
            method: 'POST',
            data: {'search': 1},
            dataType: 'JSON',
            success: function (data) {
              detail_item_combo = data;

            },
        });
  }
// AKHIR FUNGSI CEK ITEM COMBO

// EXECUTE
$(document).ready(function(){
  cekDetailUnits();
  cekItemCombo();
  cekItemCombo();
  cekAllCombo();
  cekAllBarang();
  cekAllUnit();

  $(document).on('click', '#btn-new-unit', function(){
    $('#modal_tambah_unit').modal('show');
    $('#nama_unit').val('');
  });

  $(document).on('submit', '#form_unit', function(e) {
    e.preventDefault();

    $.ajax({
      url : 'http://localhost:8080/hijrahmandirimvc/public/master/setSimpanUnit',
      method : 'POST',
      data : $('#form_unit').serialize(),
      dataType : 'JSON',
      success : function(data) {
        cekAllUnit();

        if(data > 0){
          $.notify(" &nbsp;&nbsp;Unit berhasil ditambahkan !",
            {
              align:"right", verticalAlign:"bottom",
              close: true, delay:3000,
              color: "#fff", background: "#19aa3a",
              icon:"check"
            });
        }
        else {
          $.notify(" &nbsp;&nbsp;Unit gagal ditambahkan !",
            {
              align:"right", verticalAlign:"bottom",
              close: true, delay:3000,
              color: "#fff", background: "#c3383f",
              icon:"close"
            });
        }
        $('#modal_tambah_unit').modal('hide');
      }
    });
  });

  $(document).on('click', '.list-response', function() {
    console.log("OK");
    var parent_table = this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
    console.log(parent_table);
    var kode = $(this).attr("id");
    var good_id = $(this).attr("good_id");
    var base_unit = $(this).attr("base_unit");
    var nama_b = $(this).attr("nama");

    $.ajax({
      url : 'http://localhost:8080/hijrahmandirimvc/public/master/getDetailUnit',
      method : 'POST',
      data : {'id' : good_id},
      dataType : 'JSON',
      success : function(data) {
        $(parent_table).find("#kode").val(kode);
        $(parent_table).find("#good_id").val(good_id);
        $(parent_table).find("#nama").val(nama_b);
        $(parent_table).find("#base_unit").val(base_unit);
        var nama_base_unit = $(parent_table).find("#base_unit option:selected").text();
        console.log(data);
        i = 0;
        while (i < data.length) {
          var lastRow = $(parent_table).find('#table_detail_unit tr:last');
          $(lastRow).find('#u_id').val(data[i].unit_id);
          $(lastRow).find('#u_qty').val(data[i].qty);
          $(lastRow).find('#u_ket').text('1 '+data[i].nama+' = '+data[i].qty+ ' ' +nama_base_unit);

          if(i < data.length - 1){
            $(parent_table).find('#btn_tambah_row_detail_unit').click();
          }

          i++;
        }


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



      }
    });
    $('.response_CU').each(function() {
      $(this).html("");
    });
  });
  //
  $(document).on('click','#btn_conversi_unit',function() {
    $("#base_unit").html(unitnya);
    // $('#kode').val('');
    // $('#base_unit').val('');
    // $('#nama').val('');
    //
    // $("#tbody_detail_unit td").remove();
    // $('#btn_tambah_row_detail_unit').click();
  });
  // HILANGKAN RESPONSE
  $('body').click(function(evt){
      if(!$(evt.target).is('.list-response')) {
          $('.response_CU').each(function(ex) {
            $(this).html("");
          });
      }
  });
  // AKHIR HILANGKAN RESPONSE



  // SUBMIT FORM CONVERT UNITS
    $(document).on('submit', '#formConvertUnit', function(e) {

      e.preventDefault();
      var good = [];
      var detail_unit = [];
      $('#tabelConvertUnit .baris_RDU').each(function(x) {
        var tr = this.parentNode.parentNode;
        var id =  $(tr).find('#good_id').val();
        good.push({
          'good_id' : id
        });

        detail_unit.push([]);
        $(tr).find('.d_unit_id').each(function(i, el) {
          var child_tr = this.parentNode.parentNode;
          var u_id = $(child_tr).find('#u_id').val();
          var u_qty = $(child_tr).find('#u_qty').val();
          detail_unit[x].push({'u_id':u_id , 'u_qty':u_qty });
        });

      });

      console.log(good);
      console.log(detail_unit);

      $.ajax({
        url : 'http://localhost:8080/hijrahmandirimvc/public/master/setSimpanDetailUnit',
        method : 'POST',
        data : {'good' : good, 'detail_unit' : detail_unit},
        dataType : 'JSON',
        success : function (data) {
          location.reload();
        }
      });

    });
  // AKHIR SUBMIT FORM CONVERT UNITS

  // FUNGSI KEYUP LIST RESPONSE

  // AKHIR FUNGSI KEYUP LIST RESPONSE
  $(document).on('keyup','#kode', function (e) {
    var parent_table = this.parentNode.parentNode.parentNode.parentNode;
    num = $(this);
    query = $(this).val();
    resp = $(parent_table).find(".response_CU");

    if (query.length > 0) {
        var nama_in = $('#label_nama'+urutan).text();
        var stok_in = $('#stok_barang'+urutan).val();
        for (var i = 0; i < array_nama_barang.length; i++) {
          if(array_nama_barang[array_nama_barang.length - 1] != nama_in){
            array_nama_barang.push(nama_in);
            array_kode_barang.push(kode_in);
            array_stok_barang.push(stok_in);
            array_nama_barang_src.push(nama_in.toLowerCase());
            array_kode_barang_src.push(kode_in.toLowerCase());
            array_stok_barang_src.push(stok_in.toLowerCase());
            items_barang.push([ kode_in, nama_in, stok_in ]);
          }
        }
      // }
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
          url: 'phpfiles/ajax-master.php?ajax-master=response-cu',
          method: 'POST',
          data: {'items_barang' : arr2_items_barang, 'all_detailUnits' : all_detailUnits , 'all_item':all_item},
          dataType: 'JSON',
          success: function (data) {
            resp.html(data.response);

          },
        });
      }
      else {
        resp.html("");
      }
    }
  });
  // KLIK convertKode
    $(document).on('click','#kode', function(e) {
      var parent_table = this.parentNode.parentNode.parentNode.parentNode;
      num = $(this);
      query = $(this).val();
      resp = $(parent_table).find(".response_CU");
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
                url: 'phpfiles/ajax-master.php?ajax-master=response-cu',
                method: 'POST',
                data: {'items_barang' : arr2_items_barang, 'all_detailUnits' : all_detailUnits , 'all_item':all_item},
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
    });
  // AKHIR KLIK convertKode

  // TAMBAH MASTER
    $(document).on('click','.tambah_data_barang', function(){
      $('#btn_newline_barang').show();
      $('#judul_modal_barang').text("Tambah Data Barang");
      $('#nama').val("");
      $('#stok').val("");
      $('#kategori').val("");
      $('#merek').val("");
      $('#unit_beli').val("");
      $('#unit_base').val("");
      $('#unit_jual').val("");
      $('#h_jual').val("");
      $('#minstok').val("");
      $('#h_beli').val('');
      $('#insertDataBarang').val("Tambah");
    });
  // AKHIR TAMBAH MASTER

  // INSERT FORM MASTER

  // AKHIR INSERT FORM MASTER

  // EDIT DATA MASTER
    $(document).on('click','.edit_data_barang', function(){
      var id = $(this).attr('id');
      $('#btn_newline_barang').hide();
      $('#insertDataBarang').val('Edit');
      $('#judul_modal_barang').html('Edit Data Barang');
      $('#insert_form_barang').attr('action', 'http://localhost:8080/hijrahmandirimvc/public/master/setEditGood');
      $('#add_dataBarang').modal('show');
      $.ajax({
        url : 'http://localhost:8080/hijrahmandirimvc/public/master/getEditGood',
        method : 'POST',
        data :{'id' : id},
        dataType :'JSON',
        success : function(data) {
          $('#goods_id').val(data.id);
          $('#tabel_tambah_barang #kode').val(data.kode);
          $('#tabel_tambah_barang #nama').val(data.nama);
          $('#merek').val(data.merek_id);
          $('#kategori_id').val(data.kategori_id);
          $('#h_jual').val(data.h_jual);
          $('#h_beli').val(data.h_beli);
          $('#unit_beli').val(data.unit_beli);
          $('#unit_base').val(data.unit_awal);
          $('#stok').val(data.stok_unit);
          $('#minstok').val(data.min_qty);
          $('#qty_sale_unit').val(data.qty);
        }
      });
    });
  // AKHIR EDIT DATA MASTER

  // HAPUS DATA MASTER
    $(document).on('click','.hapus_data_barang', function(){
      var id = $(this).attr("id");
      $('#hapus_dataBarang').modal('show');
      $('#hapusgoods_id').val(id);


    });


  // AKHIR HAPUS DATA MASTER

  // UPLOAD MASTER DATA
    $(document).on('change','#input_upload_data', function(){
      var src_namafile = $(this).val();
      var namafile = src_namafile.split("\\");
      $("#label_pilih_file_master").html(namafile[namafile.length - 1]);
    });

    $("#upload_master_data").on('submit', function(){
      event.preventDefault();
      var file_data = $('#input_upload_data').prop('files')[0];
      var form_data = new FormData();
      $.ajax({
              type: "POST",
              url: 'phpfiles/ajax-master.php?ajax-master=upload_excel_barang',
              cache: false,
              contentType: false,
              processData: false,
              data: form_data,
              success: function(data){
                cekItemCombo();
                $("#judul_modal_barang").html('<p><i class="fa fa-spin fa-spinner"></i> Loading...</p>');
                setTimeout(function() {
                  $("#judul_modal_barang").html('<p><i class="fas fa-check"></i> Everything is ok... </p>');
                  setTimeout(reloadPage, 100);
                }, 500);
              }
            });
    });
   // AKHIR UPLOAD MASTER DATA


});
