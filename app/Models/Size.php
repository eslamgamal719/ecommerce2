<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{

    protected $table = 'sizes';

    protected $fillable = [
        'name_ar',
        'name_en',
        'department_id',
        'is_public'
    ];

    public function department_id() {
       return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
