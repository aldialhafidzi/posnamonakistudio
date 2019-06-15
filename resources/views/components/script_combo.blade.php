<script type="text/javascript">
  var row_combo = 1;
  var baris = row_combo - 1;
  var deskripsi = $('.deskripsi-form-tambah-combo').html();
  var detail = $('.detail-form-tambah-combo').html();
  var field_kode = $('.field-kode').html();
  var field_nama = $('.field-nama').html();
  var field_unit = $('.field-unit').html();
  var field_qty  = $('.field-qty').html();

  var select_item = [];
  var data_cok = [];

  var table_combo = $('#tabel_combo').DataTable({
    processing:true,
    serverSide:true,
    order : [[ 0, "asc" ]],
    ajax: "{{ route('all.combo') }}",
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

  function deleteComboForm(id){
    $('#hapus_data_id').val(id);
    $('input[name = _method]').val('DELETE');
    url_hapus_data = 'combo';
  }

  function editComboForm(id){
    save_method = 'edit';
    $('input[name = _method]').val('PATCH');
    $('#form_tambah_combo')[0].reset();
    $('#tbody_detail_combo').html('');
    $('.hapus-baris-combo').each(function(){
      if ($('.hapus-baris-combo').length > 1){
        hapusRowCombo(this);
        row_combo = 1;
        baris = row_combo - 1;
      }
    });

    data_cok = [];
    data_cok.push([]);

    $.ajax({
      url : "{{ url('combo') }}" + '/' + id + "/edit",
      type : "GET",
      dataType : "JSON",
      success : function(data){
        console.log(data);
        $('#modal_tambah_combo').modal('show');
        $('#judul_modal_tambah_combo').text('Edit Data Combo');
        $('#btn_insert_combo').val('Update Data');
        $('#btn_newline_combo').hide();
        $('#HapusBaris').hide();

        $('#c_kode').val(data[0].kode);
        $('#c_nama').val(data[0].nama);
        $('#c_min_qty').val(data[0].min_qty);
        $('#c_h_jual').val(data[0].h_jual);
        $('#c_unit_jual').val(data[0].unit_jual);
        $('#combo_id').val(id);
        var html_dc = '';
        var data_combo = data[0].combo;

        for (var i = 0; i < data_combo.length; i++) {

          data_cok[0].push(data_combo[i].good_id);

          var option_units = '';
          var data_detail_unit = data_combo[i].combo_to_good.detail_unit;
          var value_dc_qty = '';
          for (var j = 0; j < data_detail_unit.length; j++) {
            if (data_combo[i].combo_to_good.unit_jual == data_detail_unit[j].unit.id) {
              option_units = option_units + '<option selected value="'+data_detail_unit[j].unit.id+'">'+data_detail_unit[j].unit.nama+'</option>';
              value_dc_qty = data_detail_unit[j].qty;
            }
            else {
              option_units = option_units + '<option value="'+data_detail_unit[j].unit.id+'">'+data_detail_unit[j].unit.nama+'</option>';
            }
          }

          html_dc = html_dc + '<tr> <td> <div class="field-kode"> <select value="'+data_combo[i].combo_to_good.kode+'" form="form_tambah_combo" id="dc_kode" baris="0" form="form_tambah_combo" class="form-control-sm dc_kode" onclick="check_list_barang(this)" onchange="check_detail_barang(this)" name="dc_kode[0][]"> <option value="'+data_combo[i].combo_to_good.kode+'">'+data_combo[i].combo_to_good.kode+'</option> </select> <div id="dropdownSelectKode"></div><div class="invalid-feedback"> Harus diisi. </div></div></td><td> <div class="field-nama"> <label id="dc_nama" name="dc_nama[0][]">'+data_combo[i].combo_to_good.nama+'</label> </div></td><td> <div class="field-unit"> <select form="form_tambah_combo" numa="" name="dc_unit[0][]" id="dc_unit" class="form-control change_unit form-control-sm" required>'+option_units+'</select> <div class="invalid-feedback"> Harus diisi. </div></div></td><td> <div class="field-qty"> <input form="form_tambah_combo" autocomplete="off" type="number" name="dc_qty[0][]" class="form-control-sm form-control dc_qty" id="dc_qty" required value="'+data_combo[i].qty+'"> <div class="invalid-feedback"> Harus diisi. </div></div></td><td> <div align="center"> <button onclick="hapusRowDetailCombo(this)" numa="" class="btn btn-sm" name="HapusBaris_dc" id="HapusBaris_dc" style="color:#fff;"> <i class="fas fa-times"></i> <input form="form_tambah_combo" type="hidden" name="dc_good_id[0][]" id="dc_good_id" value="'+data_combo[i].combo_to_good.id+'"> </button> </div></td></tr>';

        }

        $('#tbody_detail_combo').html(html_dc);
        $('.dc_kode').each(function(){
          $(this).click();
        });


      },
      error : function(){
        alert("Not working properly!");
      }

    });
  }

  function tambahComboForm() {
    save_method = 'add';
    $('input[name = _method]').val('POST');
    $('#judul_modal_tambah_combo').text('Tambah Data Combo');
    $('#form_tambah_combo')[0].reset();
    $('#btn_newline_combo').show();
    $('#HapusBaris').show();
    $('#btn_insert_combo').val('Simpan Data');


    $('.hapus-baris-combo').each(function(){
      if ($('.hapus-baris-combo').length > 1){
        hapusRowCombo(this);
        row_combo = 1;
        baris = row_combo - 1;
      }
    });

    data_cok = [];
    data_cok.push([]);
  }

  function hapusRowCombo(r) {
    var x = r.parentNode.parentNode.parentNode.rowIndex;
    document.getElementById("tabel_tambah_combo").deleteRow(x);

    var tr_gede = r.parentNode.parentNode.parentNode;
    var z = parseInt($(tr_gede).find('#number_cbo').html()) - 1;

    if (z > -1){
      data_cok.splice(z, 1);
    }

    var no = 1;
    $('.baris-combo').each(function() {
      var table_row = this.parentNode.parentNode;
      var baris_dc = no - 1;

      $(table_row).find('.dc_kode').each(function(){
        var tr_ = this.parentNode.parentNode.parentNode;

        $(tr_).find('#dc_kode').attr('name', 'dc_kode['+ baris_dc +'][]');
        $(tr_).find('#dc_unit').attr('name', 'dc_unit['+ baris_dc +'][]');
        $(tr_).find('#dc_qty').attr('name', 'dc_qty['+ baris_dc +'][]');
        $(tr_).find('#dc_good_id').attr('name', 'dc_good_id['+ baris_dc +'][]');

        $(this).attr('baris', baris_dc);
      });

      $(this).html(no);
      no++;
    });

    row_combo--;
    if(row_combo < 1) {
      tambahRowCombo();
    }

  }

  function tambahRowCombo(){
    var table = document.getElementById("tabel_tambah_combo");
    row_combo++;
    var row = table.insertRow(-1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);

    cell1.innerHTML = '<div  id="number_cbo" class="baris-combo" align="center">'+row_combo+'</div><input autocomplete="off" form="insert_form_combo" type="hidden" id="combo_id" name="combo_id[]" value="">';
    cell2.innerHTML = '<div  class="deskripsi-form-tambah-combo">'+deskripsi+'</div>';
    cell3.innerHTML = '<div class="detail-form-tambah-combo">'+detail+'</div>';
    cell4.innerHTML = '<div align="center"><button onclick="hapusRowCombo(this)" class="btn btn-danger btn-sm hapus-baris-combo" id="HapusBaris" style="color:#fff;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></div>';

    $(row).find('#c_kode').val('');
    $(row).find('#c_nama').val('');
    $(row).find('#c_h_jual').val('');
    $(row).find('#dc_kode').val('');

    var number_arr = row_combo - 1 ;

    $(row).find('#dc_kode').attr('baris', number_arr);
    $(row).find('#dc_kode').attr('name', 'dc_kode['+ number_arr +'][]');
    $(row).find('#dc_qty').attr('name', 'dc_qty['+ number_arr +'][]');
    $(row).find('#dc_unit').attr('name', 'dc_unit['+ number_arr +'][]');
    $(row).find('#dc_good_id').attr('name', 'dc_good_id['+ number_arr +'][]');

    $(row).find('#dc_kode').click();
    $(row).find('#dc_nama').text('');
    $(row).find('#dc_unit').val('');
    $(row).find('#dc_qty').val('');
    $(row).find('#dc_good_id').val('');


    data_cok.push([]);
  }

  function hapusRowDetailCombo(r) {
    var tr_dc = r.parentNode.parentNode.parentNode.rowIndex;
    var tr_gede = r.parentNode.parentNode.parentNode;
    var table = r.parentNode.parentNode.parentNode.parentNode.parentNode;
    var z = parseInt($(tr_gede).find('#dc_kode').attr('baris'));

    for (var i = 0; i < data_cok[z].length; i++) {
      if(data_cok[z][i] == parseInt($(r).find('#dc_good_id').val())){
        if (i > -1) {
          data_cok[z].splice([i], 1);
          break;
        }
      }
    }
    console.log(data_cok);

    table.deleteRow(tr_dc);


  }

  function tambahRowDetailCombo(n){
    var row_dc = n.parentNode.parentNode.parentNode;
    var table = row_dc.querySelector('#table_detail_combo tbody');
    console.log(table);
    var row = table.insertRow(-1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);

    var tabel_row = n.parentNode.parentNode.parentNode.parentNode;
    var baris_ke = parseInt($(tabel_row).find('#number_cbo').html()) - 1;

    cell1.innerHTML = '<div class="field-kode">'+field_kode+'</div>';
    cell2.innerHTML = '<div class="field-nama keterangan">'+field_nama+'</div>';
    cell3.innerHTML = '<div class="field-unit">'+field_unit+'</div>';
    cell4.innerHTML = '<div class="field-qty">'+field_qty+'</div>';
    cell5.innerHTML = '<div align="center"><button onclick="hapusRowDetailCombo(this)" numa="" class="btn  btn-sm name="HapusBaris_dc" id="HapusBaris_dc" style="color:#fff;"><i class="fas fa-times"></i><input type="hidden" name="dc_good_id['+baris_ke+'][]" id="dc_good_id" value=""></button></div>';


    $(row).find('#dc_kode').attr('baris', baris_ke);
    $(row).find('#dc_kode').attr('name', 'dc_kode['+ baris_ke +'][]');
    $(row).find('#dc_qty').attr('name', 'dc_qty['+ baris_ke +'][]');
    $(row).find('#dc_unit').attr('name', 'dc_unit['+ baris_ke +'][]');
    $(row).find('#dc_good_id').attr('name', 'dc_good_id['+ baris_ke +'][]');

    $(row).find('#dc_kode').val('');
    $(row).find('#dc_kode').click();
    $(row).find('#dc_nama').text('');
    $(row).find('#dc_unit').val('');
    $(row).find('#dc_qty').val('');
    $(row).find('#dc_good_id').val('');

  }

  // SELECT 2

  function formatRepo (repo) {
    // console.log(repo);
    if (repo.loading) {
      return "Searching...";
    }
      console.log(repo);
      var markup = '';
      if (repo.stok_unit > repo.min_qty) {
        markup = "<a good_id='"+repo.good_id+"' class='list-group-item list-group-item-action hilangkan for-ajax cek_br_tr cek-detail-barang' style='font-size : 14px; color : #0f0f0f; '> <b>Kode </b>: "+repo.id+"  -  <b style='color: #1aab4f;'>Tersedia </b> : "+repo.stok_unit+" <br> "+repo.text+" </a> ";
      }
      else if(repo.stok_unit == repo.min_qty){
        markup = "<a good_id='"+repo.good_id+"' class='list-group-item list-group-item-action hilangkan for-ajax cek_br_tr cek-detail-barang' style='font-size : 14px; color : #0f0f0f; '> <b>Kode </b>: "+repo.id+"  -  <b style='color: #f1cf1e;'>Tersedia </b> : "+repo.stok_unit+" <br> "+repo.text+" </a> ";
      }
      else {
        markup = "<a good_id='"+repo.good_id+"' class='list-group-item list-group-item-action hilangkan for-ajax cek_br_tr cek-detail-barang' style='font-size : 14px; color : #0f0f0f; '> <b>Kode </b>: "+repo.id+"  -  <b style='color: #b6b6b6;'>Barang Kosong </b> <br> "+repo.text+" </a> ";
      }

      return markup;
  }

  function formatRepoSelection (repo) {
    if(repo.id != ""){
      return repo.id;
    }
    else {
      return "Kode / Nama";
    }

  }

  function check_list_barang(x)
  {
    var tr_ = x.parentNode.parentNode.parentNode;
    var tr_gede = x.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;

    $(x).select2({
        ajax: {
        url: '/all/good_no_combo',
        dataType: 'json',
        delay: 250,
        data: function (params) {
          var z = parseInt($(x).attr('baris'));
          return {
            q: params.term,
            page: params.page,
            temp: data_cok[z]
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
      theme: "bootstrap"
    });
  }

  function check_detail_barang(x)
  {

    $(x).on('select2:select', function (e) {
      var div_nya = e.currentTarget.parentElement.parentNode.parentNode;
      var data = e.params.data;
      var id = data.good_id;

      var tr_ = x.parentNode.parentNode.parentNode;
      var tr_gede = x.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;

      if($(tr_).find('#dc_good_id').val() != ""){
        if(id != $(tr_).find('#dc_good_id').val()){
          var z = parseInt($(tr_gede).find('#number_cbo').html()) - 1;
          for (var i = 0; i < data_cok[z].length; i++) {
            if(data_cok[z][i] == parseInt($(tr_).find('#dc_good_id').val())){
              if (i > -1) {
                data_cok[z].splice([i], 1);
                break;
              }
            }
          }
        }
      }


      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
        url : '{{ route('check.detail_unit') }}',
        type : 'POST',
        data : {'id' : id, '_token' : CSRF_TOKEN},
        dataType : 'JSON',
        success : function(data_json){

          var option_units = '';
          for (var i = 0; i < data_json.length; i++) {
            option_units = option_units + '<option value="'+data_json[i].unit_id+'">'+data_json[i].unit.nama+'</option>'
          }

          $(div_nya).find('#dc_nama').text(data.text);
          $(div_nya).find('#dc_unit').html(option_units);
          $(div_nya).find('#dc_qty').val('1');
          $(div_nya).find('#dc_good_id').val(data.good_id);

          function removeDuplicates(arr){
              let unique_array = [];
              for(let i = 0;i < arr.length; i++){
                  if(unique_array.indexOf(arr[i]) == -1){
                      unique_array.push(arr[i]);
                  }
              }
              return unique_array;
          }

          var z = parseInt($(div_nya).find('#dc_kode').attr('baris'));

          if (data_cok[z] == undefined) {
            data_cok.push([data.good_id]);
          }
          else {
            data_cok[z].push(data.good_id);
          }

          data_cok[z] = removeDuplicates(data_cok[z]);

        }
      });
    });
  }

  function check_kode_combo(x) {
    var div_nya = x.parentNode;
    var kode = $(x).val();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
      url : '{{ route('check.kode') }}',
      type : 'POST',
      data : {'kode' : kode, '_token' : CSRF_TOKEN},
      dataType : 'JSON',
      success : function(data){
        if (data == 1){
          $('#g_kode_error').text('Kode sudah digunakan.');
          $(div_nya).find('#c_kode').addClass('is-invalid');
        }
        else {
          $('#g_kode_error').text('Harus diisi.');
          $(div_nya).find('#c_kode').removeClass('is-invalid');
        }
      }
    });

  }

  $(document).ready(function(){

    $('.dc_kode').click();


    $('#form_tambah_combo').submit(function (event) {
      event.preventDefault();
      if ($('#form_tambah_combo')[0].checkValidity() === false) {
          event.stopPropagation();
      } else {
        var id = $('#combo_id').val();
        if (save_method == 'add') url = "{{ url('combo') }}";
        else url = "{{ url('combo') . '/' }}" + id;

        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#form_tambah_combo')[0]),
          contentType : false,
          processData : false,
          success : function(data){
            data_cok = [];
            $('#modal_tambah_combo').modal('hide');
            table_combo.ajax.reload();
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
      $('#form_tambah_combo').addClass('was-validated');
    });



  });


</script>
