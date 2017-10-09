<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RoleMemberService;
use Illuminate\Http\Request;

class RoleMemberController extends Controller
{
    protected $roleMemberService;

    public function __construct(RoleMemberService $roleMemberService)
    {
        $this->middleware('auth');
        $this->roleMemberService = $roleMemberService;
    }

    public function index()
    {
        return view('admin/roleMember/index');
    }

    public function queryRoleMember(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        if(isset($request['s_role_id'])){
            $queryParam['s_role_id'] = $request['s_role_id'] ;
        }
        $result = $this->roleMemberService->queryRoleMember($queryParam);
        return $this->showPageResult($result);
    }

    public function addRoleMember(){
        return view('admin/roleMember/selectAccount');
    }

    public function saveRoleMember(Request $request)
    {
        $this->roleMemberService->insertRoleMember($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function deleteRoleMember($s_role_id,$account_id)
    {
        $this->roleMemberService->deleteRoleMember($s_role_id, $account_id);
        return $this->showJsonResult(true, '删除成功', null);
    }


}
