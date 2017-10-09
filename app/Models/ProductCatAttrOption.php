<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCatAttrOption extends Model
{
    protected $table = 'product_category_attr_option';

    protected $primaryKey = 'option_id';
    protected $keyType = 'int';

    protected $fillable = [
        "option_id",
        "option_name",
        "cat_id",
        "attr_id",
        "option_sort",
        "created_by",
        "updated_by",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
