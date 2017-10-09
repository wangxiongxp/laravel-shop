<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCat extends Model
{
    protected $table = 'product_category';

    protected $primaryKey = 'cat_id';
    protected $keyType = 'int';

    protected $fillable = [
        "cat_id",
        "cat_title",
        "cat_image",
        "cat_parent",
        "cat_level",
        "cat_leaf",
        "is_show",
        "cat_sort",
        "created_by",
        "updated_by",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
