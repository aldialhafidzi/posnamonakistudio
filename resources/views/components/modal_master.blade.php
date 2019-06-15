<div class="modal fade bd-example-modal-lg" id="modal_tambah_barang">
    <div class="modal-dialog modal-lg-barang">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judul_modal_tambah_barang">Tambah Data Barang</h5>
                <button type="button" class="close close-modal-barang" data-toggle="modal" data-target="#modal_save_table" data-backdrop="static" data-keyboard="false"   aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_tambah_barang" class="needs-validation" novalidate>
                    @csrf {{ method_field("POST") }}
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="tabel_tambah_barang" class="table table-bordered table-striped responsive-table-m table-sm">
                              <thead>
                                <tr style="background-color : #555555; color : #fff;">
                                  <th style="width : 40px;" align="center" scope="col">No</th>
                                  <th style="width : 300px;" scope="col">Deskripsi</th>
                                  <th style="width : 300px;" scope="col">Detail</th>
                                  <th style="width : 30px;" scope="col"></th>
                                </tr>
                              </thead>

                                <tbody>

                                  @if (!empty($cooc_barang) != "")
                                    @include('components.tr_barang')
                                  @else
                                    <tr>
                                      <td align="center" class="number_rowBar">1</td>
                                      <td>
                                          <div class="deskripsi-form-tambah-barang">
                                              <div class="row">
                                                  <div class="col-sm-4 pad_table_barang">
                                                      <label for="g_kode">Kode</label>
                                                      <input required autocomplete="off" form="form_tambah_barang" type="text" name="g_kode[]" onchange="check_kode(this)" class="auto-save form-control-sm form-control" id="g_kode">
                                                      <div id="g_kode_error" class="invalid-feedback">
                                                        Harus diisi.
                                                      </div>
                                                  </div>

                                                  <div class="col-sm-8 pad_table_barang">
                                                      <label for="g_nama">Nama</label>
                                                      <input required autocomplete="off" form="form_tambah_barang" type="text" name="g_nama[]" class="auto-save form-control-sm form-control" id="g_nama">
                                                      <div class="invalid-feedback">
                                                        Harus diisi.
                                                      </div>
                                                  </div>
                                              </div>

                                              <br>

                                              <div class="row">
                                                  <div class="col-sm-4 pad_table_barang">
                                                      <label for="g_kategori">Kategori</label>
                                                      <select form="form_tambah_barang" name="g_kategori[]" id="g_kategori" class="auto-save form-control  form-control-sm">
                                                          {{-- <option value="">Pilih Kategori</option> --}}
                                                          @foreach ($categories as $cat)
                                                          <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>
                                                  <div class="col-sm-8 pad_table_barang">
                                                      <label for="g_merek">Merek</label>
                                                      <select form="form_tambah_barang" name="g_merek[]" id="g_merek" class="auto-save form-control  form-control-sm">
                                                          {{-- <option value="">Pilih Merek</option> --}}
                                                          @foreach ($brands as $br)
                                                          <option value="{{ $br->id }}">{{ $br->nama }}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>
                                              </div>
                                              <br>
                                              <div class="row">
                                                  <div class="col-sm-12 pad_table_barang">
                                                      <label for="g_h_jual">Harga Jual</label>
                                                      <div class="input-group input-group-sm mb-12">
                                                          <div class="input-group-prepend">
                                                              <span class="input-group-text">Rp.</span>
                                                          </div>
                                                          <input required autocomplete="off" form="form_tambah_barang" type="number" class="auto-save form-control form-control-sm" id="g_h_jual" name="g_h_jual[]" aria-label="Small">
                                                          <div class="invalid-feedback">
                                                            Harus diisi.
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </td>

                                      <td>
                                          <div class="detail-form-tambah-barang">
                                              <div class="row">
                                                  <div class="col-sm-6 pad_table_barang">
                                                      <label for="g_unit_beli">Unit Beli</label>
                                                      <select form="form_tambah_barang" name="g_unit_beli[]" id="g_unit_beli" class="auto-save form-control  form-control-sm">
                                                          @foreach ($units as $unit)
                                                          <option value="{{ $unit->id }}">{{ $unit->nama }}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>

                                                  <div class="col-sm-6 pad_table_barang">
                                                      <label for="g_h_beli">Harga Beli</label>
                                                      <div class="input-group input-group-sm mb-12">
                                                          <div class="input-group-prepend">
                                                              <span class="input-group-text">Rp.</span>
                                                          </div>
                                                          <input required autocomplete="off" form="form_tambah_barang" type="number" class="auto-save form-control form-control-sm" id="g_h_beli" name="g_h_beli[]" aria-label="Small">
                                                          <div class="invalid-feedback">
                                                            Harus diisi.
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>

                                              <br>
                                              <div class="row">
                                                  <div class="col-sm-4 pad_table_barang">
                                                      <label for="g_unit_awal">Unit Awal</label>
                                                      <select form="form_tambah_barang" name="g_unit_awal[]" id="g_unit_awal" class="auto-save form-control  form-control-sm">
                                                          @foreach ($units as $unit)
                                                          <option value="{{ $unit->id }}">{{ $unit->nama }}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>
                                                  <div class="col-sm-4 pad_table_barang">
                                                      <label for="g_stok_unit">Stok / Unit Awal</label>
                                                      <input required autocomplete="off" form="form_tambah_barang" type="number" class="auto-save form-control form-control-sm" id="g_stok_unit" name="g_stok_unit[]">
                                                      <div class="invalid-feedback">
                                                        Harus diisi.
                                                      </div>
                                                  </div>
                                                  <div class="col-sm-4 pad_table_barang">
                                                      <label for="g_min_qty">Minimal Stok</label>
                                                      <input required autocomplete="off" form="form_tambah_barang" type="number" class="auto-save form-control form-control-sm" id="g_min_qty" name="g_min_qty[]">
                                                      <div class="invalid-feedback">
                                                        Harus diisi.
                                                      </div>
                                                  </div>
                                              </div>

                                              <br>

                                              <div class="row">
                                                  <div class="col-sm-6 pad_table_barang">
                                                      <label for="g_unit_jual">Unit Jual</label>
                                                      <select form="form_tambah_barang" name="g_unit_jual[]" id="g_unit_jual" class="auto-save form-control  form-control-sm">
                                                          @foreach ($units as $unit)
                                                          <option value="{{ $unit->id }}">{{ $unit->nama }}</option>
                                                          @endforeach
                                                      </select>

                                                  </div>

                                                  <div class="col-sm-6 pad_table_barang">
                                                      <label for="g_du_qty"> Kuantitas / Sale Unit</label>
                                                      <div class="input-group input-group-sm mb-12">
                                                        <input required autocomplete="off" form="form_tambah_barang" type="number" class="auto-save form-control form-control-sm" id="g_du_qty" name="g_du_qty[]" aria-label="Small">
                                                        <div class="invalid-feedback">
                                                        Harus diisi.
                                                      </div>
                                                      </div>
                                                  </div>
                                              </div>

                                              <br>
                                          </div>
                                      </td>

                                      <td>
                                          <button onclick="hapusRowBarang(this)" class="btn btn-danger btn-sm hapus-baris-barang" id="HapusBaris" style="color:#fff;">
                                              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                          </button>
                                      </td>
                                    </tr>
                                  @endif




                                </tbody>
                            </table>

                        </div>

                    </div>
                    <a href="#" name="btn_newline_barang" id="btn_newline_barang" onclick="tambahRowBarang()" role="button" class="btn btn-dark btn-sm popover-test"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Baris
                        Baru&nbsp</a>
                    <input autocomplete="off" form="form_tambah_barang" type="hidden" name="good_id" id="good_id">


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <input autocomplete="off" type="submit" class="btn btn-primary" name="insert_data_barang" id="insert_data_barang" value="Insert Data" form="form_tambah_barang">
            </div>
        </div>
        </form>
    </div>
</div>
