<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupon';

    protected $primaryKey = 'coupon_id';
    protected $keyType = 'int';

    protected $fillable = [
        "coupon_id",
        "coupon_name",
        "coupon_type",
        "coupon_scope",
        "category_id",
        "brand_id",
        "coupon_face_value",
        "coupon_face_value_to",
        "coupon_face_value_random",
        "coupon_max_value",
        "coupon_send_num",
        "coupon_receive_num",
        "coupon_start_date",
        "coupon_end_date",
        "coupon_is_spec",
        "coupon_desc",
        "coupon_status",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
