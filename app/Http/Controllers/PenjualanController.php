<?php

namespace App\Http\Controllers;

use App\Good;
use App\Combo;
use App\Sale;
use App\Unit;
use App\Brand;
use App\User;
use App\Customer;
use App\Category;
use App\Detail_Unit;
use App\Detail_Sale;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
      $units      = Unit::all();
      $brands     = Brand::all();
      $categories = Category::all();
      $kasir      = User::all();

      $carts      = '';

      if (session()->has('cart')){
        $carts = session()->get('cart.0');
      }

      $bulan        = $this->getRomawi(date('m'));
      $tahun        = date('y');
      $no           = DB::table('sales')->orderBy('id', 'desc')->first();

      if ($no != null) {
        $no           = $no->id + 1;
      } else {
        $no = 1;
      }

      $lastCust     = sprintf('%04d', $no);
      $invoice      = "$lastCust/HM/$bulan/$tahun";

      $judul      = 'Hijrah Mandiri - Penjualan';
      $page       = 'penjualan';

      return view('penjualan', [ 'units'    => $units,
                              'brands'      => $brands,
                              'categories'  => $categories,
                              'page'        => $page,
                              'judul'       => $judul,
                              'invoice'     => $invoice,
                              'kasir'       => $kasir,
                              'carts'       => $carts
                            ]);
    }

    public function HistoriPenjualan()
    {
      $judul      = 'Hijrah Mandiri - Histoi Penjualan';
      $page       = 'penjualan';

      return view('historipenjualan', [  'page'        => $page,
                                         'judul'       => $judul,

                            ]);
    }

    public function AllSales()
    {
      $sales = Sale::with(['customer', 'employee']);
      $datatables = Datatables::of($sales)
                    ->addIndexColumn()
                    ->addColumn('action', function($sales){
                               return '<a onclick="editSalesForm('.$sales->id.')" style="color : #FFF;" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-edit"></span> Edit</a>'.' '.
                                      '<a onclick="deleteSalesForm('.$sales->id.')" style="color : #FFF;" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus_data" data-backdrop="static" data-keyboard="false"><span class="glyphicon glyphicon-trash"></span> Delete</a>';
                             });
       return $datatables->make(true);
    }

    public function CreateSession($id)
    {

      $cart = Detail_Sale::with(['sale' => function($query){
        $query->with(['customer']);
      } ])->with(['good' => function($query){
        $query->with(['detail_unit' => function($query){
          $query->with(['unit']);
        }]);
      }])->where('sale_id', $id)->get();

      // dd(json_decode($cart));
      session()->forget('cart');
      // $cart = ['1', '2', '3'];
      session()->push('cart', json_decode($cart));
      session()->flash('message', ' Berhasil mencari data.');

      echo json_encode('200OK');
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
        request()->validate([
          'p_kode'      => 'required',
          'p_qty_good'  => 'required',
          'p_unit_good' => 'required',
          'nomor_nota'  => 'required',
          'id_kasir'    => 'required',
          'id_customer' => 'required'
        ],
        [
            'p_kode.required'       => ' Anda harus memasukkan kode barang!',
            'p_qty_good.required'   => ' Anda harus memasukkan jumlah barang!',
            'p_unit_good.required'  => ' Anda harus memilih unit barang!',
            'nomor_nota.required'   => ' Nomor nota kosong!',
            'id_kasir.required'     => ' Anda belum login!',
            'id_customer.required'  => ' Anda harus memilih pelanggan!',
        ]);


        // Create Invoice
        $data = [
          'employee_id'   => $request['id_kasir'],
          'customer_id'   => $request['id_customer'],
          'invoice'       => $request['nomor_nota'],
          'discount'      => 0,
          'grandtotal'    => $request['grandtotal'],
          'catatan'       => $request['catatan']
        ];

        Sale::create($data);

        $sale_id = DB::getPdo()->lastInsertId();

        foreach ($request['p_good_id'] as $key => $value) {

          // Store Detail Penjualan
          $data = [
            'sale_id'   => $sale_id,
            'good_id'   => $request['p_good_id'][$key],
            'unit_id'   => $request['p_unit_good'][$key],
            'qty'       => $request['p_qty_good'][$key],
            'discount'  => $request['p_potongan'][$key]
          ];

          Detail_Sale::insert($data);

          // Update Stok Barang

          $good = DB::table('goods')->where('id', $request['p_good_id'][$key])->first();

          if ($good->cbo == "Y") {
            $data_combos = json_decode(Combo::where('combos_id',$request['p_good_id'][$key])->get());
            $combos = Combo::where('combos_id',$request['p_good_id'][$key]);

            for ($i=0; $i < count($data_combos) ; $i++) {
              $d_combo = json_decode($combos->with(['comboToGood' => function ($query) use($data_combos, $i){
                $query->with(['detail_unit' => function($query) use($data_combos, $i){
                  $query->where('detail_units.good_id', $data_combos[$i]->good_id)
                        ->where('detail_units.unit_id', $data_combos[$i]->unit_id);
                }]);
              }])->get());

              $stok = (int)$d_combo[$i]->combo_to_good->stok_unit - ( (int)$request['p_qty_good'][$key] * (int)$d_combo[$i]->qty * (int)$d_combo[$i]->combo_to_good->detail_unit[0]->qty);
              DB::table('goods')->where('id', $d_combo[$i]->good_id)->update(['stok_unit' => (int)$stok]);
            }

            $stok_cbo = 0;
            $s_stok = 9999999999;

            for ($i=0; $i < count($data_combos) ; $i++) {
              $good = Good::find($data_combos[$i]->good_id);
              $unit_id = $data_combos[$i]->unit_id;
              $good_id = $data_combos[$i]->good_id;

              $que = $good->with(['detail_unit' => function ($query) use($unit_id, $good_id) {
                 $query->where('detail_units.unit_id', '=', $unit_id )
                       ->where('detail_units.good_id', '=', $good_id);
               }])->where('id', $good_id)->first();

              $data_good = json_decode($que);
              $stok_cbo = (int)$good->stok_unit / (int)$data_good->detail_unit[0]->qty / (int)$data_combos[$i]->qty;

              if($stok_cbo < $s_stok){
                $s_stok = (int)$stok_cbo;
              }
            }

            DB::table('goods')->where('id', $request['p_good_id'][$key])->update(['stok_unit' => $s_stok]);

          }

          else {
            $stok = (int)$good->stok_unit - ((int)$request['p_qty_good'][$key] * (int)$request['p_qty_unit'][$key]);
            DB::table('goods')->where('id', $request['p_good_id'][$key])->update(['stok_unit' => (int)$stok]);
          }



        }

        if($request['cetak_invoice'] == '200OK'){
          $fileType = \PHPExcel_IOFactory::identify(resource_path('excels/invoice_template_penjualan.xlsx'));
          $objReader = \PHPExcel_IOFactory::createReader($fileType);
          $objPHPExcel = $objReader->load(resource_path('excels/invoice_template_penjualan.xlsx'));

          $data  = Detail_Sale::with(['sale', 'unit', 'good'])
          ->join('detail_units', function($join){
            $join->on('detail_units.unit_id', '=', 'detail_sales.unit_id');
            $join->on('detail_units.good_id', '=', 'detail_sales.good_id');
          })
          ->select('detail_sales.*', 'detail_units.qty as qty_unit', 'detail_sales.qty as qty_sale')
          ->where('sale_id', $sale_id)->get();

          $this->addDataToExcelFile($objPHPExcel->setActiveSheetIndex(0), $data);

          $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
          if (!is_dir(public_path('excel'))) {
              mkdir(public_path('excel'));
          }

          if (!is_dir(public_path('excel/import'))) {
              mkdir(public_path('excel/import'));
          }

          $path = 'excel/import/Faktur Penjualan' . time() . 'import.xlsx';
          $objWriter->save(public_path($path));

          $request->session()->flash('status_penjualan', ' Transaksi berhasil disimpan!');
          return redirect('penjualan')->with('invoice', $path);
        }

        return redirect('penjualan')->with('status_penjualan', ' Transaksi berhasil disimpan!');


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
       DB::table('detail_sales')->where('sale_id', $id)->delete();
       Sale::destroy($id);
       return response()->json(['message' => 'Data berhasil dihapus.']);
    }

    public function FindCustomer(Request $request)
    {
      $term = trim($request->q);
      $pencarian = $request['temp'];
      $customer = Customer::where('nama', 'LIKE', '%'.$term.'%')
                          ->orWhere('alamat', 'LIKE', '%'.$term.'%')
                          ->orWhere('no_telp', 'LIKE', '%'.$term.'%')
                          ->limit(10)->get();

      $formated_customers = [];

      foreach ($customer as $cust) {
          $formated_customers [] = ['id' => $cust->id,
                               'text' => $cust->nama,
                               'alamat' => $cust->alamat,
                               'no_telp' => $cust->no_telp];
      }
      return \Response::json($formated_customers);
    }

    public function SimpanPelanggan(Request $request)
    {

      $data = [
        'nama'    => $request['nama'],
        'alamat'  => $request['alamat'],
        'no_telp' => $request['no_telp']
      ];

      Customer::insert($data);

      return response()->json(['message' => 'Data pelanggan berhasil ditambahkan.']);

    }

    public function UpdatePenjualan(Request $request)
    {
      request()->validate([
        'p_kode'      => 'required',
        'p_qty_good'  => 'required',
        'p_unit_good' => 'required',
        'nomor_nota'  => 'required',
        'id_kasir'    => 'required',
        'id_customer' => 'required'
      ],
      [
          'p_kode.required'       => ' Anda harus memasukkan kode barang!',
          'p_qty_good.required'   => ' Anda harus memasukkan jumlah barang!',
          'p_unit_good.required'  => ' Anda harus memilih unit barang!',
          'nomor_nota.required'   => ' Nomor nota kosong!',
          'id_kasir.required'     => ' Anda belum login!',
          'id_customer.required'  => ' Anda harus memilih pelanggan!',
      ]);


      $sale_id = $request['sale_id'];
      $temp_sale = json_decode(Detail_Sale::where('sale_id', $sale_id)->get());
      foreach ($temp_sale as $key => $value) {
        $stok = DB::table('goods')->select('stok_unit')->where('id', $temp_sale[$key]->good_id)->first();
        $unit = DB::table('detail_units')->select('qty')->where('unit_id', $temp_sale[$key]->unit_id)->first();
        $stok = (int)$stok->stok_unit + ((int)$temp_sale[$key]->qty * (int)$unit->qty);
        DB::table('goods')->where('id', $temp_sale[$key]->good_id)->update(['stok_unit' => (int)$stok]);
      }

      DB::table('detail_sales')->where('sale_id', $sale_id)->delete();
      foreach ($request['p_good_id'] as $key => $value) {
        // Store Detail Penjualan
        $data = [
          'sale_id'   => $sale_id,
          'good_id'   => $request['p_good_id'][$key],
          'unit_id'   => $request['p_unit_good'][$key],
          'qty'       => $request['p_qty_good'][$key],
          'discount'  => $request['p_potongan'][$key]
        ];

        Detail_Sale::insert($data);

        // Update Stok Barang
        $good = DB::table('goods')->where('id', $request['p_good_id'][$key])->first();

        if ($good->cbo == "Y") {
          $data_combos = json_decode(Combo::where('combos_id',$request['p_good_id'][$key])->get());
          $combos = Combo::where('combos_id',$request['p_good_id'][$key]);

          for ($i=0; $i < count($data_combos) ; $i++) {
            $d_combo = json_decode($combos->with(['comboToGood' => function ($query) use($data_combos, $i){
              $query->with(['detail_unit' => function($query) use($data_combos, $i){
                $query->where('detail_units.good_id', $data_combos[$i]->good_id)
                      ->where('detail_units.unit_id', $data_combos[$i]->unit_id);
              }]);
            }])->get());

            $stok = (int)$d_combo[$i]->combo_to_good->stok_unit - ( (int)$request['p_qty_good'][$key] * (int)$d_combo[$i]->qty * (int)$d_combo[$i]->combo_to_good->detail_unit[0]->qty);
            DB::table('goods')->where('id', $d_combo[$i]->good_id)->update(['stok_unit' => (int)$stok]);
          }

          $stok_cbo = 0;
          $s_stok = 9999999999;

          for ($i=0; $i < count($data_combos) ; $i++) {
            $good = Good::find($data_combos[$i]->good_id);
            $unit_id = $data_combos[$i]->unit_id;
            $good_id = $data_combos[$i]->good_id;

            $que = $good->with(['detail_unit' => function ($query) use($unit_id, $good_id) {
               $query->where('detail_units.unit_id', '=', $unit_id )
                     ->where('detail_units.good_id', '=', $good_id);
             }])->where('id', $good_id)->first();

            $data_good = json_decode($que);
            $stok_cbo = (int)$good->stok_unit / (int)$data_good->detail_unit[0]->qty / (int)$data_combos[$i]->qty;

            if($stok_cbo < $s_stok){
              $s_stok = (int)$stok_cbo;
            }
          }

          DB::table('goods')->where('id', $request['p_good_id'][$key])->update(['stok_unit' => $s_stok]);

        }

        else {
          $stok = (int)$good->stok_unit - ((int)$request['p_qty_good'][$key] * (int)$request['p_qty_unit'][$key]);
          DB::table('goods')->where('id', $request['p_good_id'][$key])->update(['stok_unit' => (int)$stok]);
        }


      }

      $sale = Sale::find($sale_id);

      $sale->employee_id  = $request['id_kasir'];
      $sale->catatan  = $request['catatan'];
      $sale->grandtotal  = $request['grandtotal'];

      $sale->update();
      session()->forget('cart');

      if($request['cetak_invoice'] == '200OK'){
        // Create Invoice
        $fileType = \PHPExcel_IOFactory::identify(resource_path('excels/invoice_template_penjualan.xlsx'));
        $objReader = \PHPExcel_IOFactory::createReader($fileType);
        $objPHPExcel = $objReader->load(resource_path('excels/invoice_template_penjualan.xlsx'));

        $data  = Detail_Sale::with(['sale', 'unit', 'good'])
        ->join('detail_units', function($join){
          $join->on('detail_units.unit_id', '=', 'detail_sales.unit_id');
          $join->on('detail_units.good_id', '=', 'detail_sales.good_id');
        })
        ->select('detail_sales.*', 'detail_units.qty as qty_unit', 'detail_sales.qty as qty_sale')
        ->where('sale_id', $sale_id)->get();

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

        $request->session()->flash('status_penjualan', ' Transaksi berhasil disimpan!');
        return redirect('penjualan')->with('invoice', $path);
      }

      return redirect('penjualan')->with('status_penjualan', ' Transaksi berhasil disimpan!');

    }

    public  function DestroyUpdatePenjualan()
    {
      session()->forget('cart');
      return redirect('penjualan')->with('status_penjualan', ' Update penjualan dibatalkan!');
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
          $subtotal   = (int)$harga_nett * (int)$item->qty_sale;
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

        // $setCell->getStyle("B12:H" . ($index+10) )->applyFromArray(array(
        //     'borders' => array(
        //         'outline' => array(
        //             'style' => \PHPExcel_Style_Border::BORDER_THIN,
        //             'color' => array('argb' => '000000'),
        //             'size' => 1,
        //         ),
        //         'inside' => array(
        //             'style' => \PHPExcel_Style_Border::BORDER_THIN,
        //             'color' => array('argb' => '000000'),
        //             'size' => 1,
        //         ),
        //     ),
        // ));
        //------------------------------------------------------------------

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
