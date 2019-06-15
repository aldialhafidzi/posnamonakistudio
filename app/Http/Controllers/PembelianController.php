<?php

namespace App\Http\Controllers;

use App\Unit;
use App\User;
use App\Brand;
use App\Purchase;
use App\Supplier;
use App\Category;
use App\Detail_Purchase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
      $judul      = 'Hijrah Mandiri - Pembelian';
      $page       = 'pembelian';

      $users      = User::all();
      $suppliers  = Supplier::all();
      $categories = Category::all();
      $brands     = Brand::all();
      $units      = Unit::all();

      $carts_pem      = '';

      if (session()->has('cart_pem')){
        $carts_pem = session()->get('cart_pem.0');
      }

      $no         = Purchase::select('id')->orderBy('id', 'desc')->first();

      if ($no != null) {
        $no         = $no->id + 1;
      } else {
        $no       = 1;
      }

      $bulan      = $this->getRomawi(date('m'));
      $tahun      = date('y');
      $last_inv   = sprintf('%04d', $no);
      $invoice    = "$last_inv/HM/$bulan/$tahun";


      return view('pembelian', [
                              'page'        => $page,
                              'judul'       => $judul,
                              'invoice'     => $invoice,
                              'suppliers'   => $suppliers,
                              'users'       => $users,
                              'categories'  => $categories,
                              'brands'      => $brands,
                              'units'       => $units,
                              'carts_pem'   => $carts_pem
                            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // dd($request->all());
      request()->validate([
        'p_kode'      => 'required',
        'p_qty_good'  => 'required',
        'p_unit_good' => 'required',
        'nomor_nota'  => 'required',
        'id_kasir'    => 'required',
        'id_supplier' => 'required'
      ],
      [
          'p_kode.required'       => ' Anda harus memasukkan kode barang!',
          'p_qty_good.required'   => ' Anda harus memasukkan jumlah barang!',
          'p_unit_good.required'  => ' Anda harus memilih unit barang!',
          'nomor_nota.required'   => ' Nomor nota kosong!',
          'id_kasir.required'     => ' Anda belum login!',
          'id_supplier.required'  => ' Anda harus memilih supplier!',
      ]);

      $data = [
        'employee_id'   => $request['id_kasir'],
        'supplier_id'   => $request['id_supplier'],
        'invoice'       => $request['nomor_nota'],
        'discount'      => 0,
        'grandtotal'    => $request['grandtotal'],
        'catatan'       => $request['catatan']
      ];

      Purchase::create($data);

      $pudchase_id = DB::getPdo()->lastInsertId();

      foreach ($request['p_good_id'] as $key => $value) {

        // Store Detail Penjualan
        $data = [
          'purchase_id'   => $pudchase_id,
          'good_id'   => $request['p_good_id'][$key],
          'unit_id'   => $request['p_unit_good'][$key],
          'qty'       => $request['p_qty_good'][$key],
          'discount'  => $request['p_potongan'][$key]
        ];

        Detail_Purchase::insert($data);

        // Update Stok Barang
        $stok = DB::table('goods')->select('stok_unit')->where('id', $request['p_good_id'][$key])->first();
        $stok = (int)$stok->stok_unit + ((int)$request['p_qty_good'][$key] * (int)$request['p_qty_unit'][$key]);
        DB::table('goods')->where('id', $request['p_good_id'][$key])->update(['stok_unit' => (int)$stok]);

      }

      if($request['cetak_invoice'] == '200OK'){

        // Create Invoice
        $fileType = \PHPExcel_IOFactory::identify(resource_path('excels/invoice_template_pembelian.xlsx'));
        $objReader = \PHPExcel_IOFactory::createReader($fileType);
        $objPHPExcel = $objReader->load(resource_path('excels/invoice_template_pembelian.xlsx'));

        $data  = Detail_Purchase::with(['purchase', 'unit', 'good'])
        ->join('detail_units', function($join){
          $join->on('detail_units.unit_id', '=', 'detail_purchases.unit_id');
          $join->on('detail_units.good_id', '=', 'detail_purchases.good_id');
        })
        ->select('detail_purchases.*', 'detail_units.qty as qty_unit', 'detail_purchases.qty as qty_purchase')
        ->where('purchase_id', $pudchase_id)->get();

        $this->addDataToExcelFile($objPHPExcel->setActiveSheetIndex(0), $data);

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if (!is_dir(public_path('excel'))) {
            mkdir(public_path('excel'));
        }

        if (!is_dir(public_path('excel/import'))) {
            mkdir(public_path('excel/import'));
        }

        $path = 'excel/import/Faktur Pembelian' . time() . 'import.xlsx';
        $objWriter->save(public_path($path));

        $request->session()->flash('status_pembelian', ' Transaksi berhasil disimpan!');
        return redirect('pembelian')->with('invoice', $path);
      }

      return redirect('pembelian')->with('status_pembelian', ' Transaksi berhasil disimpan!');

    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      DB::table('detail_purchases')->where('purchase_id', $id)->delete();
      Purchase::destroy($id);
      return response()->json(['message' => 'Data berhasil dihapus.']);
    }

    public function UpdatePembelian(Request $request)
    {
      request()->validate([
        'p_kode'      => 'required',
        'p_qty_good'  => 'required',
        'p_unit_good' => 'required',
        'nomor_nota'  => 'required',
        'id_kasir'    => 'required',
        'id_supplier' => 'required'
      ],
      [
          'p_kode.required'       => ' Anda harus memasukkan kode barang!',
          'p_qty_good.required'   => ' Anda harus memasukkan jumlah barang!',
          'p_unit_good.required'  => ' Anda harus memilih unit barang!',
          'nomor_nota.required'   => ' Nomor nota kosong!',
          'id_kasir.required'     => ' Anda belum login!',
          'id_supplier.required'  => ' Anda harus memilih supplier!',
      ]);


      $purchase_id = $request['purchase_id'];
      $temp_purchase = json_decode(Detail_Purchase::where('purchase_id', $purchase_id)->get());

      // Kembalikan Stok Semula
      foreach ($temp_purchase as $key => $value) {
        $stok = DB::table('goods')->select('stok_unit')->where('id', $temp_purchase[$key]->good_id)->first();
        $unit = DB::table('detail_units')->select('qty')->where('unit_id', $temp_purchase[$key]->unit_id)->first();
        $stok = (int)$stok->stok_unit - ((int)$temp_purchase[$key]->qty * (int)$unit->qty);
        DB::table('goods')->where('id', $temp_purchase[$key]->good_id)->update(['stok_unit' => (int)$stok]);
      }

      // Hapus Detail Purchase
      DB::table('detail_purchases')->where('purchase_id', $purchase_id)->delete();
      foreach ($request['p_good_id'] as $key => $value) {
        // Store Detail Purchase
        $data = [
          'purchase_id'   => $purchase_id,
          'good_id'   => $request['p_good_id'][$key],
          'unit_id'   => $request['p_unit_good'][$key],
          'qty'       => $request['p_qty_good'][$key],
          'discount'  => $request['p_potongan'][$key]
        ];

        Detail_Purchase::insert($data);

        // Update Stok Barang
        $stok = DB::table('goods')->select('stok_unit')->where('id', $request['p_good_id'][$key])->first();
        $stok = (int)$stok->stok_unit + ((int)$request['p_qty_good'][$key] * (int)$request['p_qty_unit'][$key]);
        DB::table('goods')->where('id', $request['p_good_id'][$key])->update(['stok_unit' => (int)$stok]);
      }

      $purchase = Purchase::find($purchase_id);

      $purchase->employee_id  = $request['id_kasir'];
      $purchase->catatan  = $request['catatan'];
      $purchase->grandtotal  = $request['grandtotal'];

      $purchase->update();
      session()->forget('cart_pem');

      if($request['cetak_invoice'] == '200OK'){
        // Create Invoice
        $fileType = \PHPExcel_IOFactory::identify(resource_path('excels/invoice_template_pembelian.xlsx'));
        $objReader = \PHPExcel_IOFactory::createReader($fileType);
        $objPHPExcel = $objReader->load(resource_path('excels/invoice_template_pembelian.xlsx'));

        $data  = Detail_Purchase::with(['purchase', 'unit', 'good'])
        ->join('detail_units', function($join){
          $join->on('detail_units.unit_id', '=', 'detail_purchases.unit_id');
          $join->on('detail_units.good_id', '=', 'detail_purchases.good_id');
        })
        ->select('detail_purchases.*', 'detail_units.qty as qty_unit', 'detail_purchases.qty as qty_purchase')
        ->where('purchase_id', $purchase_id)->get();

        $this->addDataToExcelFile($objPHPExcel->setActiveSheetIndex(0), $data);

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if (!is_dir(public_path('excel'))) {
            mkdir(public_path('excel'));
        }

        if (!is_dir(public_path('excel/import'))) {
            mkdir(public_path('excel/import'));
        }

        $path = 'excel/import/Invoice' . time() . 'import.xlsx';
        $objWriter->save(public_path($path));

        $request->session()->flash('status_pembelian', ' Transaksi berhasil disimpan!');
        return redirect('pembelian')->with('invoice', $path);
      }

      return redirect('pembelian')->with('status_pembelian', ' Transaksi berhasil disimpan!');

    }

    public function HistoriPembelian()
    {
      $judul      = 'Hijrah Mandiri - Histori Pembelian';
      $page       = 'pembelian';

      return view('historipembelian', [  'page'        => $page,
                                         'judul'       => $judul,

                            ]);
    }

    public function AllPurchase(Request $request)
    {
      $purchase = Purchase::with(['supplier', 'admin'])->get();
      $datatables = Datatables::of($purchase)
                    ->addIndexColumn()
                    ->addColumn('action', function($purchase){
                               return '<a onclick="editPurchasesForm('.$purchase->id.')" style="color : #FFF;" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-edit"></span> Edit</a>'.' '.
                                      '<a onclick="deletePurchasesForm('.$purchase->id.')" style="color : #FFF;" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus_data" data-backdrop="static" data-keyboard="false"><span class="glyphicon glyphicon-trash"></span> Delete</a>';
                             });
       return $datatables->make(true);
    }

    public function CreateSession($id)
    {

      $carts_pem = Detail_Purchase::with(['purchase' => function($query){
        $query->with(['supplier']);
      } ])->with(['good' => function($query){
        $query->with(['detail_unit' => function($query){
          $query->with(['unit']);
        }]);
      }])->where('purchase_id', $id)->get();

      session()->forget('cart_pem');
      session()->push('cart_pem', json_decode($carts_pem));
      session()->flash('message', ' Berhasil mencari data.');

      echo json_encode('200OK');
    }

    public  function DestroyUpdatePembelian()
    {
      session()->forget('cart_pem');
      return redirect('pembelian')->with('status_pembelian', ' Update pembelian dibatalkan!');
    }

    private function addDataToExcelFile ($setCell, $data)
    {
        $setCell->setCellValue('A7', 'RS Betha Medika');
        $setCell->setCellValue('F7', 'No           : 0311/HM/VIII/18');
        $setCell->setCellValue('F8', 'Tanggal    : 31 Agustus 2018');

        $base_row  = 13;
        $total = 0;
        foreach ($data as $key => $item) {
          $x = $base_row + $key;

          $harga_unit = floatval($item->qty_unit) * (int)$item->good->h_jual;
          $discount   = $item->discount;

          if ($discount == null){
            $discount = 0;
          }

          $harga_nett = (int)$harga_unit - (int)$discount;
          $subtotal   = (int)$harga_nett * (int)$item->qty_purchase;
          $total      = $total + $subtotal;
            $setCell
                ->insertNewRowBefore($x, 1)
                ->setCellValue('A' . $x, $key+1)
                ->setCellValue('B' . $x, $item->good->nama)
                ->setCellValue('C' . $x, $item->qty)
                ->setCellValue('D' . $x, $item->unit->nama)
                ->setCellValue('E' . $x, $harga_unit)
                ->setCellValue('F' . $x, $item->discount)
                ->setCellValue('G' . $x, $harga_nett)
                ->setCellValue('H' . $x, $subtotal);

        }

        $row_total_harga = count($data) + $base_row + 1;
        $row_discount_tr = $row_total_harga + 1;
        $setCell->setCellValue('H'. $row_total_harga, $total);
        $setCell->setCellValue('H'. $row_discount_tr, '0');
        $setCell->removeRow($base_row -1,1);

        return $this;
    }

    private function getRomawi($bln){
                switch ($bln){
                    case 1:
                        return "I";
                        break;
                    case 2:
                        return "II";
                        break;
                    case 3:
                        return "III";
                        break;
                    case 4:
                        return "IV";
                        break;
                    case 5:
                        return "V";
                        break;
                    case 6:
                        return "VI";
                        break;
                    case 7:
                        return "VII";
                        break;
                    case 8:
                        return "VIII";
                        break;
                    case 9:
                        return "IX";
                        break;
                    case 10:
                        return "X";
                        break;
                    case 11:
                        return "XI";
                        break;
                    case 12:
                        return "XII";
                        break;
                }
    }
}
