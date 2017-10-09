<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->middleware('auth');
        $this->roleService = $roleService;
    }

    public function index()
    {
        return view('admin/role/index');
    }

    public function queryRole(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $result = $this->roleService->queryRole($queryParam);
        return $this->showPageResult($result);
    }

    public function addRole(){
        return view('admin/role/addRole');
    }

    public function saveRole(Request $request)
    {
        $this->roleService->insertRole($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function editRole($s_role_id){
        $data = array();
        $role = $this->roleService->getRoleById($s_role_id);
        $data['role'] = $role ;

        return view('admin/role/editRole',$data);
    }

    public function updateRole(Request $request)
    {
        $this->roleService->updateRole($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteRole($id)
    {
        $this->roleService->deleteRole($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

    public function getRoleTree()
    {
        $model = $this->roleService->getRoleTree();
        return response()->json($model, Response::HTTP_OK);
    }

    public function selectMenus($s_role_id){
        $data  = array();
        $menus = $this->roleService->getCheckedMenus($s_role_id,0);
        $data['s_role_id'] = $s_role_id ;
        $data['menus'] = $menus ;

        return view('admin/role/selectMenus',$data);
    }

    public function saveMenus(Request $request)
    {
        $this->roleService->saveMenus($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

}
