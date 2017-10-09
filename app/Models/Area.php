<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'area';

    protected $primaryKey = 'id';
    protected $keyType = 'int';

    protected $fillable = [
        "id",
        "name",
        "parent_id",
        "type",
        "zip",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = false;

    protected $hidden = [];
}
