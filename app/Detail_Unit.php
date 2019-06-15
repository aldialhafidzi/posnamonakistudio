<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail_Unit extends Model
{
    protected $table = 'detail_units';


    public function good()
    {
      return $this->belongsTo("App\Good", "id");
    }

    public function unit()
    {
      return $this->belongsTo("App\Unit", "unit_id");
    }

    public function combo()
    {
      return $this->morphedByMany('App\Combo', 'comboToDetailUnit');
    }
}
