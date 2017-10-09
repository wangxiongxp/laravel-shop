<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $table = 'shipping';

    protected $primaryKey = 'shipping_id';
    protected $keyType = 'int';

    protected $fillable = [
        "shipping_id",
        "shipping_name",
        "delivery_time",
        "is_free",
        "company_id",
        "valuation",
        "first_pcs",
        "first_weight",
        "first_pcs_price",
        "first_weight_price",
        "last_pcs",
        "last_weight",
        "last_pcs_price",
        "last_weight_price",
        "shipping_desc",
        "shipping_sort",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
