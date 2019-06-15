<?php

namespace App\Imports;

use App\Combo;
use Maatwebsite\Excel\Concerns\ToModel;

class CombosImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Combo([
            //
        ]);
    }
}
