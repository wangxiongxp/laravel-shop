<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $table = 'log_login';

    protected $primaryKey = 'log_id';
    protected $keyType = 'int';

    protected $fillable = [
        "log_id",
        "account_id",
        "login_time",
        "login_ip",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
