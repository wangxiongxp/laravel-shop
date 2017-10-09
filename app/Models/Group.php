<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 's_group';

    protected $primaryKey = 's_group_id';
    protected $keyType = 'int';

    protected $fillable = [
        "s_group_id",
        "s_group_name",
        "s_group_desc",
        "s_group_type_id",
        "s_group_left",
        "s_group_right",
        "s_group_parent",
        "s_group_level",
        "s_group_leaf",
        "created_by",
        "updated_by",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
