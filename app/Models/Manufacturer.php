<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $table = 'manufacturers';

     protected $fillable = [
         'name_ar',
         'name_en',
         'facebook',
         'twitter',
         'website',
         'address',       // getting it automatically like lat and lng if key is activated
         'contact_name',
         'mobile',
         'email',
         'lat',
         'lng',
         'icon'
     ];




}
