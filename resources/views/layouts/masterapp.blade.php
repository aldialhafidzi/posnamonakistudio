

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $judul }}</title>
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/style-gua.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/glyphicons.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/style-que.css') }}">
    <link rel="shortcut icon" href="{{ URL::asset('images/qstitle.ico') }}" type="image/x-icon" >
    <link rel="stylesheet" href="{{ URL::asset('css/jquerysctipttop.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('css/jquery.mCustomScrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-multiselect.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/notify.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/prettify.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('js/datatables/data-tables/css/dataTables.bootstrap4.css') }}" >
    <link rel="stylesheet" href="{{ URL::asset('js/datatables/buttons.bootstrap4.min.css') }}" >
    <link rel="stylesheet" href="{{ URL::asset('/css/select2.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/select2-bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('fonts/themify/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('fonts/elegant-font/html-css/style.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/css/gijgo.min.css" rel="stylesheet" type="text/css" />

    <script src="{{ URL::asset('js/jquery-3.3.1.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('js/validator.js') }}"></script>
    <script src="{{ URL::asset('js/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('js/popper.min.js') }}"></script>
    <script src="{{ URL::asset('js/notify.js') }}"></script>
    <script src="{{ URL::asset('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ URL::asset('dist/js/BsMultiSelect.js') }}"></script>
    <script src="{{ URL::asset('js/gijgo.min.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap-multiselect.js') }}"></script>
    <script src="{{ URL::asset('js/datatables/absolute.js') }}"></script>
    <script src="{{ URL::asset('js/datatables/sort-currency.js') }}"></script>
    <script src="{{ URL::asset('js/datatables/data-tables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('js/select2/select2.js') }}"></script>
    <script src="{{ URL::asset('js/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('js/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('js/datatables/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('js/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('js/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('js/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('js/datatables/buttons.flash.min.js') }}"></script>
    <script src="{{ URL::asset('js/savy.js') }}"></script>
    <script src="{{ URL::asset('js/script_saya.js') }}"></script>
    <script src="{{ URL::asset('js/script_laporan.js') }}"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

