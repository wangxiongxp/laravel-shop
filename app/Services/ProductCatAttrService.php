<?php

namespace App\Services;

use App\Models\ProductCatAttr;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class ProductCatAttrService
{
    public function __construct()
    {
        $this->PrimaryKey = "attr_id";
        $this->TableName  = 'product_category_attr';
    }

    public function getProductCatAttrByCatId($cat_id)
    {
        return ProductCatAttr::where('cat_id', '=', $cat_id)->orderBy('attr_sort')->get();
    }

    public function insertCategoryAttr($arrData)
    {
        return ProductCatAttr::create($arrData);
    }

    public function getCategoryAttrById($attr_id)
    {
        return ProductCatAttr::where('attr_id', '=', $attr_id)->first();
    }

    public function updateCategoryAttr($arrData)
    {
        $attr_id = $arrData['attr_id'];
        return ProductCatAttr::where('attr_id','=',$attr_id)->update($arrData);
    }

    public function deleteCategoryAttrByAttrId($attr_id)
    {
        return ProductCatAttr::where('attr_id', '=', $attr_id)->delete();
    }

    public function deleteCategoryAttrByCatId($cat_id)
    {
        return ProductCatAttr::where('cat_id', '=', $cat_id)->delete();
    }

}