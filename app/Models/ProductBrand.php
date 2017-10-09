<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{

    protected $table = 'product_brand';

    protected $primaryKey = 'brand_id';
    protected $keyType = 'int';

    protected $fillable = [
        "brand_id",
        "brand_name",
        "brand_code",
        "brand_sort",
        "brand_desc",
        "brand_logo",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
