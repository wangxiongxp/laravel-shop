<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'page';

    protected $primaryKey = 'page_id';
    protected $keyType = 'int';

    protected $fillable = [
        "page_id",
        "page_url",
        "page_name",
        "page_summary",
        "page_content",
        "status",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
