<?php

namespace App\Http\Controllers;

use Excel;
use DateTime;
use Dompdf\Dompdf;
use App\Good;
use App\Sale;
use App\Customer;
use App\Supplier;
Use App\Detail_Sale;
use App\Exports\SalesExport;
use App\Exports\PurchasesExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {

      $customers  = Customer::all();
      $suppliers  = Supplier::all();
      $goods      = Good::where('cbo', 'N')->get();

      $judul      = 'Hijrah Mandiri - Laporan';
      $page       = 'laporan';

      return view('laporan', ['page'        => $page,
                              'judul'       => $judul,
                              'customers'   => $customers,
                              'suppliers'   => $suppliers,
                              'goods'       => $goods
                            ]);
    }



    public function ExportPembelian(Request $request)
    {

      if ($request['printPurchases'] == 'headerPurchases') {
        return (new PurchasesExport($request->all()))->download('Laporan Pembelian.xlsx');
      }
      else {
        return (new PurchasesExport($request->all()))->download('Laporan Detail Pembelian.xlsx');
      }
    }

    public function ExportPenjualan(Request $request)
    {
      if ($request['printSales'] == 'headerSales') {
        return (new SalesExport($request->all()))->download('Laporan Penjualan.xlsx');
      }
      else {
        return (new SalesExport($request->all()))->download('Laporan Detail Penjualan.xlsx');
      }
    }

    public function ExportGood(Request $request)
    {
      if ($request['printGood'] == 'headerGood') {

        $goods            = $request['choose_good'];
        $data['awal']     = date('Y-m-d H:i:s', strtotime($request['date_dari_barang']));
        $data['akhir']    = date('Y-m-d H:i:s', strtotime($request['date_sampai_barang']));

        $dataAfterReport  = Good::with(['detail_sale' => function($query) use($data){
          $query->with(['sale' => function($query) use($data){
            $query->where('updated_at', '>=', $data['akhir']);
          }]);
        }])->with(['detail_purchase' => function($query) use($data){
          $query->with(['purchase' => function($query) use($data){
            $query->where('updated_at', '>=', $data['akhir']);
          }]);
        }])->where(function($query) use($goods) {
          foreach ($goods as $good) {
            $query->orWhere('id', $good);
          }
        })->get();

        $dataReport       = Good::with(['detail_sale' => function($query) use($data){
          $query->with(['sale' => function($query) use($data){
            $query->where('updated_at', '>=', $data['awal'])
                  ->where('updated_at', '<=', $data['akhir']);
          }]);
        }])->with(['detail_purchase' => function($query) use($data){
          $query->with(['purchase' => function($query) use($data){
            $query->where('updated_at', '>=', $data['awal'])
                  ->where('updated_at', '<=', $data['akhir']);
          }]);
        }])->where(function($query) use($goods) {
          foreach ($goods as $good) {
            $query->orWhere('id', $good);
          }
        })->get();

        if ($request['export_pdf_good'] == 'PDF') {
            $PDF_SM_Report = $this->SM_Report_Header_PDF($dataReport, $dataAfterReport, $data);
            $dompdf = new Dompdf();
            $dompdf->loadHtml($PDF_SM_Report);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $name_file = 'Stock Movement Report ' . time() . 'import.pdf';
            $dompdf->stream($name_file);
            exit;
        }
        else {
          $fileType = \PHPExcel_IOFactory::identify(resource_path('excels/template_SM_Report.xlsx'));
          $objReader = \PHPExcel_IOFactory::createReader($fileType);
          $objPHPExcel = $objReader->load(resource_path('excels/template_SM_Report.xlsx'));

          $this->SM_Report_Header_EXCEL($objPHPExcel->setActiveSheetIndex(0), $dataReport, $dataAfterReport, $data);

          $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
          if (!is_dir(public_path('excel'))) {
              mkdir(public_path('excel'));
          }
          if (!is_dir(public_path('excel/import'))) {
              mkdir(public_path('excel/import'));
          }
          $path = 'excel/import/SM Report ' . time() . 'import.xlsx';
          $objWriter->save(public_path($path));
          $request->session()->flash('status_laporan', ' Laporan Barang Berhasil Dicetak!');
          return redirect('laporan')->with('laporan_barang', $path);
        }

      }

      else if ($request['printGood'] == 'detailGood') {
        $fileType = \PHPExcel_IOFactory::identify(resource_path('excels/template_SM_Report_Detail.xlsx'));
        $objReader = \PHPExcel_IOFactory::createReader($fileType);
        $objPHPExcel = $objReader->load(resource_path('excels/template_SM_Report_Detail.xlsx'));

        $data['awal']     = date('Y-m-d H:i:s', strtotime($request['date_dari_barang']));
        $data['akhir']    = date('Y-m-d H:i:s', strtotime($request['date_sampai_barang']));

        $goods = $request['choose_good'];
        $dataReport = Good::with(['detail_sale' => function($query) use($data){
          $query->with(['sale' => function($query) use($data){
            $query->where('updated_at', '>=', $data['awal'])
                  ->where('updated_at', '<=', $data['akhir'])
                  ->orderBy('updated_at');
          }]);
        }])->with(['detail_purchase' => function($query) use($data){
          $query->with(['purchase' => function($query) use($data){
            $query->where('updated_at', '>=', $data['awal'])
                  ->where('updated_at', '<=', $data['akhir'])
                  ->orderBy('updated_at');
          }]);
        }])->where(function($query) use($goods) {
          foreach ($goods as $good) {
            $query->orWhere('id', $good);
          }
        })->get();

        if ($request['export_pdf_good'] == 'PDF') {
          $PDF_SM_Report = $this->SM_Report_Detail_PDF($dataReport, $data);
          $dompdf = new Dompdf();
          $dompdf->loadHtml($PDF_SM_Report);
          $dompdf->setPaper('A4', 'landscape');
          $dompdf->render();
          $name_file = 'SM Report Detail' . time() . 'import.pdf';
          $dompdf->stream($name_file);
          exit;
        }
        else {
          $this->SM_Report_Detail_EXCEL($objPHPExcel->setActiveSheetIndex(0), $dataReport, $data);

          $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
          if (!is_dir(public_path('excel'))) {
              mkdir(public_path('excel'));
          }
          if (!is_dir(public_path('excel/import'))) {
              mkdir(public_path('excel/import'));
          }
          $path = 'excel/import/SM Report Detail' . time() . 'import.xlsx';
          $objWriter->save(public_path($path));
          $request->session()->flash('status_laporan', ' Laporan Barang Berhasil Dicetak!');
          return redirect('laporan')->with('laporan_barang', $path);
        }
      }

      else {

        $fileType = \PHPExcel_IOFactory::identify(resource_path('excels/template_Stock_Report.xlsx'));
        $objReader = \PHPExcel_IOFactory::createReader($fileType);
        $objPHPExcel = $objReader->load(resource_path('excels/template_Stock_Report.xlsx'));

        $goods    = $request['choose_good'];
        $tanggal  = date('Y-m-d H:i:s', strtotime($request['tanggal']));
        $dataReport = Good::with(['detail_sale' => function($query) use($tanggal){
          $query->with(['sale' => function($query) use($tanggal){
            $query->where('updated_at', '>=', $tanggal);
          }]);
        }])->with(['detail_purchase' => function($query) use($tanggal){
          $query->with(['purchase' => function($query) use($tanggal){
            $query->where('updated_at', '>=', $tanggal);
          }]);
        }])->with(['unit'])->where(function($query) use($goods) {
          foreach ($goods as $good) {
            $query->orWhere('id', $good);
          }
        })->get();


        if ($request['export_pdf_good'] == 'PDF') {
          $stock_Report = $this->StockReport_PDF($dataReport, $tanggal);
          $dompdf = new Dompdf();
          $dompdf->loadHtml($stock_Report);
          $dompdf->setPaper('A4', 'landscape');
          $dompdf->render();
          $name_file = 'Stock Report' . time() . 'import.pdf';
          $dompdf->stream($name_file);
          exit;
        }
        else {
          $this->StockReport_EXCEL($objPHPExcel->setActiveSheetIndex(0), $dataReport, $tanggal);
          $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
          if (!is_dir(public_path('excel'))) {
              mkdir(public_path('excel'));
          }
          if (!is_dir(public_path('excel/import'))) {
              mkdir(public_path('excel/import'));
          }
          $path = 'excel/import/Stock Report ' . time() . 'import.xlsx';
          $objWriter->save(public_path($path));
          $request->session()->flash('status_laporan', ' Laporan Barang Berhasil Dicetak!');
          return redirect('laporan')->with('laporan_barang', $path);
        }
      }
    }

    private function StockReport_PDF($dataReport, $tanggal)
    {
      $time       = strtotime($tanggal);
      $tanggal    = date('d F Y', $time);

      $html_ = '<html>
        <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <style>
          table, tr, td {
            border: 1px inset black;
            border-collapse: collapse;
            border-spacing: 0;
          }
        </style>
        </head>
        <body>
        <div align="center">
          <h2>Stock Report</h2>
        </div>
        <div align="center" style="margin-top:-20px;">
          '.$tanggal.'
        </div>
        <br>
        <table align="center">
          <thead>
              <tr>
                <td align="center" style="width:40px;">No</td>
                <td align="center" style="width:80px;">Kode</td>
                <td align="center" style="width:200px;">Nama</td>
                <td align="center" style="width:40px;">Stock</td>
                <td align="center" style="width:40px;">Unit</td>
              </tr>
          </thead>
          <tbody>';

          foreach ($dataReport as $key => $item) {
            $number     = $key + 1;
            $report_out = 0;
            $report_in  = 0;

            for ($i=0; $i < count($item->detail_sale) ; $i++) {
              if ($item->detail_sale[$i]->sale != null) {
                $report_out = $report_out + $item->detail_sale[$i]->qty;
              }
            }

            for ($i=0; $i < count($item->detail_purchase) ; $i++) {
              if ($item->detail_purchase[$i]->purchase != null) {
                $report_in = $report_in + $item->detail_purchase[$i]->qty;
              }
            }

            $stok_report = $item->stok_unit + $report_out - $report_in;

            $html_ .='<tr>
                <td align="center">'.$number.'</td>
                <td align="center">'.$item->kode.'</td>
                <td>'.$item->nama.'</td>
                <td align="center">'.$stok_report.'</td>
                <td align="center">'.$item->unit->nama.'</td>
              </tr>';

          }

          $html_ .='
          </tbody>
        </table>
        </body>
      </html>';

      return $html_;
    }

    private function StockReport_EXCEL ($setCell, $dataReport, $tanggal)
    {

      $time       = strtotime($tanggal);
      $tanggal    = date('d F Y', $time);

      $setCell->setCellValue('A3', $tanggal);

      $base_row     = 7;
      foreach ($dataReport as $key => $item) {

        $x          = $base_row + $key;
        $report_out = 0;
        $report_in  = 0;

        for ($i=0; $i < count($item->detail_sale) ; $i++) {
          if ($item->detail_sale[$i]->sale != null) {
            $report_out = $report_out + $item->detail_sale[$i]->qty;
          }
        }

        for ($i=0; $i < count($item->detail_purchase) ; $i++) {
          if ($item->detail_purchase[$i]->purchase != null) {
            $report_in = $report_in + $item->detail_purchase[$i]->qty;
          }
        }

        $stok_report = $item->stok_unit + $report_out - $report_in;

        $setCell->insertNewRowBefore($x, 1)
                ->setCellValue('A' . $x, $key+1)
                ->setCellValue('B' . $x, $item->kode)
                ->setCellValue('C' . $x, $item->nama)
                ->setCellValue('D' . $x, $stok_report)
                ->setCellValue('E' . $x, $item->unit->nama);

      }

      $setCell->getStyle('A6:E6')->applyFromArray(
          array(
              'fill' => array(
                  'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                  'color' => array('rgb' => 'bebebe')
              )
          )
      )->getFont()->setBold( true );

      return $this;
    }

    private function SM_Report_Header_PDF($dataReport, $dataAfterReport, $data){

      $time = strtotime($data['awal']);
      $awal = date('d F Y', $time);
      $time = strtotime($data['akhir']);
      $akhir = date('d F Y', $time);

      $PDF_SM_Report = '
      <!DOCTYPE html>
      <html lang="en" dir="ltr">
        <head>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <style>
            table, tr, td {
              border: 1px inset black;
              border-collapse: collapse;
              border-spacing: 0;
            }
          </style>
        </head>
          <body>
          <div align="center">
            <h2>Stock Movement Report</h2>
          </div>
          <div align="center" style="margin-top:-20px;">
            '.$awal.' - '.$akhir.'
          </div>
          <br>
          <div align="center">
            <table align="center">
              <thead>
                <tr>
                  <td style="width:40px;" align="center">No</td>
                  <td style="width:80px;" align="center">Kode</td>
                  <td style="width:200px;" align="center">Nama</td>
                  <td style="width:40px;" align="center">Opening</td>
                  <td style="width:40px;" align="center">In</td>
                  <td style="width:40px;" align="center">Out</td>
                  <td style="width:40px;" align="center">Closing</td>
                </tr>
              </thead>
              <tbody>';

              foreach ($dataReport as $key => $item) {
                $number = $key + 1;

                $opening_qtyOut = 0;
                $opening_qtyIn  = 0;
                $closing_qtyOut = 0;
                $closing_qtyIn = 0;

                // CLOSING STOCK
                for ($i=0; $i < count($dataAfterReport[$key]->detail_sale) ; $i++) {
                  if ($dataAfterReport[$key]->detail_sale[$i]->sale != null) {
                    $closing_qtyOut = $closing_qtyOut + $dataAfterReport[$key]->detail_sale[$i]->qty;
                  }
                }
                for ($i=0; $i < count($dataAfterReport[$key]->detail_purchase) ; $i++) {
                  if ($dataAfterReport[$key]->detail_purchase[$i]->purchase != null) {
                    $closing_qtyIn = $closing_qtyIn + $dataAfterReport[$key]->detail_purchase[$i]->qty;
                  }
                }
                // CLOSING STOCK

                // OPENING STOCK
                for ($i=0; $i < count($item->detail_sale) ; $i++) {
                  if ($item->detail_sale[$i]->sale != null) {
                    $opening_qtyOut = $opening_qtyOut + $item->detail_sale[$i]->qty;
                  }
                }
                for ($i=0; $i < count($item->detail_purchase) ; $i++) {
                  if ($item->detail_purchase[$i]->purchase != null) {
                    $opening_qtyIn = $opening_qtyIn + $item->detail_purchase[$i]->qty;
                  }
                }
                // OPENING STOCK

                $closing_stok = $item->stok_unit + $closing_qtyOut - $closing_qtyIn;
                $opening_stok = $closing_stok + $opening_qtyOut - $opening_qtyIn;

                $PDF_SM_Report .= '<tr>
                  <td align="center">'.$number.'</td>
                  <td align="center">'.$item->kode.'</td>
                  <td>'.$item->nama.'</td>
                  <td align="center">'.$opening_stok.'</td>
                  <td align="center">'.$opening_qtyIn.'</td>
                  <td align="center">'.$opening_qtyOut.'</td>
                  <td align="center">'.$closing_stok.'</td>
                </tr>';

              }

              $PDF_SM_Report .= '
              </tbody>
            </table>
            </div>
          </body>
        </html>
      ';

      return $PDF_SM_Report;
    }

    private function SM_Report_Header_EXCEL ($setCell, $dataReport, $dataAfterReport, $data)
    {
        $time = strtotime($data['awal']);
        $awal = date('d F Y', $time);

        $time = strtotime($data['akhir']);
        $akhir = date('d F Y', $time);
        $setCell->setCellValue('A2', ''.$awal.' - '.$akhir.'');

        $base_row  = 6;

        foreach ($dataReport as $key => $item) {

          $x = $base_row + $key;

          $opening_qtyOut = 0;
          $opening_qtyIn  = 0;
          $closing_qtyOut = 0;
          $closing_qtyIn = 0;

          // CLOSING STOCK
          for ($i=0; $i < count($dataAfterReport[$key]->detail_sale) ; $i++) {
            if ($dataAfterReport[$key]->detail_sale[$i]->sale != null) {
              $closing_qtyOut = $closing_qtyOut + $dataAfterReport[$key]->detail_sale[$i]->qty;
            }
          }

          for ($i=0; $i < count($dataAfterReport[$key]->detail_purchase) ; $i++) {
            if ($dataAfterReport[$key]->detail_purchase[$i]->purchase != null) {
              $closing_qtyIn = $closing_qtyIn + $dataAfterReport[$key]->detail_purchase[$i]->qty;
            }
          }
          // CLOSING STOCK

          // OPENING STOCK
          for ($i=0; $i < count($item->detail_sale) ; $i++) {
            if ($item->detail_sale[$i]->sale != null) {
              $opening_qtyOut = $opening_qtyOut + $item->detail_sale[$i]->qty;
            }
          }

          for ($i=0; $i < count($item->detail_purchase) ; $i++) {
            if ($item->detail_purchase[$i]->purchase != null) {
              $opening_qtyIn = $opening_qtyIn + $item->detail_purchase[$i]->qty;
            }
          }
          // OPENING STOCK

          $closing_stok = $item->stok_unit + $closing_qtyOut - $closing_qtyIn;
          $opening_stok = $closing_stok + $opening_qtyOut - $opening_qtyIn;

          $setCell->insertNewRowBefore($x, 1)
                    ->setCellValue('A' . $x, $key+1)
                    ->setCellValue('B' . $x, $item->kode)
                    ->setCellValue('C' . $x, $item->nama)
                    ->setCellValue('D' . $x, $opening_stok)
                    ->setCellValue('E' . $x, $opening_qtyIn)
                    ->setCellValue('F' . $x, $opening_qtyOut)
                    ->setCellValue('G' . $x, $closing_stok);
        }

        return $this;
    }

    private function SM_Report_Detail_PDF($dataReport, $data)
    {
      $time = strtotime($data['awal']);
      $awal = date('d F Y', $time);
      $time = strtotime($data['akhir']);
      $akhir = date('d F Y', $time);

      $html_ = '<html>
        <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <style>
          table, tr, td {
            border: 1px inset black;
            border-collapse: collapse;
            border-spacing: 0;
          }
        </style>
        </head>
        <body>
        <div align="center">
          <h2>Stock Movement Report Detail</h2>
        </div>
        <div align="center" style="margin-top: -20px;">
          '.$awal.' - '.$akhir.'
        </div>
        <br>
          <table align="center">
            <thead>
              <tr>
                <td style="width:40px;" align="center"><b>No</b></td>
                <td style="width:80px;" align="center"><b>Kode</b></td>
                <td style="width:200px;"align="center"><b>Nama</b></td>
                <td style="width:150px;"align="center"><b>Tanggal Penjualan</b></td>
                <td style="width:100px;"align="center"><b>No Penjualan</b></td>
                <td style="width:40px;" align="center"><b>Qty</b></td>
                <td style="width:150px;"align="center"><b>Tanggal Pembelian</b></td>
                <td style="width:100px;"align="center"><b>No Pembelian</b></td>
                <td style="width:40px;" align="center"><b>Qty</b></td>
              </tr>
            </thead>
            <tbody>';

            foreach ($dataReport as $key => $item) {

              $number     = $key + 1;
              $new_line   = false;
              $total_out  = 0;
              $total_in   = 0;

              $penjualan     = [];
              for ($i=0; $i < count($item->detail_sale) ; $i++) {
                if ($item->detail_sale[$i]->sale != null) {
                  array_push($penjualan, json_decode($item->detail_sale[$i]));
                }
              }

              $pembelian     = [];
              for ($i=0; $i < count($item->detail_purchase) ; $i++) {
                if ($item->detail_purchase[$i]->purchase != null) {
                  array_push($pembelian, json_decode($item->detail_purchase[$i]));
                }
              }


              if (count($penjualan) >= count($pembelian)) {
                for ($i=0; $i < count($penjualan) ; $i++) {

                    $pem_tgl = '';
                    $pem_inv = '';
                    $pem_qty = '';
                    $total_out = $total_out + $penjualan[$i]->qty;

                    if ($i < count($pembelian)) {
                      if ($pembelian[$i]->purchase != null) {
                        $pem_tgl = $pembelian[$i]->purchase->updated_at;
                        $pem_inv = $pembelian[$i]->purchase->invoice;
                        $pem_qty = $pembelian[$i]->qty;
                        $total_in = $total_in + $pembelian[$i]->qty;
                      }
                    }

                    if ($new_line == true) {
                      $html_ .='
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td align="center">'.$penjualan[$i]->sale->updated_at.'</td>
                        <td align="center">'.$penjualan[$i]->sale->invoice.'</td>
                        <td align="center">'.$penjualan[$i]->qty.'</td>
                        <td align="center">'.$pem_tgl.'</td>
                        <td align="center">'.$pem_inv.'</td>
                        <td align="center">'.$pem_qty.'</td>
                      </tr>';
                    }
                    else {
                      $html_ .='
                      <tr>
                        <td align="center">'.$number.'</td>
                        <td align="center">'.$item->kode.'</td>
                        <td>'.$item->nama.'</td>
                        <td align="center">'.$penjualan[$i]->sale->updated_at.'</td>
                        <td align="center">'.$penjualan[$i]->sale->invoice.'</td>
                        <td align="center">'.$penjualan[$i]->qty.'</td>
                        <td align="center">'.$pem_tgl.'</td>
                        <td align="center">'.$pem_inv.'</td>
                        <td align="center">'.$pem_qty.'</td>
                      </tr>';
                      $new_line = true;
                    }
                }
              }
              else {
                for ($i=0; $i < count($pembelian) ; $i++) {

                    $pen_tgl = '';
                    $pen_inv = '';
                    $pen_qty = '';
                    $total_in = $total_in + $pembelian[$i]->qty;

                    if ($i < count($penjualan)) {
                      if ($penjualan[$i]->sale != null) {
                        $pen_tgl = $penjualan[$i]->sale->updated_at;
                        $pen_inv = $penjualan[$i]->sale->invoice;
                        $pen_qty = $penjualan[$i]->qty;
                        $total_out = $total_out + $penjualan[$i]->qty;
                      }
                    }

                    if ($new_line == true) {
                      $html_ .='
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td align="center">'.$pen_tgl.'</td>
                        <td align="center">'.$pen_inv.'</td>
                        <td align="center">'.$pen_qty.'</td>
                        <td align="center">'.$pembelian[$i]->purchase->updated_at.'</td>
                        <td align="center">'.$pembelian[$i]->purchase->invoice.'</td>
                        <td align="center">'.$pembelian[$i]->qty.'</td>
                      </tr>';
                    }
                    else {
                      $html_ .='
                      <tr>
                        <td align="center">'.$number.'</td>
                        <td align="center">'.$item->kode.'</td>
                        <td>'.$item->nama.'</td>
                        <td align="center">'.$pen_tgl.'</td>
                        <td align="center">'.$pen_inv.'</td>
                        <td align="center">'.$pen_qty.'</td>
                        <td align="center">'.$pembelian[$i]->purchase->updated_at.'</td>
                        <td align="center">'.$pembelian[$i]->purchase->invoice.'</td>
                        <td align="center">'.$pembelian[$i]->qty.'</td>
                      </tr>';
                      $new_line = true;
                    }
                }
              }

              if (count($pembelian) == 0 && count($penjualan) == 0) {
                $html_ .='
                <tr>
                  <td align="center">'.$number.'</td>
                  <td align="center">'.$item->kode.'</td>
                  <td>'.$item->nama.'</td>
                  <td align="center"></td>
                  <td align="center" style="background-color : #fff500">TOTAL</td>
                  <td align="center" style="background-color : #fff500">'.$total_out.'</td>
                  <td></td>
                  <td align="center" style="background-color : #fff500">TOTAL</td>
                  <td align="center" style="background-color : #fff500">'.$total_in.'</td>
                </tr>';
              }
              else {
                $html_ .='
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td align="center" style="background-color : #fff500">TOTAL</td>
                  <td align="center" style="background-color : #fff500">'.$total_out.'</td>
                  <td></td>
                  <td align="center" style="background-color : #fff500">TOTAL</td>
                  <td align="center" style="background-color : #fff500">'.$total_in.'</td>
                </tr>';
              }
            }

            $html_ .='
            </tbody>
          </table>
        </body>
      </html>';

      return $html_;
    }

    private function SM_Report_Detail_EXCEL ($setCell, $dataReport, $data)
    {
        $time = strtotime($data['awal']);
        $awal = date('d F Y', $time);
        $time = strtotime($data['akhir']);
        $akhir = date('d F Y', $time);

        $setCell->setCellValue('A2', ''.$awal.' - '.$akhir.'');


        $base_row  = 5;
        $total_ = [];

        foreach ($dataReport as $key => $item) {
          $row = $base_row + 1;
          $number = $key + 1;
          $setCell->setCellValue('A'. $row, $number)
                  ->setCellValue('B'. $row, $item->kode)
                  ->setCellValue('C'. $row, $item->nama);

          $child_out = $row;
          $total_out = 0;
          for ($i=0; $i < count($item->detail_sale) ; $i++) {
            if ($item->detail_sale[$i]->sale != null) {
              $setCell->setCellValue('D'. $child_out, $item->detail_sale[$i]->sale->updated_at)
                      ->setCellValue('E'. $child_out, $item->detail_sale[$i]->sale->invoice)
                      ->setCellValue('F'. $child_out, $item->detail_sale[$i]->qty);
              $total_out = $total_out + $item->detail_sale[$i]->qty;
              $child_out++;
            }
          }

          $child_in = $row;
          $total_in = 0;
          for ($i=0; $i < count($item->detail_purchase) ; $i++) {
            if ($item->detail_purchase[$i]->purchase != null) {
              $setCell->setCellValue('H'. $child_in, $item->detail_purchase[$i]->purchase->updated_at)
                      ->setCellValue('I'. $child_in, $item->detail_purchase[$i]->purchase->invoice)
                      ->setCellValue('J'. $child_in, $item->detail_purchase[$i]->qty);
              $total_in = $total_in + $item->detail_purchase[$i]->qty;
              $child_in++;
            }
          }

          if ($child_out >= $child_in) {
            $row = $child_out;
            $base_row = $row;
            $setCell->setCellValue('E'. $row, 'TOTAL')
                    ->setCellValue('F'. $row, $total_out)
                    ->setCellValue('I'. $row, 'TOTAL')
                    ->setCellValue('J'. $row, $total_in);

            array_push($total_, 'E'.$row);
            array_push($total_, 'F'.$row);
            array_push($total_, 'I'.$row);
            array_push($total_, 'J'.$row);
          }
          else {
            $row = $child_in;
            $base_row = $row;
            $setCell->setCellValue('E'. $row, 'TOTAL')
                    ->setCellValue('F'. $row, $total_out)
                    ->setCellValue('I'. $row, 'TOTAL')
                    ->setCellValue('J'. $row, $total_in);

            array_push($total_, 'E'.$row);
            array_push($total_, 'F'.$row);
            array_push($total_, 'I'.$row);
            array_push($total_, 'J'.$row);
          }
        }

        $styleArray = array(
             'borders' => array(
                 'allborders' => array(
                     'style' => \PHPExcel_Style_Border::BORDER_THIN
                 )
             ),
             'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                )
         );
        $setCell->getStyle('A5:J'.$base_row)->applyFromArray($styleArray);

        for ($i=0; $i < count($total_) ; $i++) {
          $setCell->getStyle($total_[$i])->applyFromArray(
              array(
                  'fill' => array(
                      'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                      'color' => array('rgb' => 'faff00')
                  )
              )
          )->getFont()->setBold( true );
        }

        $setCell->getStyle('A5:J5')->applyFromArray(
            array(
                'fill' => array(
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'bebebe')
                )
            )
        )->getFont()->setBold( true );

        return $this;
    }

}
