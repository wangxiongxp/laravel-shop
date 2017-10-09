<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCatAttr extends Model
{
    protected $table = 'product_category_attr';

    protected $primaryKey = 'attr_id';
    protected $keyType = 'int';

    protected $fillable = [
        "attr_id",
        "attr_name",
        "attr_type",
        "is_required",
        "is_sale_attr",
        "cat_id",
        "attr_sort",
        "created_by",
        "updated_by",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
