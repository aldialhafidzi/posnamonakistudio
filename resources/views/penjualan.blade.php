@extends('layouts.masterapp')
@section('content')

<div class="margin-transaksi" style="min-height : 400px;">
    <div class="panel panel-default">
        <div class="panel panel-default panel-body">
            <div class="row ">
                <div class="col-sm-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row" style="padding-left:10px; padding-right:10px;">
                                <div align="right" class="col-sm-12" style="background-color : #e7e7e7; border-radius: 0px 10px 10px 10px; height:50px;">
                                    <h4 style="padding-top : 10px;"><i class="fas fa-shopping-cart"></i> Penjualan</h4>
                                </div>
                                <div class="col-sm-12">
                                    <hr>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 ukuran-box">
                            <div class="card border-info_tr mb-3">
                                <div class="card-header bg_info_tr text-white">
                                    <i class="far fa-file-alt"></i>&nbsp;&nbsp;Informasi Nota&nbsp;
                                </div>

                                <div class="form-horizontal font-informasi">

                                    <div class="form-group">

                                        <div class="row card-padding">
                                            <label class="col-sm-3 control-label ">Invoice</label>
                                            <div class="col-sm-9">
                                              @if (!empty($carts))
                                                <input  form="form_transaksi" type="text" name="nomor_nota" class="form-control  input-sm font-informasi" id="nomor_nota" value="{{ $carts[0]->sale->invoice }}">
                                                <input type="hidden" name="sale_id" id="sale_id" form="form_transaksi" value="{{ $carts[0]->sale->id }}">
                                              @else
                                                <input  form="form_transaksi" type="text" name="nomor_nota" class="form-control  input-sm font-informasi" id="nomor_nota" value="{{ $invoice }}">
                                              @endif
                                            </div>
                                        </div>

                                        <div class="row card-padding  date">
                                            <label class="col-sm-3 control-label">Tanggal</label>
                                            <div class="col-sm-9">
                                                <div class="form-group">
                                                    <div class="input-group date" data-target-input="nearest">
                                                        <input form="form_transaksi" id="datetimepicker" type="text" class="font-informasi form-control datetimepicker-input" data-target="#datetimepicker" />
                                                        <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="glyphicon glyphicon-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" form="form_transaksi" id="tanggal_transaksi" name="tanggal_transaksi" value="">
                                                <input type="hidden" form="form_transaksi" id="tanggal_waktu" name="tanggal_waktu" value="">
                                            </div>
                                        </div>

                                        <div class="row card-padding">
                                            <label class="col-sm-3 control-label">Kasir</label>
                                            <div class="col-sm-9">
                                                <select required onchange="logout()" form="form_transaksi" name="id_kasir" id="id_kasir" class="form-control  input-sm font-informasi">
                                                    @foreach ($kasir as $ksr)
                                                      @if (Auth::user()->id == $ksr->id)
                                                        <option selected value="{{ $ksr->id }}">{{ $ksr->name }}</option>
                                                      @else
                                                        <option value="{{ $ksr->id }}">{{ $ksr->name }}</option>
                                                      @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 ukuran-box">
                            <div class="card border-info_tr mb-3">
                                <div class="card-header bg_info_tr text-white">
                                    <i class="far fa-address-book"></i>&nbsp;&nbsp;Informasi Pelanggan&nbsp;
                                </div>

                                <div class="form-horizontal font-informasi">
                                    <div class="form-group">
                                        <div class="row card-padding">
                                            <label class="col-sm-4 control-label ">Pelanggan</label>
                                            <div class="col-sm-8">
                                                <a id="add_pelanggan_baru" name="add_pelanggan_baru" href="#" data-toggle="modal" data-target="#modal_pelanggan" data-backdrop="static" data-keyboard="false" >Pelanggan Baru ?</a>
                                            </div>
                                        </div>

                                        <div class="row card-padding">
                                            <div class="col-sm-12" id="pilih_pelanggan">
                                                <select required onchange="check_detail_customer(this)" onclick="check_list_customer(this)"  form="form_transaksi" name="id_customer" id="id_customer" class="form-control  input-sm font-informasi">
                                                    <option value="">Pilih Pelanggan</option>
                                                    @if (!empty($carts))
                                                      <option selected value="{{ $carts[0]->sale->customer->id }}">{{ $carts[0]->sale->customer->nama }}</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row card-padding">
                                            <label class="col-sm-3 control-label">Kontak</label>
                                            <div class="col-sm-9">
                                              @if (!empty($carts))
                                                <input  form="form_transaksi" type="text" name="nomor_hp" class="form-control  input-sm font-informasi" id="nomor_hp" value="{{ $carts[0]->sale->customer->no_telp }}">
                                              @else
                                                <input  form="form_transaksi" type="text" name="nomor_hp" class="form-control  input-sm font-informasi" id="nomor_hp" value="">
                                              @endif
                                            </div>
                                        </div>

                                        <div class="row card-padding">
                                            <label class="col-sm-3 control-label">Alamat</label>
                                            <div class="col-sm-9">
                                              @if (!empty($carts))
                                                <input  form="form_transaksi" type="text" name="alamat_cust" class="form-control  input-sm font-informasi" id="alamat_cust" value="{{ $carts[0]->sale->customer->alamat }}">
                                              @else
                                                <input  form="form_transaksi" type="text" name="alamat_cust" class="form-control  input-sm font-informasi" id="alamat_cust" value="">
                                              @endif
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9">

                    <div class="row">

                      @if (!empty($carts))
                        <div align="left" style="padding-bottom: 10px;" class="col-sm-12 panel">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="btn-group " role="group" aria-label="Two group" style="padding:5px;">

                                      <form id="form_batal_update_penjualan" action="{{ route('batalkan.update.penjualan') }}" method="post">
                                        @csrf
                                        <button type="submit" form="form_batal_update_penjualan" class="btn btn-sm btn-danger">
                                          <i class="fas fa-times"></i>&nbsp;&nbsp;Batalkan&nbsp;
                                        </button>
                                      </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                      @endif

                        <div class="col-sm-12">
                          @if (Session::has('invoice'))
                            <a style="display : none;" class="link-download-excel" onclick="download_excel('{{ session('invoice') }}')" href="{{ session('invoice') }}" target="_blank">Link</a>
                          @endif
                        </div>

                        <div class="col-sm-12">

                          @if (!empty($carts))
                            <form id="form_transaksi" method="post" action="{{ route('update.sale.submit') }}">
                          @else
                            <form id="form_transaksi" method="post" action="{{ url('penjualan') }}">
                          @endif

                            @csrf
                            <table class="table  table-bordered table-striped table-sm responsive-table-m ">
                                <thead style="background-color : #343a40; color : #fff;">
                                    <tr>
                                        <th scope="col">&nbsp;#</th>
                                        <th scope="col">Kode Barang</th>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Potongan (Rp)</th>
                                        <th scope="col">Sub Total</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>

                                <tbody id="tabel_transaksi">
                                  @if (!empty($carts))
                                    @include('components.tr_transaksi')
                                  @else
                                    <tr>
                                        <td>
                                            <div style="width : 30px;" class="baris-tr" valign="center" align="center">1</div>
                                        </td>

                                        <td>
                                            <div class="ui-widget coeg p-field-kode">
                                                  <select required  style="width : 120px;" onchange="check_detail_barang_penjualan(this)" onclick="check_list_barang_penjualan(this)" placeholder="Kode / Nama Barang" class="form-control "  id="p_kode" name="p_kode[]">
                                                  </select>
                                                <input required  class="" type="hidden" name="p_good_id[]" id="p_good_id" value="">
                                            </div>
                                        </td>

                                        <td>
                                          <div class="p-field-nama">
                                            <label class="" style="width : 150px;" scope="col" id="p_nama_good"></label>
                                          </div>
                                        </td>

                                        <td>
                                          <div class="p-field-unit">
                                            <select onchange="hitung_total()" required   numa="1" name="p_unit_good[]" id="p_unit_good" class="form-control   change_unit_tr" ="">
                                            </select>
                                            <input type="hidden" name="p_qty_unit[]" id="p_qty_unit" value="">
                                          </div>
                                        </td>

                                        <td>
                                            <div class="p-field-qty">
                                              <input onchange="hitung_total()" required  style="width:60px;" scope="col"  type="number" numa="1" class="form-control  qty_1 edit_qty_tr" id="p_qty_good" name="p_qty_good[]" style="width:60px;">
                                            </div>
                                        </td>

                                        <td>
                                          <div class="p-field-harga">
                                            <label style="width : 120px;" scope="col" class="" id="p_harga_good_label"> </label>
                                            <input class="" type="hidden" name="p_harga_good[]" id="p_harga_good" value="">
                                          </div>
                                        </td>

                                        <td>
                                          <div class="p-field-potongan">
                                            <input onchange="hitung_total()" type="number"  class=" form-control edit_potongan_tr potongan" id="p_potongan" name="p_potongan[]" style="width:100px;" value="">
                                          </div>
                                        </td>

                                        <td>
                                          <div class="p-field-subtotal">
                                            <label style="width : 120px;" scope="col" class="" id="p_subtotal_label"> </label>
                                            <input type="hidden" class="subtotal" class="" name="p_subtotal[]" id="p_subtotal" value="">
                                          </div>
                                        </td>

                                        <td>
                                            <button onclick="hapusRowTransaksi(this)" class="btn btn-danger btn-sm" id="HapusBaris" style="color:#fff;">
                                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                            </button>
                                        </td>

                                    </tr>
                                  @endif



                                </tbody>
                            </table>
                          </form>
                        </div>
                    </div>

                    <!-- AKHIR TABEL -->

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="alert alert-tr" role="alert">
                                <div class="row">
                                    <div class="col-sm-5" style="padding-top:10px; padding-bottom:10px; padding-left:10px;">
                                        <button onclick="tambahRowTransaksi()" type="submit" class="btn btn-dark btn-sm" name="button">
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Baris Baru (F7)&nbsp;
                                        </button>
                                    </div>

                                    <div class="col-sm-7">
                                        @if (!empty($carts))
                                          <h2 class="text-right" id="grandtotal_label">Total : Rp. {{ number_format($carts[0]->sale->grandtotal,0,',','.') }},-</h2>
                                          <input form="form_transaksi" type="hidden" value="{{ $carts[0]->sale->grandtotal }}" name="grandtotal" id="grandtotal">
                                        @else
                                          <h2 class="text-right" id="grandtotal_label">Total : Rp. 0,-</h2>
                                          <input form="form_transaksi" type="hidden" name="grandtotal" id="grandtotal">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-7">
                            <textarea form="form_transaksi" name="catatan" id="catatan" class="form-control" placeholder="Catatan Transaksi (Jika Ada)" style="resize: vertical; width:100%;"></textarea>
                            <br>
                            <div align="left" style="color : #989898; font-size : 10pt;" class="row">
                                <div class="col-sm-12">
                                    <label>Keterangan :</label>
                                </div>
                                <div class="col-sm-12">
                                    <label>F7 (Menambahkan baris transaksi baru)</label>
                                </div>
                                <div class="col-sm-12">
                                    <label>F9 (Mencetak hasil transaksi)</label>
                                </div>
                                <div class="col-sm-12">
                                    <label>F10 (Menyimpan hasil transaksi ke database)</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <br>
                            <div class="row">
                                <div class="col-sm-5">
                                    <button type="submit" form="form_transaksi" class="btn btn-warning btn-block" id="CetakStruk" name="CetakStruk" value="200">
                                        <span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbsp;Cetak (F9)&nbsp;
                                        <input type="hidden" form="form_transaksi" name="cetak_invoice" id="cetak_invoice" value="">
                                    </button>
                                </div>
                                <div class="col-sm-7">
                                    <button type="submit" form="form_transaksi" class="btn btn-success btn-block" id="simpanTransaksi" name="simpanTransaksi">
                                        <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>&nbsp;Simpan (F10)&nbsp;
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('components.modal_pelanggan')
@endsection
