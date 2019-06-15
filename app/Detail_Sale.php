<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail_Sale extends Model
{
    protected $table = 'detail_sales';

    public function sale()
    {
      return $this->belongsTo('App\Sale', 'sale_id');
    }

    public function good()
    {
      return $this->belongsTo('App\Good', 'good_id');
    }

    public function unit()
    {
      return $this->belongsTo('App\Unit', 'unit_id');
    }

}
