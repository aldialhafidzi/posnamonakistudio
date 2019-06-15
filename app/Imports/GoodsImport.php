<?php

namespace App\Imports;

use App\Good;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMappedCells;

class GoodsImport implements ToModel, WithMappedCells, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        if (!isset($row[0])) {
            return null;
        }

        return new Good([
         'no'           => $row['no'],
         'code'         => $row['code'],
         'combo'         => $row['combo'],
         'deskripsi'    => $row['deskripsi'],
         'stok_awal'    => $row['stok_awal'],
         'unit'         => $row['unit'],
         'min_qty'      => $row['min_qty'],
         'harga_beli'   => $row['harga_beli'],
         'harga_jual'   => $row['harga_jual'],
        ]);
    }

    public function mapping(): array
    {
        return [
            'no'          => 'B3',
            'code'        => 'C3',
            'combo'        => 'D3',
            'deskripsi'   => 'E3',
            'stok_awal'   => 'F3',
            'unit'        => 'G3',
            'min_qty'     => 'H3',
            'harga_beli'  => 'I3',
            'harga_jual'  => 'J3',
        ];
    }

    public function headingRow(): int
    {
        return 3;
    }
}
