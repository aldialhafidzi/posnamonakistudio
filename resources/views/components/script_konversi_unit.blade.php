<script type="text/javascript">

var row_unit = 1;
var detail_convert_unit = $('.detail-convert-unit').html();
var deskripsi_convert_unit = $('.deskripsi-convert-unit').html();
var field_unit_convert_unit = $('.field-unit-convert-unit').html();
var options_units_convert_unit = $('#dcu_unit_id').html();
var data_cok_convert_unit = [];
var list_unit = [];

var display_unit_baru = false;

function check_list_unit(){
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
    url : '{{ route('check.list_unit') }}',
    type : 'POST',
    data : {'_token' : CSRF_TOKEN},
    dataType : 'JSON',
    success : function(data){
      list_unit = data;
    }
  });
}


function tambahRowConvertUnit() {

  row_unit = row_unit + 1;

  var table = document.getElementById("tabel_convert_unit");
  var row = table.insertRow(-1);
  var cell1 = row.insertCell(0);
  var cell2 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell4 = row.insertCell(3);

  cell1.innerHTML = '<div class="baris_RCU" align="center">'+row_unit+'</div>';
  cell2.innerHTML = '<div class="row deskripsi-convert-unit" style="padding-left : 10px; padding-right : 10px;">'+deskripsi_convert_unit+'</div>';
  cell3.innerHTML = '<div id="responseDetailUnits" class="detail-convert-unit">'+detail_convert_unit+'</div>'
  cell4.innerHTML = '<div align="center"><button type="button" onclick="hapusRowConvertUnit(this)" class="btn btn-danger btn-sm hapus-baris-convert-unit" name="btnHapusRowConvertUnit" id="btnHapusRowConvertUnit"><i class="fas fa-times"></i></button></div>';

  var number_arr = row_unit - 1 ;
  console.log(number_arr);
  $(row).find('#dcu_unit_id').attr('name', 'dcu_unit_id['+ number_arr +'][]');
  $(row).find('#dcu_unit_id').attr('baris', number_arr);
  $(row).find('#dcu_qty').attr('name', 'dcu_qty['+ number_arr +'][]');
  $(row).find('#dcu_keterangan').attr('name', 'dcu_keterangan['+ number_arr +'][]');
  $(row).find('#cu_kode').click();
  $(row).find('#dcu_unit_id').html(options_units_convert_unit);
  $(row).find('#cu_unit_awal').html(options_units_convert_unit);
}

function hapusRowConvertUnit(r) {
  var x = r.parentNode.parentNode.parentNode.rowIndex;

  document.getElementById("tabel_convert_unit").deleteRow(x);

  var tr_gede = r.parentNode.parentNode.parentNode;

  for (var i = 0; i < data_cok_convert_unit.length; i++) {
    if(data_cok_convert_unit[i] == parseInt($(tr_gede).find('#cu_good_id').val())){
      if (i > -1) {
        data_cok_convert_unit.splice([i], 1);
        break;
      }
    }
  }


  var no = 1;
  $('.baris_RCU').each(function() {

    var table_row = this.parentNode.parentNode;
    var baris_dcu = no - 1;

    $(table_row).find('.d_unit_id').each(function(){
      var tr_ = this.parentNode.parentNode.parentNode;

      $(tr_).find('#dcu_unit_id').attr('name', 'dcu_unit_id['+ baris_dcu +'][]');
      $(tr_).find('#dcu_qty').attr('name', 'dcu_qty['+ baris_dcu +'][]');
      $(tr_).find('#dcu_keterangan').attr('name', 'dcu_keterangan['+ baris_dcu +'][]');

      $(this).attr('baris', baris_dcu);
    });

    $(this).html(no);
    no++;
  });
  row_unit--;
  if(row_unit < 1) {
    tambahRowConvertUnit();
  }
}

