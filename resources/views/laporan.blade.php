@extends('layouts.masterapp')
@section('content')

  @if (Session::has('laporan_barang'))
    <a style="display : none;" class="link-download-excel" onclick="download_excel('{{ session('laporan_barang') }}')" href="{{ session('laporan_barang') }}" target="_blank">Link</a>
  @endif
<div class="container-fluid margin-transaksi" style="min-height : 480px;">
    <div class="panel panel-default panel-body">
        <div class="12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">
                            <i class="fas fa-clipboard-list"></i>&nbsp;&nbsp;Laporan&nbsp;</a></li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card  mb-3">
                            <div class="card-header text-white bg_info_tr"><i class="fas fa-shopping-cart"></i> &nbsp;Transaksi</div>
                            <div class="card-body">
                                <form id="cetak_laporan_transaksi" action="{{ route('penjualan.export') }}" method="post">
                                  {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="">Print :</label>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-check">
                                                        <input required class="form-check-input" type="radio" name="printSales" id="headerSales" value="headerSales" checked>
                                                        <label class="form-check-label" for="headerSales">
                                                            Header Sales
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-check">
                                                        <input required class="form-check-input" type="radio" name="printSales" id="detailSales" value="detailSales">
                                                        <label class="form-check-label" for="detailSales">
                                                            Detail Sales
                                                        </label>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <select required id="choose_cust" name="choose_cust[]" class="form-control" multiple="multiple" style="width: 100%;">
                                                      @foreach ($customers as $cust)
                                                        <option value="{{$cust->id }}">{{ $cust->nama }}</option>
                                                      @endforeach
                                                    </select>
                                                    <input type="checkbox" name="selectAllCust" id="selectAllCust" value="allCust">
                                                    <label class="form-check-label" for="selectAllCust">
                                                        Select All Customer
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <br>
                                        </div>

                                        <div class="col-sm-6">
                                            <label for="">Dari :</label>
                                            <input required autocomplete="off" name="date_dari" id="date_dari" class="form-control" size="16" type="text" value="">
                                        </div>

                                        <div class="col-sm-6">
                                            <label for="">Sampai :</label>
                                            <input required autocomplete="off" id="date_sampai" name="date_sampai" class="form-control" size="16" type="text" value="">
                                        </div>

                                    </div>
                                    <br>

                                    <div class="" align="right">
                                        <button id="export_pdf_tr" name="export_pdf_tr" type="submit" class="btn btn-danger" name="button"><i class="fas fa-file-pdf"></i>&nbsp; &nbsp;PDF</button>
                                        <button id="export_excel_tr" name="export_excel_tr" type="submit" class="btn btn-success" name="button"><i class="fas fa-file-excel"></i>&nbsp; &nbsp;Excel</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                    <!-- PEMBELIAN -->
                    <div class="col-sm-6">
                        <div class="card  mb-3">
                            <div class="card-header text-white bg_info_tr"><i class="fas fa-shopping-cart"></i> &nbsp;Pembelian</div>
                            <div class="card-body">
                                <form id="cetak_laporan_pembelian" action="{{ route('pembelian.export') }}" method="post">
                                  {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="">Print :</label>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-check">
                                                        <input required class="form-check-input" type="radio" name="printPurchases" id="headerPurchases" value="headerPurchases" checked>
                                                        <label class="form-check-label" for="headerPurchases">
                                                            Header Purchases
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-check">
                                                        <input required class="form-check-input" type="radio" name="printPurchases" id="detailPurchases" value="detailPurchases">
                                                        <label class="form-check-label" for="detailPurchases">
                                                            Detail Purchases
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <select id="choose_supp" name="choose_supp[]" class="form-control" multiple="multiple" style="width: 100%;">
                                                      @foreach ($suppliers as $sup)
                                                        <option value="{{$sup->id }}">{{ $sup->nama }}</option>
                                                      @endforeach
                                                    </select>
                                                    <input type="checkbox" name="selectAllSupplier" id="selectAllSupplier" value="allSupplier">
                                                    <label class="form-check-label" for="selectAllSupplier">
                                                        Select All Supplier
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <br>
                                        </div>

                                        <div class="col-sm-6">
                                            <label for="">Dari :</label>
                                            <input required autocomplete="off" name="date_dari_purchases" id="date_dari_purchases" class="form-control" size="16" type="text" value="">
                                        </div>

                                        <div class="col-sm-6">
                                            <label for="">Sampai :</label>
                                            <input required autocomplete="off" id="date_sampai_purchases" name="date_sampai_purchases" class="form-control" size="16" type="text" value="">
                                        </div>

                                    </div>
                                    <br>

                                    <div class="" align="right">
                                        <button id="export_pdf_purchases" name="export_pdf_purchases" type="submit" class="btn btn-danger" name="button"><i class="fas fa-file-pdf"></i>&nbsp; &nbsp;PDF</button>
                                        <button id="export_excel_purchases" name="export_excel_purchases" type="submit" class="btn btn-success" name="button"><i class="fas fa-file-excel"></i>&nbsp; &nbsp;Excel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="row">
                  {{-- Laporan Barang --}}
                  <div class="col-sm-6">
                      <div class="card  mb-3">
                          <div class="card-header text-white bg_info_tr"><i class="fas fa-shopping-cart"></i> &nbsp;Barang</div>
                          <div class="card-body">
                              <form id="cetak_laporan_good" action="{{ route('good.export') }}" method="post">
                                {{ csrf_field() }}
                                  <div class="row">
                                      <div class="col-sm-6">
                                          <label for="">Print :</label>
                                          <hr>
                                          <div class="row">
                                              <div class="col-sm-6">
                                                  <div class="form-check">
                                                      <input required class="form-check-input" type="radio" name="printGood" id="headerGood" value="headerGood" checked>
                                                      <label class="form-check-label" for="headerGood">
                                                          SM Report
                                                      </label>
                                                  </div>
                                              </div>
                                              <div class="col-sm-6">
                                                  <div class="form-check">
                                                      <input required class="form-check-input" type="radio" name="printGood" id="detailGood" value="detailGood">
                                                      <label class="form-check-label" for="detailGood">
                                                          SM Report Detail
                                                      </label>
                                                  </div>
                                              </div>
                                              <div class="col-sm-12">
                                                  <div class="form-check">
                                                      <input required class="form-check-input" type="radio" name="printGood" id="stokPertanggal" value="stokPertanggal">
                                                      <label class="form-check-label" for="stokPertanggal">
                                                          Stock Report
                                                      </label>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>

                                      <div class="col-sm-6">
                                          <div class="row">
                                              <div class="col-sm-12">
                                                  <select id="choose_good" name="choose_good[]" class="form-control" multiple="multiple" style="width: 100%;" required>
                                                    @foreach ($goods as $good)
                                                      <option value="{{$good->id }}">{{ $good->nama }}</option>
                                                    @endforeach
                                                  </select>
                                                  <input type="checkbox" name="selectAllGood" id="selectAllGood" value="allGood">
                                                  <label class="form-check-label" for="selectAllGood">
                                                      Select All Good
                                                  </label>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-sm-12">
                                          <br>
                                      </div>
                                      <div class="col-sm-12">
                                        <div class="row" id="tanggal_monitoring">
                                          <div class="col-sm-6">
                                            <label id="label_barang_dari" for="">Dari:</label>
                                            <input required autocomplete="off" name="date_dari_barang" id="date_dari_barang" class="form-control" size="16" type="text" value="">
                                          </div>
                                          <div class="col-sm-6">
                                            <label for="">Sampai:</label>
                                            <input required autocomplete="off" id="date_sampai_barang" name="date_sampai_barang" class="form-control" size="16" type="text" value="">
                                          </div>
                                        </div>
                                      </div>

                                  </div>
                                  <br>

                                  <div class="" align="right">
                                      <button id="export_pdf_good" name="export_pdf_good" value="PDF" type="submit" class="btn btn-danger"><i class="fas fa-file-pdf"></i>&nbsp; &nbsp;PDF</button>
                                      <button id="export_excel_good" name="export_excel_good" value="EXCEL" type="submit" class="btn btn-success" name="button"><i class="fas fa-file-excel"></i>&nbsp; &nbsp;Excel</button>
                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('components.modal_kategori')
@include('components.modal_hapus_data')
@endsection
