<?php

namespace App\Services;

use App\Models\Menu;
use App\Models\Role;
use App\Models\RoleMember;
use App\Models\RoleMenu;
use Illuminate\Support\Facades\DB;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class RoleService
{
    protected $roleRepository;

    public function __construct()
    {
        $this->PrimaryKey = "s_role_id";
        $this->TableName  = 's_role';
    }

    public function queryRole($arrData)
    {
        $draw       = $arrData['draw'] ;
        $keyword    = $arrData['keyword'] ;

        $length     = $arrData['length'] ;
        $start      = $arrData['start'] ;

        $query = DB::table($this->TableName);
        if(!empty($keyword)){
            $query->where('s_role_name','like', '%'.$keyword.'%');
        }

        $sum = $query->count();

        if(isset($arrData['orderBy'])){
            $arrSort = explode('.', $arrData['orderBy']);
            $query->orderBy($arrSort[0], $arrSort[1]);
        }

        if($sum > 0){
            $rows = $query->skip($start)->take($length)->get();
        }else{
            $rows = array();
        }

        //当前第几页
        $start = intval($start) + 1 ;
        if($start % $length == 0){
            $page = $start / $length ;
        }else{
            $page = $start / $length + 1 ;
        }

        $resultData = array();
        $resultData['draw']            = $draw ;
        $resultData['page']            = intval($page);//当前第几页
        $resultData['recordsTotal']    = $sum ;//总数量
        $resultData['recordsFiltered'] = $sum ;
        $resultData['items']           = $rows ;//数据

        return $resultData ;
    }

    public function getRoleById($s_role_id)
    {
        return Role::where('s_role_id', '=', $s_role_id)->first();
    }

    public function insertRole($arrData)
    {
        return Role::create($arrData);
    }

    public function updateRole($arrData)
    {
        $s_role_id = $arrData['s_role_id'];
        return Role::where('s_role_id','=',$s_role_id)->update($arrData);
    }

    public function deleteRole($s_role_id)
    {
        Role::where('s_role_id', '=', $s_role_id)->delete();
        RoleMember::where('s_role_id', '=', $s_role_id)->delete();
        RoleMenu::where('s_role_id', '=', $s_role_id)->delete();
        return true;
    }

    public function getRoleTree()
    {
        $root = Role::all();

        $arrResult = array();

        $arrSub = array();
        $opened = array();
        $opened['opened'] = true;
        foreach($root as $item)
        {
            unset($arrSub);
            $arrSub['id']    = $item->s_role_id;
            $arrSub['text']  = $item->s_role_name;
            $arrSub['state']  = $opened;
            $arrSub['children'] = [];

            $arrResult[] = $arrSub;
        }
        return $arrResult;
    }

    public function GetMenuTreeOfRole($parent_id,$s_role_id)
    {
        $arrResult = array();
        $root = RoleMenu::join('menu', 's_role_menu.menu_id', '=' ,'menu.menu_id')
            ->select('menu.*', 's_role_menu.s_role_id' )
            ->where( 's_role_menu.s_role_id', '=', $s_role_id)
            ->where('menu.menu_parent','=', $parent_id)
            ->orderBy('menu.menu_sort')
            ->get();

        $arrSub = array();
        foreach($root as $item)
        {
            unset($arrSub);
            $arrSub['id']         = $item->menu_id;
            $arrSub['title']      = $item->menu_text;
            $arrSub['icon_class'] = $item->menu_css ;
            $arrSub['url']        = $item->menu_url ;

            $hasChild = false;
            $children = $this->GetMenuTreeOfRole($item->menu_id,$s_role_id);
            if(count($children)>0){
                $hasChild  = true;
            }
            $arrSub['hasChild']   = $hasChild;
            $arrSub['children']   = $children ;
            $arrResult[] = $arrSub;
        }

        return $arrResult;
    }

    public function getCheckedMenus($s_role_id,$menu_parent)
    {
        $root = Menu::leftJoin('s_role_menu', function($join) use($s_role_id){
            $join->on('s_role_menu.menu_id', '=', 'menu.menu_id')
                ->where('s_role_menu.s_role_id','=',$s_role_id);
        })
            ->where('menu.menu_parent','=', $menu_parent)
            ->orderBy('menu.menu_sort')
            ->select('menu.*','s_role_menu.s_role_id')->get();

        foreach($root as &$item)
        {
            $item->sub = $this->getCheckedMenus($s_role_id,$item->menu_id);
        }

        return $root;
    }

    public function saveMenus($arrData)
    {
        $s_role_id = $arrData['s_role_id'];
        RoleMenu::where('s_role_id', '=', $s_role_id)->delete();

        $arrMenu = $arrData['menu_id'];

        $data = array();
        $data['s_role_id'] = $s_role_id ;
        foreach ($arrMenu as $menu_id) {
            $data['menu_id'] = $menu_id ;
            RoleMenu::create($data);
        }
    }

}