function tambahRowDetailUnit(n) {
  var row_du = n.parentNode.parentNode;
  var tabel_row = n.parentNode.parentNode.parentNode.parentNode;
  var table = row_du.querySelector('#tabel_detail_convert_unit');

  var row = table.insertRow(-1);
  var cell1 = row.insertCell(0);
  var cell2 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell4 = row.insertCell(3);

  cell1.innerHTML = '<div class="field-unit-convert-unit">'+field_unit_convert_unit+'</div>';
  cell2.innerHTML = '<input autocomplete="off" type="text" pattern="[0-9.,]+" onchange="change_dcu_qty(this)" name="dcu_qty[][]" class="form-control-sm form-control" id="dcu_qty" required>';
  cell3.innerHTML = '<label id="dcu_keterangan" class="keterangan" name="dcu_keterangan[][]"></label>';
  cell4.innerHTML = '<div align="center"><button onclick="hapusRowDetailUnit(this)" numa="" class="btn  btn-sm " name="HapusBaris_dc" id="HapusBaris_dc" style="color:#fff;"><i class="fas fa-times"></i></button></div>';

  var baris_ke = parseInt($(tabel_row).find('.baris_RCU').html()) - 1;
  $(row).find('#dcu_unit_id').attr('name', 'dcu_unit_id['+ baris_ke +'][]');
  $(row).find('#dcu_qty').attr('name', 'dcu_qty['+ baris_ke +'][]');
  $(row).find('#dcu_unit_id').attr('baris', baris_ke);
  $(row).find('#dcu_keterangan').attr('name', 'dcu_keterangan['+ baris_ke +'][]');
  $(row).find('#dcu_unit_id').html(options_units_convert_unit);
}

function hapusRowDetailUnit(r) {
  var tr_du = r.parentNode.parentNode.parentNode.rowIndex;
  var table = r.parentNode.parentNode.parentNode.parentNode.parentNode;
  table.deleteRow(tr_du);
}

function check_list_barang_all(x)
{
  var tr_ = x.parentNode.parentNode.parentNode;
  var tr_gede = x.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;

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
          temp: data_cok_convert_unit
        };
      },
      processResults: function (data, params) {
        // $(x).val(null).trigger('change');
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
    placeholder: 'Kode / Nama',
    escapeMarkup: function (markup) { return markup; },
    templateResult: formatRepo,
    templateSelection: formatRepoSelection,
    // dropdownParent: $('#dropdownSelectKode'),
    dropdownCssClass : 'bigdrop',
    theme : "bootstrap"
  });
}


function check_detail_barang_unit(x)
{

  $(x).on('select2:select', function (e) {

    var div_nya = e.currentTarget.parentElement.parentNode.parentNode;
    var tr_ = e.currentTarget.parentElement.parentNode.parentNode.parentNode;
    var data = e.params.data;
    var id = data.good_id;

    if($(tr_).find('#cu_kode').val() != ""){
      if(id != $(tr_).find('#cu_kode').val()){

        for (var i = 0; i < data_cok_convert_unit.length; i++) {
          if(data_cok_convert_unit[i] == parseInt($(tr_).find('#cu_good_id').val())){
            if (i > -1) {
              data_cok_convert_unit.splice([i], 1);
              break;
            }
          }
        }

      }
    }


    $(div_nya).find('#cu_nama').val(data.text);
    $(div_nya).find('#cu_unit_awal').val(data.unit.id);
    $(div_nya).find('#cu_good_id').val(data.good_id);
    var number_row = $(tr_).find('#dcu_unit_id').attr('baris');
    var detail_unit = data.detail_unit;

    var html_mark = '';
    for (var j = 0; j < detail_unit.length; j++) {
      var keterangan = '';
      var options_units_convert_unit = '';
      
      for (var k = 0; k < list_unit.length; k++) {

        if (detail_unit[j].unit_id == list_unit[k].id){
          options_units_convert_unit = options_units_convert_unit + '<option qty_unit_id="'+detail_unit[j].qty+'" selected value="'+list_unit[k].id+'">'+list_unit[k].nama+'</option>';
          keterangan = '1 '+list_unit[k].nama+ ' = '+ detail_unit[j].qty+' '+data.unit.nama ;
        }
        else {
          options_units_convert_unit = options_units_convert_unit + '<option value="'+list_unit[k].id+'">'+list_unit[k].nama+'</option>';
        }
      }

      html_mark = html_mark + '<tr> <td> <div class="field-unit-convert-unit"> <select required value="'+detail_unit[j].unit_id+'" baris="'+number_row+'" numa="" onchange="change_dcu_unit_id(this)" name="dcu_unit_id['+number_row+'][]" id="dcu_unit_id" class="form-control pake-list-unit d_unit_id form-control-sm" required> '+options_units_convert_unit+' </select> </div></td><td> <input value="'+detail_unit[j].qty+'" autocomplete="off" type="text" pattern="[0-9.,]+" onchange="change_dcu_qty(this)" name="dcu_qty['+number_row+'][]" class="form-control-sm form-control" id="dcu_qty" required> </td><td> <label class="keterangan" id="dcu_keterangan" name="dcu_keterangan[0][]">'+keterangan+'</label> </td><td> <div align="center"> <button onclick="hapusRowDetailUnit(this)" numa="" class="btn btn-sm" name="HapusBaris_dc" id="HapusBaris_dc" style="color:#fff;"> <i class="fas fa-times"></i> </button> </div></td></tr>';
    }

    $(tr_).find('#tbody_detail_convert_unit').html(html_mark);

    function removeDuplicates(arr){
        let unique_array = [];
        for(let i = 0;i < arr.length; i++){
            if(unique_array.indexOf(arr[i]) == -1){
                unique_array.push(arr[i]);
            }
        }
        return unique_array;
    }

    data_cok_convert_unit.push(data.good_id);
    data_cok_convert_unit = removeDuplicates(data_cok_convert_unit);

  });
}

