$(document).ready(function(){

  $('#date_dari_barang').datepicker({
          uiLibrary: 'bootstrap4',
          format: 'yyyy-mm-dd'
      });

  $('#date_sampai_barang').datepicker({
          uiLibrary: 'bootstrap4',
          format: 'yyyy-mm-dd'
  });

  $('input[type=radio][name=printGood]').change(function() {
    if (this.value == 'stokPertanggal') {
      $('#tanggal_monitoring').html('<div class="col-sm-6"><label for="">Tanggal :</label><input required autocomplete="off" name="tanggal" id="tanggal" class="form-control" size="16" type="text" value=""></div>');
      $('#tanggal').datepicker({
              uiLibrary: 'bootstrap4',
              format: 'yyyy-mm-dd'
          });
    } else {
      $('#tanggal_monitoring').html('<div class="col-sm-6"><label for="">Dari:</label><input required autocomplete="off" name="date_dari_barang" id="date_dari_barang" class="form-control" size="16" type="text" value=""></div><div class="col-sm-6"><label for="">Sampai:</label><input required autocomplete="off" id="date_sampai_barang" name="date_sampai_barang" class="form-control" size="16" type="text" value=""></div>');
    }

    $('#date_dari_barang').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm-dd'
        });

    $('#date_sampai_barang').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm-dd'
    });
});


  $('#date_dari').datepicker({
          uiLibrary: 'bootstrap4',
          format: 'yyyy-mm-dd'
      });

  $('#date_sampai').datepicker({
          uiLibrary: 'bootstrap4',
          format: 'yyyy-mm-dd'
  });



  $('#date_dari_purchases').datepicker({
          uiLibrary: 'bootstrap4',
          format: 'yyyy-mm-dd'
  });

  $('#date_sampai_purchases').datepicker({
          uiLibrary: 'bootstrap4',
          format: 'yyyy-mm-dd'
  });

  $('#choose_cust').select2({
    placeholder: "Customer",
  });

  $('#choose_supp').select2({
    placeholder : "Supplier",
  });

  $('#choose_good').select2({
    placeholder : "Good",
  });

  $(document).on('change','#choose_cust',function() {
    var chooseOptions = $("#choose_cust").val();
    lengthOptions = $('#choose_cust > option').length;
    if(chooseOptions.length < lengthOptions ){
      $("#selectAllCust").prop("checked", false);
    }
  });

  $(document).on('change','#choose_supp',function() {
    var chooseOptions = $("#choose_supp").val();
    lengthOptions = $('#choose_supp > option').length;
    if(chooseOptions.length < lengthOptions ){
      $("#selectAllSupplier").prop("checked", false);
    }
  });

  $(document).on('change','#choose_good',function() {
    var chooseOptions = $("#choose_good").val();
    lengthOptions = $('#choose_good > option').length;
    if(chooseOptions.length < lengthOptions ){
      $("#selectAllGood").prop("checked", false);
    }
  });

  $("#selectAllGood").click(function(){
    if($("#selectAllGood").is(':checked') ){
      $("#choose_good").find('option').prop("selected",true);
      $("#choose_good").trigger('change');
    } else {
      $("#choose_good").find('option').prop("selected",false);
      $("#choose_good").trigger('change');
    }
});

  $("#selectAllSupplier").click(function(){
    if($("#selectAllSupplier").is(':checked') ){
      $("#choose_supp").find('option').prop("selected",true);
      $("#choose_supp").trigger('change');
    } else {
      $("#choose_supp").find('option').prop("selected",false);
      $("#choose_supp").trigger('change');
    }
});


  $("#selectAllCust").click(function(){
    if($("#selectAllCust").is(':checked') ){
      $("#choose_cust").find('option').prop("selected",true);
      $("#choose_cust").trigger('change');
    } else {
      $("#choose_cust").find('option').prop("selected",false);
      $("#choose_cust").trigger('change');
    }
});

});
