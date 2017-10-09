<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Growth extends Model
{
    protected $table = 'user_level';

    protected $primaryKey = 'id';
    protected $keyType = 'int';

    protected $fillable = [
        "id",
        "name",
        "remark",
        "image",
        "min_growth",
        "max_growth",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
