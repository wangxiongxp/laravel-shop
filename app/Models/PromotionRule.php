<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionRule extends Model
{
    protected $table = 'promotion_rule';

    protected $primaryKey = 'rule_id';
    protected $keyType = 'int';

    protected $fillable = [
        "rule_id",
        "prom_id",
        "coupon_id",
        "min_price",
        "min_num",
        "minus",
        "discount",
        "free_ship",
        "is_gift",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
