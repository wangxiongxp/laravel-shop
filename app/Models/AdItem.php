<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdItem extends Model
{
    protected $table = 'ad_item';

    protected $primaryKey = 'ad_item_id';
    protected $keyType = 'int';

    protected $fillable = [
        "ad_item_id",
        "ad_item_title",
        "ad_item_path",
        "ad_item_href",
        "ad_item_type",
        "ad_item_desc",
        "ad_item_sort",
        "ad_id",
        "created_by",
        "updated_by",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
