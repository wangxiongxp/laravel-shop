<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'cms_article';

    protected $primaryKey = 'id';
    protected $keyType = 'int';

    protected $fillable = [
        "id",
        "catalog_id",
        "title",
        "sub_title",
        "summary",
        "content",
        "logo",
        "keyword",
        "tags",
        "source",
        "type",
        "status",
        "allow_comment",
        "is_top",
        "hit_count",
        "comment_count",
        "close_time",
        "publish_time",
        "created_by",
        "updated_by",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
