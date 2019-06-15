<div class="modal fade" id="modal_tambah_combo">
    <div class="modal-dialog modal-lg-barang">
        <div class="modal-content">
            <div class="modal-header">
                <h5> <i class="fas fa-box"></i> &nbsp; <label id="judul_modal_tambah_combo">Buat Paket Combo</label></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_tambah_combo" class="needs-validation" novalidate>
                    @csrf {{ method_field("POST") }}
                    <table id="tabel_tambah_combo" class="table table-striped table-bordered responsive-table-m table-sm">
                        <thead>
                            <tr style="background-color : #555555; color : #fff;">
                                <th style="width : 40px;" align="center" scope="col">No</th>
                                <th style="width : 200px;" scope="col">Deskripsi</th>
                                <th style="width : 300px;" scope="col">Detail</th>
                                <th style="width : 30px;" scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div id="number_cbo" class="baris-combo" align="center">1</div>
                                    <input autocomplete="off" autocomplete="off" form="form_tambah_combo" type="hidden" id="combo_id" name="combo_id" value="">
                                </td>

                                <td>
                                    <div class="deskripsi-form-tambah-combo">
                                        <div class="row">
                                            <div class="col-sm-4 pad_table_barang">
                                                <label for="c_kode">Kode</label>
                                                <input autocomplete="off" form="form_tambah_combo" type="text" name="c_kode[]" onchange="check_kode_combo(this)" class="form-control-sm form-control" id="c_kode" required>
                                                <div id="g_kode_error" class="invalid-feedback">
                                                    Harus diisi.
                                                </div>
                                            </div>

                                            <div class="col-sm-8 pad_table_barang">
                                                <label for="c_nama">Nama</label>
                                                <input autocomplete="off" form="form_tambah_combo" type="text" name="c_nama[]" class="form-control-sm form-control" id="c_nama" required>
                                                <div class="invalid-feedback">
                                                    Harus diisi.
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-6 pad_table_barang">
                                                <label for="c_min_qty">Minimal Stok</label>
                                                <input autocomplete="off" form="form_tambah_combo" type="number" class="form-control form-control-sm" id="c_min_qty" name="c_min_qty[]" required>
                                                <div class="invalid-feedback">
                                                    Harus diisi.
                                                </div>
                                            </div>

                                            <div class="col-sm-6 pad_table_barang">
                                                <label for="c_unit_jual">Sale Unit</label>
                                                <select form="form_tambah_combo" name="c_unit_jual[]" id="c_unit_jual" class="form-control  form-control-sm" required>
                                                    @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}">{{ $unit->nama }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Harus diisi.
                                                </div>
                                            </div>
                                        </div>

                                        <br>
                                        <div class="row">
                                            <div class="col-sm-12 pad_table_barang">
                                                <label for="c_h_jual">Harga Jual</label>
                                                <div class="input-group input-group-sm mb-12">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp.</span>
                                                    </div>
                                                    <input autocomplete="off" form="form_tambah_combo" type="number" class="form-control form-control-sm" id="c_h_jual" name="c_h_jual[]" aria-label="Small" required>
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
                                    <div class="detail-form-tambah-combo">
                                        <div class="row pad_table_barang">
                                            <table id="table_detail_combo" class="table table-default table-sm" style="padding : 30px;">

                                                <thead>
                                                  <tr style="background-color : #e3e3e3;">
                                                      <th style="width : 30px;">Kode</th>
                                                      <th style="width : 100px;">Nama</th>
                                                      <th style="width : 60px;">Unit</th>
                                                      <th style="width : 20px;">Qty</th>
                                                      <th align="center" style="width : 20px;"></th>
                                                  </tr>
                                                </thead>

                                                <tbody id="tbody_detail_combo">
                                                    <tr>
                                                        <td>
                                                            <div class="field-kode">
                                                                <select form="form_tambah_combo" id="dc_kode" baris="0" form="form_tambah_combo" class="form-control-sm dc_kode" onclick="check_list_barang(this)" onchange="check_detail_barang(this)"
                                                                  name="dc_kode[0][]">

                                                                </select>
                                                                <div id="dropdownSelectKode"></div>
                                                                <div class="invalid-feedback">
                                                                    Harus diisi.
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="field-nama keterangan">
                                                                <label id="dc_nama" name="dc_nama[0][]"></label>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="field-unit">
                                                                <select form="form_tambah_combo" numa="" name="dc_unit[0][]" id="dc_unit" class="form-control change_unit  form-control-sm" required>

                                                                </select>
                                                                <div class="invalid-feedback">
                                                                    Harus diisi.
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="field-qty">
                                                                <input form="form_tambah_combo" autocomplete="off" type="number" name="dc_qty[0][]" class="form-control-sm form-control dc_qty" id="dc_qty" required>
                                                                <div class="invalid-feedback">
                                                                    Harus diisi.
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div align="center">
                                                                <button onclick="hapusRowDetailCombo(this)" numa="" class="btn  btn-sm" name="HapusBaris_dc" id="HapusBaris_dc" style="color:#fff;">
                                                                    <i class="fas fa-times"></i>
                                                                    <input form="form_tambah_combo" type="hidden" name="dc_good_id[0][]" id="dc_good_id" value="">
                                                                </button>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>


                                        <br>
                                        <div class="col-sm-12 pad_table_barang" align="right">
                                            <button id="btnTambah_DC" onclick="tambahRowDetailCombo(this)" numa="" type="button" class="btn btn-sm btn-success" name="btnTambah_DC">
                                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Tambah&nbsp;
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div align="center">
                                        <button onclick="hapusRowCombo(this)" class="btn btn-danger btn-sm hapus-baris-combo" id="HapusBaris" style="color:#fff;">
                                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>

                                        </button>

                                    </div>
                                </td>
                            </tr>
                </form>
                </tbody>
                </table>
                <br>
                <a href="#" name="btn_newline_combo" id="btn_newline_combo" onclick="tambahRowCombo()" role="button" class="btn btn-dark btn-sm popover-test"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Baris baru&nbsp</a>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <input autocomplete="off" type="submit" form="form_tambah_combo" class="btn btn-primary" name="btn_insert_combo" id="btn_insert_combo" value="Tambah Combo"></input>
                </div>
            </div>

        </div>

    </div>
</div>
