<?php

namespace App\Services;

use App\Models\Menu;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class MenuService
{
    public function __construct()
    {
        $this->PrimaryKey = "menu_id";
        $this->TableName  = 'menu';
    }

    public function getMenuById($menu_id)
    {
        return Menu::where('menu_id', '=', $menu_id)->first();
    }

    public function getFirstMenu()
    {
        return Menu::where('menu_parent', '=', 0)->get();
    }

    public function insertMenu($arrData)
    {
        $arrData['menu_leaf'] = 1;
        Menu::create($arrData);
        if($arrData['menu_parent'] != 0){
            Menu::where('menu_id','=',$arrData['menu_parent'])->update(['menu_leaf'=>0]);
        }
        return true ;
    }

    public function updateMenu($arrData)
    {
        $menu_id = $arrData['menu_id'];
        return Menu::where('menu_id','=',$menu_id)->update($arrData);
    }

    public function deleteMenu($menu_id)
    {
        $menu = Menu::where('menu_id', '=', $menu_id)->first();
        Menu::where('menu_id', '=', $menu_id)->delete();
        Menu::where('menu_parent', '=', $menu_id)->delete();

        $menus = Menu::where('menu_parent', '=', $menu->menu_parent)->get();
        if(count($menus)<1){
            Menu::where('menu_id','=',$menu->menu_parent)->update(['menu_leaf'=>1]);
        }
        return true;
    }

    public function GetMenuTree($menu_parent)
    {
        $root = Menu::where('menu_parent', '=', $menu_parent)->orderBy('menu_sort')->get();

        if(count($root)>0){
            foreach($root as &$item)
            {
                $item->sub = $this->GetMenuTree($item->menu_id);
            }
        }
        return $root;
    }


}