<?php

namespace App\Services;

use App\Models\ProductCat;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class ProductCatService
{
    public function __construct()
    {
        $this->PrimaryKey = "cat_id";
        $this->TableName  = 'product_category';
    }

    public function GetCategoryTree($cat_parent)
    {
        $root = ProductCat::where('cat_parent', '=', $cat_parent)->orderBy('cat_sort')->get();

        if(count($root)>0){
            foreach($root as &$item)
            {
                $item->sub = $this->GetCategoryTree($item->cat_id);
            }
        }
        return $root;
    }

    public function getFirstCategory()
    {
        return ProductCat::where('cat_parent', '=', 0)->orderBy('cat_sort')->get();
    }

    public function getCatalogByParent($parent_id)
    {
        return ProductCat::where('cat_parent', '=', $parent_id)->orderBy('cat_sort')->get();
    }

    public function insertCategory($arrData)
    {
        $arrData['cat_leaf'] = 1;
        ProductCat::create($arrData);
        if($arrData['cat_parent'] != 0){
            ProductCat::where('cat_id','=',$arrData['cat_parent'])->update(['cat_leaf'=>0]);
        }
        return true;
    }

    public function getCategoryById($cat_id)
    {
        return ProductCat::where('cat_id', '=', $cat_id)->first();
    }

    public function updateCategory($arrData)
    {
        $cat_id = $arrData['cat_id'];
        return ProductCat::where('cat_id','=',$cat_id)->update($arrData);
    }

    public function deleteCategory($cat_id)
    {
        $cat = ProductCat::where('cat_id', '=', $cat_id)->first();
        ProductCat::where('cat_id', '=', $cat_id)->delete();
        ProductCat::where('cat_parent', '=', $cat_id)->delete();

        $cats = ProductCat::where('cat_parent', '=', $cat->cat_parent)->get();
        if(count($cats)<1){
            ProductCat::where('cat_id','=',$cat->cat_parent)->update(['cat_leaf'=>1]);
        }
        return true;
    }

}