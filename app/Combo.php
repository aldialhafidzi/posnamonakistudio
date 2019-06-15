<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
class Combo extends Model
{
    use Eloquence;
    protected $table = 'combos';
    protected $fillable = [
      'combos_id',
      'good_id',
      'qty',
      'unit_id'
    ];

    public function good()
    {
      return $this->belongsTo("App\Good", "combos_id");
    }

    public function unit()
    {
      return $this->belongsTo('App\Unit', 'unit_id');
    }

    public function detail_unit()
    {
      return $this->morphToMany('App\Detail_Unit', 'comboToDetailUnit');
    }

    public function comboToGood()
    {
      return $this->belongsTo("App\Good", "good_id");
    }


}
