@for ($i=0; $i < count($cooc_barang->g_kode); $i++)
  @php
    $x = $i + 1;
  @endphp
  <tr>
    <td align="center" class="number_rowBar">{{ $x }}</td>
    <td>
        <div class="deskripsi-form-tambah-barang">
            <div class="row">
                <div class="col-sm-4 pad_table_barang">
                    <label for="g_kode">Kode</label>
                    <input value="{{ $cooc_barang->g_kode[$i] }}" required autocomplete="off" form="form_tambah_barang" type="text" name="g_kode[]" onchange="check_kode(this)" class="auto-save form-control-sm form-control" id="g_kode">
                    <div id="g_kode_error" class="invalid-feedback">
                      Harus diisi.
                    </div>
                </div>

                <div class="col-sm-8 pad_table_barang">
                    <label for="g_nama">Nama</label>
                    <input value="{{ $cooc_barang->g_nama[$i] }}" required autocomplete="off" form="form_tambah_barang" type="text" name="g_nama[]" class="auto-save form-control-sm form-control" id="g_nama">
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
                        @foreach ($categories as $cat)
                          @if ($cat->id ==  $cooc_barang->g_kategori[$i])
                            <option value="{{ $cat->id }}" selected>{{ $cat->nama }}</option>
                          @else
                            <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                          @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-8 pad_table_barang">
                    <label for="g_merek">Merek</label>
                    <select form="form_tambah_barang" name="g_merek[]" id="g_merek" class="auto-save form-control  form-control-sm">
                        @foreach ($brands as $br)
                          @if ($br->id == $cooc_barang->g_merek[$i])
                            <option value="{{ $br->id }}" selected>{{ $br->nama }}</option>
                          @else
                            <option value="{{ $br->id }}">{{ $br->nama }}</option>
                          @endif
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
                        <input value="{{ $cooc_barang->g_h_jual[$i] }}" required autocomplete="off" form="form_tambah_barang" type="number" class="auto-save form-control form-control-sm" id="g_h_jual" name="g_h_jual[]" aria-label="Small">
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
                          @if ($unit->id == $cooc_barang->g_unit_beli[$i])
                            <option value="{{ $unit->id }}" selected>{{ $unit->nama }}</option>
                          @else
                            <option value="{{ $unit->id }}">{{ $unit->nama }}</option>
                          @endif
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-6 pad_table_barang">
                    <label for="g_h_beli">Harga Beli</label>
                    <div class="input-group input-group-sm mb-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp.</span>
                        </div>
                        <input value="{{ $cooc_barang->g_h_beli[$i] }}" required autocomplete="off" form="form_tambah_barang" type="number" class="auto-save form-control form-control-sm" id="g_h_beli" name="g_h_beli[]" aria-label="Small">
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
                          @if ($unit->id == $cooc_barang->g_unit_awal[$i])
                            <option value="{{ $unit->id }}" selected>{{ $unit->nama }}</option>
                          @else
                            <option value="{{ $unit->id }}">{{ $unit->nama }}</option>
                          @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4 pad_table_barang">
                    <label for="g_stok_unit">Stok / Unit Awal</label>
                    <input value="{{ $cooc_barang->g_stok_unit[$i] }}" required autocomplete="off" form="form_tambah_barang" type="number" class="auto-save form-control form-control-sm" id="g_stok_unit" name="g_stok_unit[]">
                    <div class="invalid-feedback">
                      Harus diisi.
                    </div>
                </div>
                <div class="col-sm-4 pad_table_barang">
                    <label for="g_min_qty">Minimal Stok</label>
                    <input value="{{ $cooc_barang->g_min_qty[$i] }}" required autocomplete="off" form="form_tambah_barang" type="number" class="auto-save form-control form-control-sm" id="g_min_qty" name="g_min_qty[]">
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
                        @if ($unit->id == $cooc_barang->g_unit_jual[$i])
                          <option value="{{ $unit->id }}" selected>{{ $unit->nama }}</option>
                        @else
                          <option value="{{ $unit->id }}">{{ $unit->nama }}</option>
                        @endif
                      @endforeach
                    </select>

                </div>

                <div class="col-sm-6 pad_table_barang">
                    <label for="g_du_qty"> Kuantitas / Sale Unit</label>
                    <div class="input-group input-group-sm mb-12">
                      <input value="{{ $cooc_barang->g_du_qty[$i] }}" required autocomplete="off" form="form_tambah_barang" type="number" class="auto-save form-control form-control-sm" id="g_du_qty" name="g_du_qty[]" aria-label="Small">
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
@endfor
