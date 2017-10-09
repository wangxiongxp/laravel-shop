<?php

namespace App\Services;

use App\Models\Nav;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class NavigationService
{
    public function __construct()
    {
        $this->PrimaryKey = "nav_id";
        $this->TableName  = 'navigation';
    }

    public function getNavigationTree($parent_id)
    {
        $root = Nav::where('parent_id', '=', $parent_id)->orderBy('nav_sort')->get();

        if(count($root)>0){
            foreach($root as &$item)
            {
                $item->sub = $this->getNavigationTree($item->nav_id);
            }
        }
        return $root;
    }

    public function getNavigationById($nav_id)
    {
        return Nav::where('nav_id', '=', $nav_id)->first();
    }

    public function insertNavigation($arrData)
    {
        $arrData['nav_leaf'] = 1;
        Nav::create($arrData);
        if($arrData['parent_id'] != 0){
            Nav::where('nav_id','=',$arrData['parent_id'])->update(['nav_leaf'=>0]);
        }
        return true ;
    }

    public function updateNavigation($arrData)
    {
        $nav_id = $arrData['nav_id'];
        return Nav::where('nav_id','=',$nav_id)->update($arrData);
    }

    public function deleteNavigation($nav_id)
    {
        $nav = Nav::where('nav_id', '=', $nav_id)->first();
        Nav::where('nav_id', '=', $nav_id)->delete();
        Nav::where('parent_id', '=', $nav_id)->delete();

        $navs = Nav::where('parent_id', '=', $nav->parent_id)->get();
        if(count($navs)<1){
            Nav::where('nav_id','=',$nav->parent_id)->update(['nav_leaf'=>1]);
        }
        return true;
    }

    public function getFirstNavigation()
    {
        return Nav::where('parent_id', '=', 0)->get();
    }

}