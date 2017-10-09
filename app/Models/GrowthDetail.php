<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrowthDetail extends Model
{
    protected $table = 'user_level_detail';

    protected $primaryKey = 'id';
    protected $keyType = 'int';

    protected $fillable = [
        "id",
        "user_id",
        "growth",
        "order_id",
        "remark",
        "created_by",
        "updated_by",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
