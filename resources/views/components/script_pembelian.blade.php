<script type="text/javascript">

var row_pembelian = 1;
var data_cart_pembelian = [];

@if (!empty($carts_pem))
  row_pembelian = {{ count($carts_pem) }};
  @foreach ($carts_pem as $key => $value)
    data_cart_pembelian.push({{ $carts_pem[$key]->good->id }});
  @endforeach
@endif

var pem_field_kode = '<select required style="width : 150px;" onchange="check_detail_barang_pembelian(this)" onclick="check_list_barang_pembelian(this)" placeholder="Kode / Nama Barang" class="form-control " id="p_kode" name="p_kode[]"> </select> <input required class="" type="hidden" name="p_good_id[]" id="p_good_id" value="">';
var pem_field_nama = '<label class="" style="width : 150px;" scope="col" id="p_nama_good"></label>';
var pem_field_unit = '<select onchange="hitung_total()" required numa="1" name="p_unit_good[]" id="p_unit_good" class="form-control change_unit_tr"=""> </select> <input type="hidden" name="p_qty_unit[]" id="p_qty_unit" value="">';
var pem_field_qty = '<input onchange="hitung_total()" required  style="width:60px;" scope="col"  type="number" numa="1" class="form-control  qty_1 edit_qty_tr" id="p_qty_good" name="p_qty_good[]" style="width:60px;">';
var pem_field_harga = '<label style="width : 100px;" scope="col" class="" id="p_harga_good_label"> </label> <input class="" type="hidden" name="p_harga_good[]" id="p_harga_good" value="">';
var pem_field_potongan = '<input onchange="hitung_total()" type="number"  class=" form-control edit_potongan_tr potongan" id="p_potongan" name="p_potongan[]" style="width:100px;" value="">';
var pem_field_subtotal = '<label style="width : 120px;" scope="col" class="" id="p_subtotal_label"> </label><input type="hidden" class="subtotal" class="" name="p_subtotal[]" id="p_subtotal" value="">';

function hapusRowPembelian(r) {
  var table_row = r.parentNode.parentNode;
  var x = r.parentNode.parentNode.rowIndex;

  for (var i = 0; i < data_cart.length; i++) {
    if(data_cart_pembelian[i] == parseInt($(table_row).find('#p_good_id').val())){
      if (i > -1) {
        data_cart_pembelian.splice([i], 1);
        break;
      }
    }
  }

  document.getElementById("tabel_pembelian").deleteRow(x-1);

  hitung_total();

  var no = 1;
  $('.baris-tr').each(function() {
    $(this).html(no);
    no++;
  });

  row_pembelian--;

  if(row_pembelian < 1){
    tambahRowPembelian();
  }

}

function tambahRowPembelian() {

  row_pembelian ++;

  var table = document.getElementById("tabel_pembelian");

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

  cell1.innerHTML = '<div style="width : 30px;" class="baris-tr" valign="center" align="center">'+row_pembelian+'</div>';
  cell2.innerHTML = '<div class="p-field-kode">'+pem_field_kode+'</div>';
  cell3.innerHTML = '<div class="p-field-nama">'+pem_field_nama+'</div>';
  cell4.innerHTML = '<div class="p-field-unit">'+pem_field_unit+'</div>';
  cell5.innerHTML = '<div class="p-field-qty">'+pem_field_qty+'</div>';
  cell6.innerHTML = '<div class="p-field-harga">'+pem_field_harga+'</div>';
  cell7.innerHTML = '<div class="p-field-potongan">'+pem_field_potongan+'</div>';
  cell8.innerHTML = '<div class="p-field-subtotal">'+pem_field_subtotal+'</div>';
  cell9.innerHTML = '<button onclick="hapusRowPembelian(this)" class="btn btn-danger btn-sm" id="HapusBaris" style="color:#fff;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';

  $(row).find('#p_kode').click();
}

function check_detail_barang_pembelian(x)
{
  $(x).on('select2:select', function (e) {

    var div_nya = e.currentTarget.parentElement.parentNode.parentNode;
    var tr_ = e.currentTarget.parentElement.parentNode.parentNode;
    var data = e.params.data;
    var id = data.good_id;

    console.log(data);

    if($(tr_).find('#p_kode').val() != ""){
      if(id != $(tr_).find('#p_kode').val()){
        for (var i = 0; i < data_cart_pembelian.length; i++) {
          if(data_cart_pembelian[i] == parseInt($(tr_).find('#p_good_id').val())){
            if (i > -1) {
              data_cart_pembelian.splice([i], 1);
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

    data_cart_pembelian.push(data.good_id);
    data_cart_pembelian = removeDuplicates(data_cart_pembelian);

    console.log(data_cart_pembelian);
  });
}

function check_list_barang_pembelian(x)
{
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
          temp: data_cart_pembelian
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


  function change_supplier(x){
    var kontak = $('#id_supplier option:selected').attr('kontak');
    var alamat = $('#id_supplier option:selected').attr('alamat');
    $('#nomor_hp_supplier').val(kontak);
    $('#alamat_supplier').val(alamat);
  }

  $(document).ready(function(){

    $('#add_supplier_baru').on('click', function(){
      save_method = 'add';
      $('input[name = _method]').val('POST');
      $('#judul_modal_supplier').text('Tambah Data Supplier');
      $('#insert_data_supplier').val('Simpan');
      $('#form_tambah_supplier')[0].reset();
    });



    @if (Session::has('status_pembelian'))
            $.notify("{{ session('status_pembelian') }}",
              {
                align:"right", verticalAlign:"top",
                close: true, delay:3000,
                color: "#fff", background: "#28c341",
                icon:"check",
                blur: 0.2,
              });
    @endif

    @if (Session::has('status_pembelian'))
            $.notify("{{ session('status_pembelian') }}",
              {
                align:"right", verticalAlign:"top",
                close: true, delay:3000,
                color: "#fff", background: "#28c341",
                icon:"check",
                blur: 0.2,
              });
    @endif


  });
</script>
