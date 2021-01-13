<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mall extends Model
{
    protected $table = 'malls';

    protected $fillable = [
        'name_ar',
        'name_en',
        'facebook',
        'twitter',
        'website',
        'address',
        'contact_name',
        'mobile',
        'email',
        'lat',
        'lng',
        'icon',
        'country_id'
    ];


    public function country_id() {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
