<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FriendLink extends Model
{
    protected $table = 'friend_link';

    protected $primaryKey = 'link_id';
    protected $keyType = 'int';

    protected $fillable = [
        "link_id",
        "link_title",
        "link_image",
        "link_href",
        "link_desc",
        "link_sort",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
