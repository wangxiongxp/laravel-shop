<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_image';

    protected $primaryKey = 'image_id';
    protected $keyType = 'int';

    protected $fillable = [
        "image_id",
        "image_title",
        "image_url",
        "product_id",
        "is_major",
        "created_by",
        "updated_by",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
