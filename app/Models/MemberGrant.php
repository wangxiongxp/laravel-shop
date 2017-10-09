<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberGrant extends Model
{
    protected $table = 's_member_grant';

    protected $primaryKey = 'account_id';
    protected $keyType = 'int';

    protected $fillable = [
        "account_id",
        "s_group_id",
        "created_by",
        "updated_by",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
