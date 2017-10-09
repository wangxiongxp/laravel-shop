<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 's_role';

    protected $primaryKey = 's_role_id';
    protected $keyType = 'int';

    protected $fillable = [
        "s_role_id",
        "s_role_name",
        "s_role_desc",
        "s_role_sort",
        "created_by",
        "updated_by",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
