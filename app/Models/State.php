<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'states';

     protected $fillable = [
         'state_name_ar',
         'state_name_en',
         'country_id',
         'city_id'
     ];

    public function country_id() {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function city_id() {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
