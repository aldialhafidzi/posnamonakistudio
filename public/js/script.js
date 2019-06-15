
var clicked_navbar_content = false;

$(document).on('click','#sidebarCollapse', function(){
  clicked_navbar_content = true;
  if(clicked_navbar_content == true){
    $("#navbar_content").removeClass("fixed-top");
    clicked_navbar_content = false;
  }
});


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
var all_item = [];
var rd_cbo = [];

var mereknya = '';
var kategorinya = '';
var unitnya = '';
var cek = 'OK';
// Akhir Inisialisasi



// AKHIR CEK DETAIL BARANG FOR TRANSAKSI

// Fungsi Hilangkan Login Sebagai
function hilangkan_loginsebagai(){
  var width_browser_def =  $(window).width();
  if (width_browser_def < 576 ){
    $("#login_sebagai").html("");
    $("#login_sebagai").removeClass("col-sm-8 navbar-text");

  }
  else{
    $("#login_sebagai").html("Your login as admin");
    $("#login_sebagai").addClass("col-sm-8 navbar-text");

  }
}
// Akhir Fungsi Hilangkan Login Sebagai

$( window ).resize(function() {
  var width_browser =  $(window).width();

  if (width_browser < 576 ){
    $("#login_sebagai").html("");

    $("#login_sebagai").removeClass("col-sm-8 navbar-text");

  }
  else{
    $("#login_sebagai").html("Your login as admin");
    $("#login_sebagai").addClass("col-sm-8 navbar-text");

  }
});

hilangkan_loginsebagai();


$(document).on('input','#UangCash', function(){
  var cek_bayar = $("#UangCash").val();
  var cek_total_belanja = $("#total_belanjaNya").val();

  if(cek_bayar == ''){
    $("#UangCash").addClass("is-invalid");
    $(".invalid-tooltip").html("masukkan uang cash !");
    $("#UangCash").focus();
  }
  else if(parseInt(cek_bayar) < parseInt(cek_total_belanja)){
    $("#UangCash").addClass("is-invalid");
    $(".invalid-tooltip").html("uang kurang !");
    $("#UangCash").focus();
  }
  else{
    $("#UangCash").removeClass("is-invalid");
    $(".invalid-tooltip").html("");
  }

});


// AKHIR SIMPAN TRANSAKSI


// DOCUMENT READY FUNCTIONS
$(document).ready(function(){


  // AKHIR ADD / EDIT DATA MEREK
// ========================================================== A K H I R   M E R E K

// ========================================================= K A T E G O R I
  // INSERT DATA KATEGORI



  // AKHIR INSERT DATA KATEGORI

  // EDIT DATA KATEGORI

  // AKHIR EDIT DATA KATEGORI

  // HAPUS DATA KATEGORI


// ========================================================= A K H I R  D A T A  P E L A N G G A N

// ========================================================= H I S T O R I  P E N J U A L A N

$('a[href*="pdf"]').click(function(e) {
    e.preventDefault(); // stop the existing link from firing
    var documentUrl = $(this).attr("href"); // get the url of the pdf
    window.open(documentUrl, '_blank'); // open the pdf in a new window/tab
  });

// ========================================================= A K H I R  I S T O R I  P E N J U A L A N

// ========================================================= G A N T I  P A S S W O R D
$('#form_ganti_password').on('submit', function(event){
    event.preventDefault();
    var username = $("#username").val();
    var password_baru = $("#password_baru").val();
    var password_lama = $("#password_lama").val();
    $.ajax({
      url:"insert_password.php",
      method:"POST",
      data : {'username' : username, 'password_baru' : password_baru, 'password_lama' : password_lama },
      dataType : "JSON",
      success:function(data)
      {
        $("#keterangan_ganti_password").html(data.message);
        $("#status_cp").val(data.status_cp);
        $("#status_ganti_password").modal('show');
      }
    });


});

$("#btn_sukses_ganti_password").on('click', function(e) {
  e.preventDefault();
  if($("#status_cp").val() == "1"){
    location.reload();
  }
});
// ========================================================= A K H I R  G A N T I  P A S S W O R D



});





// AJAX CEK DETAIL BARANG
$.ajax({
  url:"http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax.php?ajax=cek_all_merek",
  method:"POST",
  data:{cek:cek},
  dataType:"JSON",
  success:function(data){
    mereknya = data.allmerek;

  }
});

$.ajax({
  url:"http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax.php?ajax=cek_all_unit",
  method:"POST",
  data:{cek:cek},
  dataType:"JSON",
  success:function(data){
    unitnya = data.allunit;

  }
});

$.ajax({
  url:"http://localhost:8080/hijrahmandirimvc/public/phpfiles/ajax.php?ajax=cek_all_kategori",
  method:"POST",
  data:{cek:cek},
  dataType:"JSON",
  success:function(data){
    kategorinya = data.allkategori;

  }
});

// AKHIR AJAX CEK DETAIL BARANG
