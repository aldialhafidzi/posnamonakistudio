<?php

namespace App\Exports;

use App\Good;
use Maatwebsite\Excel\Concerns\FromCollection;

class CombosExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Good::where('cbo', 'Y')->get();
    }
}
