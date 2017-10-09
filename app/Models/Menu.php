<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';

    protected $primaryKey = 'menu_id';
    protected $keyType = 'int';

    protected $fillable = [
        "menu_id",
        "menu_text",
        "menu_url",
        "menu_css",
        "menu_sort",
        "menu_parent",
        "menu_leaf",
        "menu_desc",
        "created_by",
        "updated_by",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
