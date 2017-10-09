<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GroupService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GroupController extends Controller
{
    protected $groupService;

    public function __construct(GroupService $groupService)
    {
        $this->middleware('auth');
        $this->groupService = $groupService;
    }

    public function index()
    {
        return view('admin/group/index');
    }

    public function getGroupById($id)
    {
        $group = $this->groupService->getGroupById($id);
        return $this->showJsonResult(true, '查询成功', $group);
    }

    public function addGroup(Request $request){
        $data = array();
        $data['s_group_parent'] = $request['s_group_id'] ;
        $data['s_group_parent_name'] = $request['s_group_name'] ;
        return view('admin/group/addGroup',$data);
    }

    public function saveGroup(Request $request)
    {
        $this->groupService->insertGroup($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function editGroup($s_group_id){
        $data = array();
        $group = $this->groupService->getGroupById($s_group_id);
        $data['group'] = $group ;

        return view('admin/group/editGroup',$data);
    }

    public function updateGroup(Request $request)
    {
        $this->groupService->updateGroup($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteGroup($id)
    {
        $this->groupService->deleteGroup($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

    public function getGroupTree()
    {
        $model = $this->groupService->getGroupTree(0);
        return response()->json($model, Response::HTTP_OK);
    }



}
