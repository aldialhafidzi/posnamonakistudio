<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'purchases';
    protected $fillable = [
      'employee_id',
      'supplier_id',
      'invoice',
      'created_at',
      'discount',
      'grandtotal',
      'catatan',
      'updated_at'
    ];

    public function supplier()
    {
      return $this->belongsTo('App\Supplier', 'supplier_id');
    }

    public function admin()
    {
      return $this->belongsTo('App\User', 'employee_id');
    }

    public function detail_purchase()
    {
      return $this->hasMany('App\Detail_Purchase', 'purchase_id');
    }

}
