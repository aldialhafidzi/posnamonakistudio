@extends('layouts.masterapp')
@section('content')

  <div class="margin-transaksi">
      <div class="panel panel-default">
          <div class="panel panel-default panel-body" style="min-height: 75vh;">
              <div class="row ">
                  <div class="col-sm-3">
                      <div class="row">
                          <div class="col-sm-12">
                              <div class="row" style="padding-left:10px; padding-right:10px;">
                                  <div align="right" class="col-sm-12" style="background-color : #d6e3ff; border-radius: 0px 10px 10px 10px; height:50px;">
                                      <h4 style="padding-top : 10px;"><i class="fas fa-money-bill-alt"></i> Pembelian</h4>
                                  </div>
                                  <div class="col-sm-12">
                                      <hr>
                                  </div>
                              </div>
                          </div>

                          <div class="col-sm-12 ukuran-box">
                              <div class="card border-info_tr mb-3">

                                  <div class="card-header bg_info_tr text-white">
                                      <i class="far fa-money-bill-alt"></i>&nbsp;&nbsp;Informasi Pembelian&nbsp;
                                  </div>

                                  <div class="form-horizontal font-informasi">
                                      <div class="form-group">
                                          <div class="row card-padding">
                                              <label class="col-sm-3 control-label ">No. Inv</label>
                                              <div class="col-sm-9">
                                                @if (!empty($carts_pem))
                                                  <input form="form_transaksi" type="text" name="nomor_nota" class="form-control  input-sm font-informasi" id="nomor_nota" value="{{ $carts_pem[0]->purchase->invoice }}">
                                                  <input type="hidden" name="purchase_id" id="purchase_id" form="form_transaksi" value="{{ $carts_pem[0]->purchase->id }}">
                                                @else
                                                  <input form="form_transaksi" type="text" name="nomor_nota" class="form-control input-sm font-informasi" id="nomor_nota" value="{{ $invoice }}">
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
                                                  <input type="hidden" form="form_transaksi" id="tanggal_pembelian" name="tanggal_pembelian" value="">
                                              </div>
                                          </div>

                                          <div class="row card-padding">
                                              <label class="col-sm-3 control-label">User</label>
                                              <div class="col-sm-9">
                                                  <select form="form_transaksi" name="id_kasir" id="id_kasir" class="form-control input-sm font-informasi">
                                                    @foreach ($users as $user)
                                                      @if (Auth::user()->id == $user->id)
                                                        <option selected value="{{ $user->id }}">{{ $user->name }}</option>
                                                      @else
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
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
                                      <i class="far fa-address-book"></i>&nbsp;&nbsp;Informasi Pemasok&nbsp;
                                  </div>

                                  <div class="form-horizontal font-informasi">
                                      <div class="form-group">

                                          <div class="row card-padding">
                                              <label class="col-sm-4 control-label ">Supplier</label>
                                              <div class="col-sm-8">
                                                  <a id="add_supplier_baru" name="add_supplier_baru" href="#" data-toggle="modal" data-target="#modal_supplier" data-backdrop="static" data-keyboard="false">Supplier Baru ?</a>
                                              </div>
                                          </div>

                                          <div class="row card-padding">
                                              <div class="col-sm-12" id="pilih_supplier">
                                                  <select onchange="change_supplier(this)" required form="form_transaksi" name="id_supplier" id="id_supplier" class="form-control input-sm font-informasi">
                                                    @foreach ($suppliers as $sup)
                                                      @if (!empty($carts_pem))
                                                        @if ($sup->id == $carts_pem[0]->purchase->supplier->id)
                                                          <option selected kontak="{{ $sup->no_telp }}" alamat="{{ $sup->alamat }}" value="{{ $sup->id }}">{{ $sup->nama }}</option>
                                                        @else
                                                          <option kontak="{{ $sup->no_telp }}" alamat="{{ $sup->alamat }}" value="{{ $sup->id }}">{{ $sup->nama }}</option>
                                                        @endif
                                                      @else
                                                        <option kontak="{{ $sup->no_telp }}" alamat="{{ $sup->alamat }}" value="{{ $sup->id }}">{{ $sup->nama }}</option>
                                                      @endif
                                                    @endforeach
                                                  </select>
                                              </div>
                                          </div>

                                          <div class="row card-padding">
                                              <label class="col-sm-3 control-label">Kontak</label>
                                              <div class="col-sm-9">
                                                @if (!empty($carts_pem))
                                                  <input form="form_transaksi" type="text" name="nomor_hp_supplier" class="form-control input-sm font-informasi" id="nomor_hp_supplier" value="{{ $carts_pem[0]->purchase->supplier->no_telp }}">
                                                @else
                                                  <input form="form_transaksi" type="text" name="nomor_hp_supplier" class="form-control input-sm font-informasi" id="nomor_hp_supplier" value="">
                                                @endif

                                              </div>
                                          </div>

                                          <div class="row card-padding">
                                              <label class="col-sm-3 control-label">Alamat</label>
                                              <div class="col-sm-9">
                                                @if (!empty($carts_pem))
                                                  <input form="form_transaksi" type="text" name="alamat_supplier" class="form-control input-sm font-informasi" id="alamat_supplier" value="{{ $carts_pem[0]->purchase->supplier->alamat }}">
                                                @else
                                                  <input form="form_transaksi" type="text" name="alamat_supplier" class="form-control input-sm font-informasi" id="alamat_supplier" value="">
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
                          <div align="left" style="padding-bottom: 10px;" class="col-sm-12 panel">
                              <div class="row">
                                  <div class="col-sm-12">
                                      <div class="btn-group " role="group" aria-label="Two group" style="padding:5px;">
                                          <button id="btn_new_product" type="submit" class="btn btn-sm btn-warning" name="btn_new_product" data-target="#modal_tambah_barang" data-backdrop="static" data-keyboard="false" onclick="tambahBarangForm()">
                                              <i class="fas fa-box"></i>&nbsp;&nbsp;Tambah Product&nbsp;
                                          </button>

                                          @if (!empty($carts_pem))
                                            <form class="" action="{{ route('batalkan.update.pembelian') }}" method="post">
                                              @csrf
                                              <button type="submit" class="btn btn-sm btn-danger" >
                                                  <i class="fas fa-times"></i>&nbsp;&nbsp;Batalkan&nbsp;
                                              </button>
                                            </form>
                                          @endif
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <div class="col-sm-12">
                            @if (Session::has('invoice'))
                              <a style="display : none;" class="link-download-excel" onclick="download_excel('{{ session('invoice') }}')" href="{{ session('invoice') }}" target="_blank">Link</a>
                            @endif

                            @if (!empty($carts_pem))
                              <form id="form_transaksi" method="post" action="{{ route('update.purchase.submit') }}">
                            @else
                              <form id="form_transaksi" method="post" action="{{ url('pembelian') }}">
                            @endif

                              {{ csrf_field() }}
                              <table class="table  table-bordered table-striped table-sm responsive-table-m ">
                                  <thead style="background-color : #f4f4f4; color : #000;">
                                      <tr>
                                          <th scope="col">&nbsp;#</th>
                                          <th scope="col">Kode Barang</th>
                                          <th scope="col">Nama Barang</th>
                                          <th scope="col">Unit</th>
                                          <th scope="col">Qty</th>
                                          <th scope="col">Harga</th>
                                          <th scope="col">Potongan</th>
                                          <th scope="col">Sub Total</th>
                                          <th scope="col"></th>
                                      </tr>
                                  </thead>

                                  <tbody id="tabel_pembelian">
                                    @if (!empty($carts_pem))
                                      @include('components.tr_pembelian')
                                    @else
                                      <tr>
                                          <td>
                                              <div style="width : 30px;" class="baris-tr" id="number_row" valign="center" align="center">1</div>
                                          </td>

                                          <td>
                                            <div class="ui-widget coeg p-field-kode">
                                                  <select required  style="width : 150px;" onchange="check_detail_barang_pembelian(this)" onclick="check_list_barang_pembelian(this)" placeholder="Kode / Nama Barang" class="form-control "  id="p_kode" name="p_kode[]">
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
                                              <label style="width : 100px;" scope="col" class="" id="p_harga_good_label"> </label>
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
                                              <button onclick="hapusRowPembelian(this)" class="btn btn-danger btn-sm" id="HapusBaris" style="color:#fff;">
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

                      <div class="row">
                          <div class="col-sm-12">
                              <div class="alert alert-tr" role="alert">
                                  <div class="row">
                                      <div class="col-sm-5" style="padding-top:10px; padding-bottom:10px; padding-left:10px;">
                                          <button onclick="tambahRowPembelian()" type="submit" class="btn btn-dark btn-sm" name="button">
                                              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Baris Baru (F7)&nbsp;
                                          </button>
                                      </div>
                                      <div class="col-sm-7">
                                        @if (!empty($carts_pem))
                                          <h2 class="text-right" id="grandtotal_label">Total : Rp. {{ number_format($carts_pem[0]->purchase->grandtotal,0,',','.') }},-</h2>
                                          <input form="form_transaksi" type="hidden" value="{{ $carts_pem[0]->purchase->grandtotal }}" name="grandtotal" id="grandtotal">
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
                                      <button type="submit" form="form_transaksi" class="btn btn-info btn-block" target="_blank" id="CetakStruk">
                                          <span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbsp;Cetak (F9)&nbsp;
                                          <input type="hidden" form="form_transaksi" name="cetak_invoice" id="cetak_invoice" value="">
                                      </button>
                                  </div>
                                  <div class="col-sm-7">
                                      <button type="submit" form="form_transaksi" class="btn btn-success btn-block" id="simpan_pembelian">
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

@include('components.modal_master')
@include('components.modal_supplier')
@include('components.modal_save_table')
@endsection
