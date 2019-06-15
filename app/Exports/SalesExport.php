<?php

namespace App\Exports;

use App\Sale;
use App\Detail_Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SalesExport implements FromQuery, WithHeadings, ShouldAutoSize
{

    use Exportable;

    public function __construct($data = [])
    {

         $this->export    = $data['printSales'];
         $this->dari      = $data['date_dari'];
         $this->sampai    = $data['date_sampai'];
         $this->customer  = $data['choose_cust'];
    }

    public function headings(): array
    {
      if ($this->export == "headerSales") {
        return [
          'Customer',
          'Invoice',
          'Tanggal Transaksi',
          'Discount',
          'Grandtotal'
        ];
      }else {
        return [
          'Customer',
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
      if ($this->export == "headerSales") {

        $customers = $this->customer;

        return Sale::where(function($query) use($customers){
          foreach ($customers as $cust) {
            $query->orWhere('customer_id', $cust);
          }
        })->join('customers', 'customers.id', '=', 'sales.customer_id')
          ->where('created_at', '>=', $this->dari)
          ->where('created_at', '<=', $this->sampai)
          ->select('customers.nama as Customer',
                   'invoice', 'created_at as Tanggal_Transaksi',
                   'sales.discount', 'grandtotal');

      } else {
        return DB::table('detail_sales')
                ->join('goods', 'goods.id', '=', 'detail_sales.good_id')
                ->join('units', 'units.id', '=', 'detail_sales.unit_id')
                ->join('sales', 'sales.id', '=', 'detail_sales.sale_id')
                ->join('customers', 'customers.id', '=', 'sales.customer_id')
                ->select('customers.nama as Customer', 'invoice as Invoice',
                         'kode', 'goods.nama as Nama Barang',
                         'detail_sales.qty as Qty',
                         'units.nama as Unit')
                ->orderBy('customers.id');
      }

    }

}
