<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_item';

    protected $primaryKey = 'order_item_id';
    protected $keyType = 'int';

    protected $fillable = [
        "order_item_id",
        "order_id",
        "product_id",
        "product_title",
        "quantity",
        "price",
        "post_fee",
        "created_by",
        "updated_by",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
