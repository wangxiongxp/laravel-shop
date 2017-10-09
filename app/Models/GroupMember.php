<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    protected $table = 's_group_member';

    protected $primaryKey = 's_group_id' ;
    protected $keyType = 'int';

    protected $fillable = [
        "s_group_id",
        "account_id",
        "created_by",
        "updated_by",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
