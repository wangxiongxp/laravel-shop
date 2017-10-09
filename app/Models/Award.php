<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    protected $table = 'award';

    protected $primaryKey = 'award_id';
    protected $keyType = 'int';

    protected $fillable = [
        "award_id",
        "award_type",
        "award_name",
        "award_desc",
        "start_time",
        "end_time",
        "cost_point",
        "give_point",
        "give_point_to_loser",
        "time_limit",
        "probability",
        "failed_desc",
        "status",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
