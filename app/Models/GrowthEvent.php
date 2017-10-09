<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrowthEvent extends Model
{
    protected $table = 'user_level_event';

    protected $primaryKey = 'id';
    protected $keyType = 'int';

    protected $fillable = [
        "id",
        "name",
        "code",
        "remark",
        "growth",
        "start_time",
        "end_time",
        "status",
        "created_by",
        "updated_by",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
