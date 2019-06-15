<div class="modal fade bd-example-modal-lg" id="modal_konversi_unit">
    <div class="modal-dialog modal-lg-barang">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judul_modal_konversi_unit">Pengaturan Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="form_pengaturan_unit" class="needs-validation" novalidate>
                  @csrf {{ method_field('POST') }}
                    <div class="col-sm-12">
                        <table id="tabel_convert_unit" class="table table-striped table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="40%">Deskripsi</th>
                                    <th width="50%">Detail Units</th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>
                                        <div class="baris_RCU" align="center">1</div>
                                    </td>
                                    <td>
                                        <div class="row deskripsi-convert-unit" style="padding-left : 10px; padding-right : 10px;">
                                            <div id="convertKode" class="col-sm-6">
                                                <label for="kode">Kode Barang </label>
                                                <input type="hidden" name="cu_good_id[]" id="cu_good_id" value="">

                                                <select required  id="cu_kode" baris="0" form="form_pengaturan_unit" class="form-control-sm dc_kode" onclick="check_list_barang_all(this)" onchange="check_detail_barang_unit(this)" name="cu_kode[]">

                                                </select>
                                                <div id="dropdownSelectKode"></div>

                                            </div>

                                            <div class="col-sm-6">
                                                <label for="base_unit">Unit Awal </label>
                                                <select required form="form_pengaturan_unit" name="cu_unit_awal[]" id="cu_unit_awal" class="base_unit form-control  form-control-sm pake-list-unit">
                                                    @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}">{{ $unit->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-sm-12">
                                                <br>
                                                <label for="nama">Nama Barang </label>
                                                <input required autocomplete="off" disabled name="cu_nama[]" id="cu_nama" type="text" class="form-control form-control-sm" value="">
                                                <br>
                                            </div>
                                        </div>

                                    </td>
                                    <td>

                                        <div id="responseDetailUnits" class="detail-convert-unit">
                                            <table id="tabel_detail_convert_unit" class="table table-default table-sm" style="padding : 30px;">

                                                <tr style="background-color : #e3e3e3;">
                                                    <th width="20%">Unit</th>
                                                    <th width="15%">Qty</th>
                                                    <th width="50%">Keterangan</th>
                                                    <th align="center" width="5%"></th>
                                                </tr>

                                                <tbody id="tbody_detail_convert_unit">
                                                    <tr>
                                                        <td>
                                                            <div class="field-unit-convert-unit">
                                                                <select required baris="0" numa="" onchange="change_dcu_unit_id(this)" name="dcu_unit_id[0][]" id="dcu_unit_id" class="form-control d_unit_id pake-list-unit  form-control-sm" required>
                                                                    @foreach ($units as $unit)
                                                                    <option qty_unit_id="" value="{{ $unit->id }}">{{ $unit->nama }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input required autocomplete="off" type="text" pattern="[0-9.,]+" onchange="change_dcu_qty(this)" name="dcu_qty[0][]" class="form-control-sm form-control" id="dcu_qty" required>
                                                        </td>
                                                        <td>
                                                            <label id="dcu_keterangan" class="keterangan" name="dcu_keterangan[0][]"></label>
                                                        </td>
                                                        <td>
                                                            <div align="center">
                                                                <button onclick="hapusRowDetailUnit(this)" numa="" class="btn  btn-sm" name="HapusBaris_dc" id="HapusBaris_dc" style="color:#fff;">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>


                                                </tbody>
                                            </table>

                                            <div align="right">
                                                <button id="btn_tambah_row_detail_unit" name="btn_tambah_row_detail_unit" type="button" onclick="tambahRowDetailUnit(this)" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Tambah</button>
                                            </div>
                                        </div>

                                    </td>
                                    <td>
                                        <div align="center">

                                            <button type="button" onclick="hapusRowConvertUnit(this)" class="btn btn-danger btn-sm hapus-baris-convert-unit" name="btnHapusRowConvertUnit" id="btnHapusRowConvertUnit">
                                                <input type="hidden" name="" value="">
                                                <i class="fas fa-times"></i>
                                            </button>

                                        </div>

                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <br>
                      </form>
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="row">
                                    <div class="form-group mb-2">
                                        <button type="button" onclick="tambahRowConvertUnit()" class="btn btn-sm btn-info" name="btnTambahRowConvertUnit" id="btnTambahRowConvertUnit">
                                            <i class="fas fa-plus"></i> Baris Baru
                                        </button>
                                        <button type="button" form="form_tambah_unit" class="btn btn-sm btn-warning" name="btn-new-unit" id="btn-new-unit">
                                            <i class="fas fa-plus"></i> Unit Baru
                                        </button>
                                    </div>
                                    <div style="display : none;" id="div_unit_baru" class="form-group form-group-sm mx-sm-3 mb-2">
                                      <form class="needs-validation" novalidate id="form_tambah_unit">
                                        @csrf {{ method_field("POST") }}
                                        <div class="input-group mb-3">
                                          <input required form="form_tambah_unit" type="text" class="form-control form-control-sm " name="input_unit" id="input_unit" placeholder="Nama unit baru" aria-label="Nama unit baru" aria-describedby="basic-addon2">

                                          <div class="input-group-append">
                                            <button class="btn btn-sm btn-outline-success submit-unit-baru"  type="submit">Submit</button>
                                          </div>
                                          <div class="invalid-feedback">
                                            Harus diisi.
                                          </div>
                                        </div>
                                      </form>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn  btn-secondary" data-dismiss="modal">
                    Tutup
                </button>
                <button type="submit" autocomplete="off" form="form_pengaturan_unit" class="btn  btn-primary" name="btnSubmitConvertUnit" id="btnSubmitConvertUnit">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>
