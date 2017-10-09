<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupType extends Model
{
    protected $table = 's_group_type';

    protected $primaryKey = 's_group_type_id';
    protected $keyType = 'int';

    protected $fillable = [
        "s_group_type_id",
        "s_group_type_name",
        "created_by",
        "updated_by",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
