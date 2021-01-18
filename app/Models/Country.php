<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';

     protected $fillable = [
         'country_name_ar',
         'country_name_en',
         'mob',
         'code',
         'currency',
         'logo',
     ];

     public function cities() {
         return $this->hasMany(City::class);
     }

}
