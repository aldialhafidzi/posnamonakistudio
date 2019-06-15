<?php

namespace App\Exports;

use App\Purchase;
use App\Detail_Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PurchasesExport implements FromQuery, WithHeadings, ShouldAutoSize
{

  use Exportable;

  public function __construct($data = [])
  {

       $this->export    = $data['printPurchases'];
       $this->dari      = $data['date_dari_purchases'];
       $this->sampai    = $data['date_sampai_purchases'];
       $this->suppliers  = $data['choose_supp'];
  }

  public function headings(): array
  {
    if ($this->export == "headerPurchases") {
      return [
        'Supplier',
        'Invoice',
        'Tanggal Transaksi',
        'Discount',
        'Grandtotal'
      ];
    }else {
      return [
        'Supplier',
        'Invoice',
        'Nama Barang',
        'Kode Barang',
        'Qty',
        'Unit',
      ];
    }
  }

  public function query()
  {
    if ($this->export == "headerPurchases") {

      $suppliers = $this->suppliers;

      return Purchase::where(function($query) use($suppliers){
        foreach ($suppliers as $sup) {
          $query->orWhere('supplier_id', $sup);
        }
      })->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
        ->where('created_at', '>=', $this->dari)
        ->where('created_at', '<=', $this->sampai)
        ->select('suppliers.nama as Supplier',
                 'invoice', 'created_at as Tanggal_Transaksi',
                 'purchases.discount', 'grandtotal');

    } else {

      return DB::table('detail_purchases')
              ->join('goods', 'goods.id', '=', 'detail_purchases.good_id')
              ->join('units', 'units.id', '=', 'detail_purchases.unit_id')
              ->join('purchases', 'purchases.id', '=', 'detail_purchases.purchase_id')
              ->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
              ->select('suppliers.nama as Supplier', 'invoice as Invoice',
                       'kode', 'goods.nama as Nama Barang',
                       'detail_purchases.qty as Qty',
                       'units.nama as Unit')
              ->orderBy('suppliers.id');
    }

  }

}
