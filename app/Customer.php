<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class Customer extends Model
{
   use Eloquence;
   protected $table = 'customers';
   protected $searchableColumns = ['nama', 'alamat', 'no_telp'];
   protected $fillable = [
     'nama',
     'alamat',
     'no_telp',
     'tanggal'
   ];

   public function sale()
   {
     return $this->hasMany('App\Sale', 'customer_id');
   }
}
