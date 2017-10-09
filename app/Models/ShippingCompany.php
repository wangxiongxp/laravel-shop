<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingCompany extends Model
{
    protected $table = 'shipping_company';

    protected $primaryKey = 'company_id';
    protected $keyType = 'int';

    protected $fillable = [
        "company_id",
        "company_image",
        "company_name",
        "company_sort",
    ];

    //时间戳，created_at, updated_at保证数据库表中有该字段
    public $timestamps = true;

    protected $hidden = [];
}
