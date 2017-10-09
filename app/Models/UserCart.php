<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCart extends Model
{
    protected $table = 'user_cart';

    protected $primaryKey = 'cart_id';
    protected $keyType = 'int';

    protected $fillable = [
        "cart_id",
        "account_id",
        "product_id",
        "quantity",
        "price",
        "title",
        "created_by",
        "updated_by",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
