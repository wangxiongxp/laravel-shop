<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    protected $primaryKey = 'product_id';
    protected $keyType = 'int';

    protected $fillable = [
        "product_id",
        "product_cat_id",
        "brand_id",
        "product_spu",
        "product_title",
        "product_sub_title",
        "product_ori_price",
        "product_price",
        "product_qty",
        "product_desc",
        "product_status",
        "product_image",
        "view_count",
        "sold_count",
        "created_by",
        "updated_by",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
