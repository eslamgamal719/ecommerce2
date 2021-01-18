<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{

    protected $table = 'colors';

    protected $fillable = [
        'name_ar',
        'name_en',
        'color'
    ];
}
