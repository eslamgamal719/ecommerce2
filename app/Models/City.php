<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

     protected $fillable = [
         'city_name_ar',
         'city_name_en',
         'country_id'
     ];

    public function country_id() {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
