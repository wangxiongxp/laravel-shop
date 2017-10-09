<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AwardReward extends Model
{
    protected $table = 'award_reward';

    protected $primaryKey = 'id';
    protected $keyType = 'int';

    protected $fillable = [
        "id",
        "award_id",
        "level",
        "name",
        "type",
        "point",
        "point_num",
        "coupon_id",
        "coupon_num",
        "present_id",
        "present_num",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
