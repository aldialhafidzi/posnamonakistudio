<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class Good extends Model
{
  use Eloquence;
  protected $table = 'goods';
  protected $searchableColumns = ['nama', 'kode', 'stok_unit'];
  protected $fillable = [
    'kategori_id',
    'merek_id',
    'cbo',
    'kode',
    'nama',
    'stok_unit',
    'unit_awal',
    'min_qty',
    'unit_beli',
    'unit_jual',
    'h_beli',
    'h_jual',
    'updated_at'
  ];

  public function kategori()
  {
      return $this->belongsTo("App\Category", "kategori_id");
  }

  public function merek()
  {
      return $this->belongsTo("App\Brand", "merek_id");
  }

  public function unit()
  {
      return $this->belongsTo("App\Unit", "unit_awal");
  }

  public function detail_unit()
  {
    return $this->hasMany("App\Detail_Unit", "good_id");
  }

  public function combo()
  {
    return $this->hasMany("App\Combo", "combos_id");
  }

  public function detail_sale()
  {
    return $this->hasMany('App\Detail_Sale', 'good_id');
  }

  public function detail_purchase()
  {
    return $this->hasMany('App\Detail_Purchase', 'good_id');
  }

}
