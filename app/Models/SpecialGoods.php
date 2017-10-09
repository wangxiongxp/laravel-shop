<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialGoods extends Model
{
    protected $table = 'special_goods_def';

    protected $primaryKey = 'id';
    protected $keyType = 'int';

    protected $fillable = [
        "id",
        "special_id",
        "product_id",
        "status",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
