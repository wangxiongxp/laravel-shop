<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promotion';

    protected $primaryKey = 'prom_id';
    protected $keyType = 'int';

    protected $fillable = [
        "prom_id",
        "prom_name",
        "prom_type",
        "prom_scope",
        "category_id",
        "brand_id",
        "prom_desc",
        "status",
        "start_time",
        "end_time",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
