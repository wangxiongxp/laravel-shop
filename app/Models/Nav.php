<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nav extends Model
{
    protected $table = 'navigation';

    protected $primaryKey = 'nav_id';
    protected $keyType = 'int';

    protected $fillable = [
        "nav_id",
        "nav_title",
        "parent_id",
        "nav_path",
        "nav_type",
        "nav_leaf",
        "nav_status",
        "nav_sort",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
