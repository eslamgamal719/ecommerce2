<?php

namespace App\Models;

use App\File;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';

    protected $fillable = [
        'title',
        'content',
        'photo',
        'stock',
        'price',
        'status',
        'reason',
        'start_at',
        'end_at',
        'price_offer',
        'start_offer_at',
        'end_offer_at',
        'department_id',
        'trade_id',
        'manu_id',
        'color_id',
        'size_id',
        'size',
        'weight',
        'weight_id',
        'currency_id'
    ];


    public function files() {
        return $this->hasMany(File::class, 'relation_id', 'id')->where('file_type', 'product');
    }

    public function other_data() {
        return $this->hasMany(OtherData::class, 'product_id', 'id');
    }

    public function malls() {
        return $this->belongsToMany(Mall::class, 'mall_products');
    }

    public function otherData() {
        return $this->hasMany(OtherData::class, 'product_id');
    }

    public function related() {
        return $this->hasMany(RelatedProduct::class, 'product_id');
    }
}
