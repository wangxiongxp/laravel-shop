<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'user_address';

    protected $primaryKey = 'address_id';
    protected $keyType = 'int';

    protected $fillable = [
        "address_id",
        "account_id",
        "receiver_name",
        "receiver_province",
        "receiver_city",
        "receiver_dist",
        "receiver_street",
        "receiver_full_address",
        "receiver_zip",
        "receiver_phone",
        "is_default",
        "created_by",
        "updated_by",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
