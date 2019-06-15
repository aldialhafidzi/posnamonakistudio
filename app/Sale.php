<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class Sale extends Model
{
    use Eloquence;
    protected $table = 'sales';
    protected $searchableColumns = ['invoice', 'created_at', 'grandtotal'];
    protected $fillable = [
      'employee_id',
      'customer_id',
      'invoice',
      'created_at',
      'discount',
      'grandtotal',
      'catatan',
      'updated_at'
    ];

    public function employee()
    {
      return $this->belongsTo('App\User', 'employee_id');
    }

    public function customer()
    {
      return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function detail_sale()
    {
      return $this->hasMany('App\Detail_Sale', 'sale_id');
    }
}
