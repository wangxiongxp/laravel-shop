<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';

    protected $primaryKey = 'order_id';
    protected $keyType = 'int';

    protected $fillable = [
        "order_id",
        "quantity",
        "total_price",
        "total_post_fee",
        "total_pay",
        "order_status",
        "paid_time",
        "paid_method",
        "buyer_id",
        "buyer_nick",
        "receiver_name",
        "receiver_province",
        "receiver_city",
        "receiver_dist",
        "receiver_street",
        "receiver_full_address",
        "receiver_zip",
        "receiver_phone",
        "seller_id",
        "seller_nick",
        "created_by",
        "updated_by",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
