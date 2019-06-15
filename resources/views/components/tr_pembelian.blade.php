@php
  $i = 1;
@endphp

@foreach ($carts_pem as $key => $value)
  <tr>
      <td>
          <div style="width : 30px;" class="baris-tr" id="number_row" valign="center" align="center">{{ $i }}</div>
      </td>

      <td>
          <div class="ui-widget coeg p-field-kode">
                <select required  style="width : 150px;" onchange="check_detail_barang_penjualan(this)" onclick="check_list_barang_penjualan(this)" placeholder="Kode / Nama Barang" class="form-control "  id="p_kode" name="p_kode[]">
                  <option selected value="{{ $carts_pem[$key]->good->kode }}">{{ $carts_pem[$key]->good->kode }}</option>
                </select>
              <input required  class="" type="hidden" name="p_good_id[]" id="p_good_id" value="{{ $carts_pem[$key]->good->id }}">
          </div>
      </td>

      <td>
        <div class="p-field-nama">
          <label class="" style="width : 150px;" scope="col" id="p_nama_good">{{ $carts_pem[$key]->good->nama }}</label>
        </div>
      </td>

      <td>
        <div class="p-field-unit">
          <select onchange="hitung_total()" required   numa="1" name="p_unit_good[]" id="p_unit_good" class="form-control">
            @php
              $p_qty_unit = 0
            @endphp
            @for ($k=0; $k < count($carts_pem[$key]->good->detail_unit); $k++)
              @if ($carts_pem[$key]->good->detail_unit[$k]->unit_id == $carts_pem[$key]->unit_id)
                <option qty="{{ $carts_pem[$key]->good->detail_unit[$k]->qty }}" selected value="{{ $carts_pem[$key]->good->detail_unit[$k]->unit_id }}">{{ $carts_pem[$key]->good->detail_unit[$k]->unit->nama }}</option>
                 @php
                   $p_qty_unit = $carts_pem[$key]->good->detail_unit[$k]->qty
                 @endphp
              @else
                <option qty="{{ $carts_pem[$key]->good->detail_unit[$k]->qty }}" value="{{ $carts_pem[$key]->good->detail_unit[$k]->unit_id }}">{{ $carts_pem[$key]->good->detail_unit[$k]->unit->nama }}</option>
              @endif
            @endfor
          </select>
          <input type="hidden" name="p_qty_unit[]" id="p_qty_unit" value="{{ $p_qty_unit }}">
        </div>
      </td>

      <td>
          <div class="p-field-qty">

            <input onchange="hitung_total()" value="{{ $carts_pem[$key]->qty }}" required  style="width:60px;" scope="col"  type="number" numa="1" class="form-control  qty_1 edit_qty_tr" id="p_qty_good" name="p_qty_good[]" style="width:60px;">

          </div>
      </td>

      <td>
        <div class="p-field-harga">
          <label style="width : 100px;" scope="col" class="" id="p_harga_good_label">{{  "Rp " . number_format($carts_pem[$key]->good->h_jual,0,',','.') }}</label>
          <input class="" type="hidden" name="p_harga_good[]" id="p_harga_good" value="{{ $carts_pem[$key]->good->h_jual }}">
        </div>
      </td>

      <td>
        <div class="p-field-potongan">
          <input onchange="hitung_total()" type="number"  class=" form-control edit_potongan_tr potongan" id="p_potongan" name="p_potongan[]" style="width:100px;" value="{{ $carts_pem[$key]->discount }}">
        </div>
      </td>
      @php
        $sub = (int)$carts_pem[$key]->good->h_jual * floatval($p_qty_unit) * (int)$carts_pem[$key]->qty
      @endphp

      <td>
        <div class="p-field-subtotal">
          <label style="width : 100px;" scope="col" class="" id="p_subtotal_label"> {{ "Rp " . number_format($sub,0,',','.') }}</label>
          <input type="hidden" class="subtotal" class="" name="p_subtotal[]" id="p_subtotal" value="{{ $sub }}">
        </div>
      </td>

      <td>
        <button onclick="hapusRowPembelian(this)" class="btn btn-danger btn-sm" id="HapusBaris" style="color:#fff;">
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
        </button>
      </td>

  </tr>
  @php
    $i++;
  @endphp
@endforeach
