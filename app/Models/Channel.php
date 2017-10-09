<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $table = 'channel';

    protected $primaryKey = 'channel_id';
    protected $keyType = 'int';

    protected $fillable = [
        "channel_id",
        "channel_title",
        "channel_summary",
        "channel_status",
        "category_id",
        "channel_sort",
        "created_by",
        "updated_by",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
