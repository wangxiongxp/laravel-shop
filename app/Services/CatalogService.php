<?php

namespace App\Services;

use App\Models\Catalog;

/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class CatalogService
{
    public function __construct()
    {
        $this->PrimaryKey = "id";
        $this->TableName  = 'cms_catalog';
    }

    public function getCatalogById($id)
    {
        return Catalog::where('id', '=', $id)->first();
    }

    public function getCatalogByParent($parent_id)
    {
        return Catalog::where('parent_id', '=', $parent_id)->orderBy('sort')->get();
    }

    public function insertCatalog($arrData)
    {
        $arrData['is_leaf'] = 1;
        Catalog::create($arrData);
        if($arrData['parent_id'] != 0){
            Catalog::where('id','=',$arrData['parent_id'])->update([ 'is_leaf' => 0 ]);
        }
        return true ;
    }

    public function updateCatalog($arrData)
    {
        return Catalog::where('id','=',$arrData['id'])->update($arrData);
    }

    public function deleteCatalog($id)
    {
        $catalog = Catalog::where('id', '=', $id)->first();
        Catalog::where('id', '=', $id)->delete();
        $catalogs = Catalog::where('parent_id', '=', $catalog->parent_id)->get();
        if(count($catalogs)<1){
            Catalog::where('id','=',$catalog->parent_id)->update([ 'is_leaf' => 1 ]);
        }
        return true;
    }

    public function getCatalogTree($parent_id)
    {
        $root = Catalog::where('parent_id', '=', $parent_id)->orderBy('sort')->get();

        if(count($root)>0){
            foreach($root as &$item)
            {
                $item->sub = $this->GetCatalogTree($item->id);
            }
        }
        return $root;
    }


}