function change_dcu_unit_id(x)
{
  var tr_ = x.parentNode.parentNode.parentNode;
  $(tr_).find('#dcu_qty').val('');
  $(tr_).find('#dcu_keterangan').html('');
}

function change_dcu_qty(x)
{
  var tr_ = x.parentNode.parentNode;
  var tr_gede = x.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
  var nama_unit = $(tr_).find('#dcu_unit_id option:selected').text();
  var qty = $(x).val();
  $(tr_).find('#dcu_keterangan').html('1 '+nama_unit+ ' = '+qty+ ' '+$(tr_gede).find('#cu_unit_awal option:selected').text());
}

  $(document).ready(function(){
    check_list_unit();
    $('#btn_conversi_unit').on('click', function(){

      $('input[name = _method]').val('POST');
      $('#form_pengaturan_unit')[0].reset();
      $('.hapus-baris-convert-unit').each(function(){
          if ( $('.hapus-baris-convert-unit').length > 1){
            hapusRowConvertUnit(this);
            row_unit = 1;
          }
      });

    });

    $('#btn-new-unit').on('click', function(){
      if(display_unit_baru == true){
        display_unit_baru = false;
        $("#div_unit_baru").hide();
        $('#btn-new-unit').html('<i class="fas fa-plus"></i> Unit Baru');
      }else {
        display_unit_baru = true;
        $("#div_unit_baru").show();
        $('#form_tambah_unit')[0].reset();
        $('input[name = _method]').val('POST');
        $(this).html('Hide');
      }
    });


    $('#form_pengaturan_unit').submit(function(e){
      e.preventDefault();
      if($('#form_pengaturan_unit')[0].checkValidity() === false){

      }else {
        $.ajax({
          url : "{{ route('store.detailunit.submit') }}",
          type : "POST",
          data : new FormData($('#form_pengaturan_unit')[0]),
          contentType : false,
          processData : false,
          success : function(data){

            $('#form_pengaturan_unit')[0].reset();
            $('#modal_konversi_unit').modal('hide');
            $.notify(" "+data.message,
              {
                align:"right", verticalAlign:"bottom",
                close: true, delay:3000,
                color: "#fff", background: "#41a845",
                icon:"check"
              });
          },
          error : function(data){
            $.notify("  Terjadi kesalahan pada saat mengatur unit !",
              {
                align:"right", verticalAlign:"bottom",
                close: true, delay:3000,
                color: "#fff", background: "#c3383f",
                icon:"close"
              });
          }
        });

      }
      $('#form_pengaturan_unit').addClass('was-validated');
    });


    $('#form_tambah_unit').submit(function (event) {
      event.preventDefault();
      if ($('#form_tambah_unit')[0].checkValidity() === false) {
          event.stopPropagation();
      } else {
        $.ajax({
          url : "{{ url('unit') }}",
          type : "POST",
          data : new FormData($('#form_tambah_unit')[0]),
          contentType : false,
          processData : false,
          success : function(data){
            check_list_unit();
            $('#btn-new-unit').html('<i class="fas fa-plus"></i> Unit Baru');
            $("#div_unit_baru").hide();
            $('.pake-list-unit').each(function(){
              $(this).append('<option value="'+data.id+'">'+$('#input_unit').val()+'</option>');
            });
            options_units_convert_unit  = options_units_convert_unit + '<option value="'+data.id+'">'+$('#input_unit').val()+'</option>';
            $('#input_unit').val('');
            $.notify(" "+data.message,
              {
                align:"right", verticalAlign:"bottom",
                close: true, delay:3000,
                color: "#fff", background: "#41a845",
                icon:"check"
              });
          },
          error : function(data){
            $.notify("  Unit gagal ditambahkan !",
              {
                align:"right", verticalAlign:"bottom",
                close: true, delay:3000,
                color: "#fff", background: "#c3383f",
                icon:"close"
              });
          }
        });
      }
       $('#form_tambah_unit').addClass('was-validated');
    });


  });



















</script>
