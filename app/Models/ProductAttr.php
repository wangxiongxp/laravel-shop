<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttr extends Model
{
    protected $table = 'product_attr';

    protected $primaryKey = 'product_attr_id';
    protected $keyType = 'string';

    protected $fillable = [
        "product_attr_id",
        "product_id",
        "attr_id",
        "attr_value",
        "option_id",
        "option_value",
        "created_by",
        "updated_by",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
