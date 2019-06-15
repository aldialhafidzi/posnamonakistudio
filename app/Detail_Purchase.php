<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail_Purchase extends Model
{
    protected $table = 'detail_purchases';

    public function purchase()
    {
      return $this->belongsTo('App\Purchase', 'purchase_id');
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
