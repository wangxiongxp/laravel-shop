<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MenuService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->middleware('auth');
        $this->menuService = $menuService;
    }

    public function index()
    {
        $data = array();
        $data['menus'] = $this->menuService->GetMenuTree(0);
        return view('admin/menu/index',$data);
    }

    public function getFirstMenu()
    {
        $result = $this->menuService->getFirstMenu();
        return $this->showJsonResult(true, '查询成功', $result);
    }

    public function addMenu(){
        return view('admin/menu/addMenu');
    }

    public function saveMenu(Request $request)
    {
        $this->menuService->insertMenu($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function editMenu($menu_id){
        $data = array();
        $menu = $this->menuService->getMenuById($menu_id);
        $data['menu'] = $menu ;
        return view('admin/menu/editMenu',$data);
    }

    public function updateMenu(Request $request)
    {
        $this->menuService->updateMenu($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteMenu($id)
    {
        $this->menuService->deleteMenu($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

}
