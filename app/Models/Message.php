<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'message';

    protected $primaryKey = 'msg_id';
    protected $keyType = 'int';

    protected $fillable = [
        "msg_id",
        "parent_id",
        "send_id",
        "receive_id",
        "send_time",
        "receive_time",
        "msg_title",
        "msg_detail",
        "has_read",
        "has_replay",
        "replay_time",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = false;

    protected $hidden = [];
}
