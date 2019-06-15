<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'units';

    public function detail_unit()
    {
      return $this->hasMany('App\Detail_Unit', "unit_id");
    }

    public function combo()
    {
      return $this->hasMany('App\Combo', 'unit_id');
    }

    public function good_unit_awal()
    {
      return $this->hasMany('App\Good', 'unit_awal');
    }
}
