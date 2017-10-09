<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table = 'topic';

    protected $primaryKey = 'topic_id';
    protected $keyType = 'int';

    protected $fillable = [
        "topic_id",
        "topic_title",
        "topic_summary",
        "topic_image",
        "topic_desc",
        "topic_status",
        "created_by",
        "updated_by",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
