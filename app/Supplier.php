<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';

    public function purchase()
    {
      return $this->hasMany('App\Purchase', 'supplier_id');
    }
}
