<?php

namespace App\Services;

use App\Models\ProductCatAttrOption;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class ProductCatAttrOptionService
{
    public function __construct()
    {
        $this->PrimaryKey = "option_id";
        $this->TableName  = 'product_category_attr_option';
    }

    public function getProductCatAttrOptionByAttrId($attr_id)
    {
        return ProductCatAttrOption::where('attr_id', '=', $attr_id)->orderBy('option_sort')->get();
    }

    public function insertCategoryAttrOption($arrData)
    {
        return ProductCatAttrOption::create($arrData);
    }

    public function getCategoryAttrOptionById($option_id)
    {
        return ProductCatAttrOption::where('option_id', '=', $option_id)->first();
    }

    public function updateCategoryAttrOption($arrData)
    {
        $option_id = $arrData['option_id'];
        return ProductCatAttrOption::where('option_id','=',$option_id)->update($arrData);
    }

    public function deleteCategoryAttrOption($option_id)
    {
        return ProductCatAttrOption::where('option_id', '=', $option_id)->delete();
    }

}