</head>
<div class="overlay"></div>
<body>
    <div id="app">

      <div class="wrapper">
        <nav id="sidebar">
          <div id="dismiss">
            <i class="fas fa-arrow-left"></i>
          </div>

          <div class="sidebar-header">
            <a class="navbar-brand" href="penjualan" target="_top">
              <img src="{{ URL::asset('images/qshop.png') }}" alt="" style="width:128px;">
            </a>
          </div>

          <ul class="list-unstyled components">
            @role('admin|user')
              <li class="">
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false"><i class="fas fa-shopping-cart"></i> &nbsp; Penjualan</a>
                  <ul class="collapse list-unstyled" id="homeSubmenu">
                    <li>
                      <a href="penjualan"><i class="fas fa-shopping-cart"></i>&nbsp;&nbsp;  Transaksi</a>
                    </li>
                    <li>
                      <a href="histori-penjualan"><i class="fas fa-history"></i>&nbsp;&nbsp;  Histori Penjualan</a>
                    </li>
                    <li>
                      <a href="customer"><i class="fas fa-table"></i>&nbsp;&nbsp;  Data Pelanggan</a>
                    </li>
                  </ul>
              </li>
            @endrole

            @role('admin|gudang')
              <hr>
              <li>
                <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false"><i class="fas fa-database"></i> &nbsp; Master</a>
                  <ul class="collapse list-unstyled" id="pageSubmenu">
                    <li>
                      <a href="master"><i class="fas fa-cubes"></i>&nbsp;&nbsp;  Semua Barang</a>
                    </li>
                    <li>
                      <a href="combo">&nbsp;&nbsp;  List Combo</a>
                    </li>
                    <li>
                      <a href="brand">&nbsp;&nbsp;  List Merek</a>
                    </li>
                    <li>
                      <a href="category">&nbsp;&nbsp;  List Kategori</a>
                    </li>
                  </ul>
              </li>

                @role('admin')
                  <li>
                    <a href="laporan"><i class="fas fa-clipboard-list"></i> &nbsp;  Laporan</a>
                  </li>
                  <li>
                    <a href="user"><i class="fas fa-users"></i> &nbsp;  List User</a>
                  </li>
                @endrole

              <li>
                <a href="#pembelianmenu" data-toggle="collapse" aria-expanded="false"><i class="far fa-money-bill-alt"></i> &nbsp;  Pembelian</a>
                  <ul class="collapse list-unstyled" id="pembelianmenu">
                    <li>
                      <a href="pembelian"><i class="fas fa-money-bill-alt"></i>&nbsp;&nbsp;Transaksi</a>
                    </li>
                    <li>
                      <a href="histori-pembelian"><i class="fas fa-history"></i>&nbsp;&nbsp;Histori Pembelian</a>
                    </li>
                    <li>
                      <a href="supplier"><i class="fas fa-table"></i>&nbsp;&nbsp;Data Pemasok</a>
                    </li>
                  </ul>
              </li>
            @endrole

              <hr>
              <li>
                <a href="#pageLogout" data-toggle="collapse" aria-expanded="false"><i class="fas fa-user-tie"></i> &nbsp;  {{  Auth::user()->name }}</a>
                <ul class="collapse list-unstyled" id="pageLogout">
                  <li>
                    <a href="{{ route('change.password') }}"><i class="fas fa-sync-alt"></i>&nbsp;&nbsp; Ganti Password</a>
                  </li>
                  <li>
                    <a href="#" onclick="logout()">
                      <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;&nbsp;Logout
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
        </nav>
      </div>

      <div id="content" class="content">
        <nav id="navbar_content" class="navbar navbar-expand-lg navbar-warna bg-navbar fixed-top">

          <div class="row tanda_login">
            <div class="col-sm-4" style="padding-left:20px;">
              <a class="navbar-brand" href="penjualan" target="_top">
                <img src="{{ URL::asset('images/icon.png') }}" alt="" style="width:40px;">
              </a>
            </div>

            <div class="col-sm-8 navbar-text login_sebagai_" style="padding-right : 10px; padding-left : 10px;">
                 Your login as Admin
            </div>

          </div>

                <button id="sidebarCollapse"  class="btn btn-primary d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse"  aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-align-justify"></i>
                </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto" style="padding-left : 30px;">

                @role('admin|user')
                  @if ($page == "penjualan")
                    <li class="nav-item dropdown active" id="p_penjualan">
                  @else
                    <li class="nav-item dropdown" id="p_penjualan">
                  @endif
                    <a class="nav-link dropdown-toggle  " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-shopping-cart"></i>
                      &nbsp;Penjualan&nbsp;
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item-custom" href="penjualan"><i class="fas fa-shopping-cart"></i>&nbsp;&nbsp;Transaksi</a>
                      <a class="dropdown-item-custom" href="histori-penjualan"><i class="fas fa-history"></i>&nbsp;&nbsp;Histori Penjualan</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item-custom" href="customer"><i class="fas fa-table"></i>&nbsp;&nbsp;Data Pelanggan</a>
                    </div>
                  </li>
                @endrole


                @role('admin|gudang')
                  @if ($page == "master")
                    <li class="nav-item dropdown active" id="p_master">
                  @else
                    <li class="nav-item dropdown" id="p_master">
                  @endif
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                      <i class="fas fa-database"></i>
                      &nbsp;Master&nbsp;
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="good"><i class="fas fa-cubes"></i>&nbsp;&nbsp;Semua Barang</a>

                      <a class="dropdown-item" href="combo"><i class="fas fa-cube"></i>&nbsp;&nbsp;List Combo</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="brand">List Merk</a>
                      <a class="dropdown-item" href="category">List Kategori</a>

                    </div>
                  </li>

                    @role('admin')
                      @if ($page == 'laporan')
                        <li class="nav-item active" id="p_laporan">
                      @else
                        <li class="nav-item" id="p_laporan">
                      @endif
                        <a class="nav-link" href="laporan">
                          <i class="fas fa-clipboard-list"></i>
                            &nbsp;Laporan&nbsp;</a>
                         </li>

                      @if ($page == "user")
                          <li class="nav-item active" id="p_user">
                      @else
                          <li class="nav-item" id="p_user">
                      @endif
                          <a class="nav-link" href="user">
                            <i class="fas fa-users"></i>
                              &nbsp;List User&nbsp;</a>
                            </li>
                    @endrole


                  @if ($page == 'pembelian')
                    <li class="nav-item dropdown active" id="p_pembelian">
                  @else
                    <li class="nav-item dropdown" id="p_pembelian">
                  @endif

                    <a class="nav-link dropdown-toggle  " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="far fa-money-bill-alt"></i>
                      &nbsp;Pembelian&nbsp;
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item-custom" href="pembelian"><i class="fas fa-money-bill-alt"></i>&nbsp;&nbsp;Transaksi</a>
                      <a class="dropdown-item-custom" href="histori-pembelian"><i class="fas fa-history"></i>&nbsp;&nbsp;Histori Pembelian</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item-custom" href="supplier"><i class="fas fa-table"></i>&nbsp;&nbsp;Data Pemasok</a>
                    </div>
                  </li>
                @endrole


              </ul>
                <div class="nav-item dropdown" id="p_gantipassword">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-tie"></i></span>
                    &nbsp;{{  Auth::user()->name }}&nbsp;
                  </a>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('change.password') }}"><i class="fas fa-sync-alt"></i>&nbsp;&nbsp;Ganti Password</a>
                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="#" onclick="logout()")>
                      <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;&nbsp;Logout&nbsp;
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>


                  </div>
            </div>
          </div>
        </nav>
      </div>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <br>
    <p class="text-center " > Aplikasi Penjualan &copy; 2018 by Aldi </p>
    <hr style="border-color:#999; border-style:dashed; ">
        </div>
      </div>

</body>


@include('components.script_saya')
@include('components.script_combo')
@include('components.script_konversi_unit')
@include('components.script_merek')
@include('components.script_kategori')
@include('components.script_user')
@include('components.script_penjualan')
@include('components.script_histori_penjualan')
@include('components.script_histori_pembelian')
@include('components.script_customer')
@include('components.script_supplier')
@include('components.script_pembelian')

<script type="text/javascript">
  function logout(){
    $('#logout-form').submit();
  }

  $(document).ready(function(){
    $("#sidebar").mCustomScrollbar({
        theme: "minimal"
    });

    $('#dismiss, .overlay').on('click', function () {
        $('#sidebar').removeClass('active');
        $('.overlay').fadeOut();
    });

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').addClass('active');
        $('.overlay').fadeIn();
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });

    $('body').on('keyup', function (e) {
      var p = e.which;
      if (p === 120){
        $('#CetakStruk').click();
      }
      if (p === 121){
        $('#simpanTransaksi').click();
      }
      if (p == 118){
        tambahRowTransaksi();
      }
    });

  });
</script>

</html>
