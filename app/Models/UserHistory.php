<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model
{
    protected $table = 'user_history';

    protected $primaryKey = 'history_id';
    protected $keyType = 'int';

    protected $fillable = [
        "history_id",
        "account_id",
        "seller_id",
        "product_id",
        "product_title",
        "price",
        "created_by",
        "updated_by",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
