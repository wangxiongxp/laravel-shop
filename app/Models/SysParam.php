<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysParam extends Model
{
    protected $table = 'sys_param';

    protected $primaryKey = 'param_id';
    protected $keyType = 'int';

    protected $fillable = [
        "param_id",
        "param_code",
        "param_desc",
        "param_cat",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
