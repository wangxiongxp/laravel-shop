<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SMSCode extends Model
{
    protected $table = 'sms_code';

    protected $primaryKey = 'id';
    protected $keyType = 'int';

    protected $fillable = [
        "id",
        "account_tel",
        "code",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
