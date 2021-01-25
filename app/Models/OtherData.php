<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherData extends Model
{
    protected $table = 'other_data';

    protected $fillable = [
        'data_key',
        'data_value',
        'product_id',
    ];
}
