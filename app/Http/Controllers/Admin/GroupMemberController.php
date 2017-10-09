<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GroupMemberService;
use App\Services\MemberGrantService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GroupMemberController extends Controller
{
    protected $groupMemberService;

    public function __construct(GroupMemberService $groupMemberService)
    {
        $this->middleware('auth');
        $this->groupMemberService = $groupMemberService;
    }

    public function index()
    {
        return view('admin/groupMember/index');
    }

    public function queryGroupMember(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $result = $this->groupMemberService->queryGroupMember($queryParam);
        return $this->showPageResult($result);
    }

    public function addGroupMember(){
        return view('admin/groupMember/selectAccount');
    }

    public function saveGroupMember(Request $request)
    {
        $this->groupMemberService->insertGroupMember($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function deleteGroupMember($s_group_id,$account_id)
    {
        $this->groupMemberService->deleteGroupMember($s_group_id,$account_id);
        return $this->showJsonResult(true, '删除成功', null);
    }

    public function selectGroup($account_id){
        $data = array();
        $data['account_id'] = $account_id;
        return view('admin/groupMember/selectGroup',$data);
    }

    public function getSelectedGroupTree($account_id){
        $MemberGrantService = new MemberGrantService();
        $arrResult = $MemberGrantService->getSelectedGroupTree($account_id);
        return response()->json($arrResult, Response::HTTP_OK);
    }

    public function saveGroupGrant(Request $request){

        $account_id = $request['account_id'];
        $selectedNodes  = $request['selectedNodes'];

        $groupArray = explode('@@',$selectedNodes);

        $MemberGrantService = new MemberGrantService();
        $MemberGrantService->deleteMemberGrant($account_id);

        foreach ($groupArray as $item) {
            $arrData = array();
            $arrData['account_id']  = $account_id;
            $arrData['s_group_id']  = $item;
            $MemberGrantService->insertMemberGrant($arrData);
        }
        return $this->showJsonResult(true, '保存成功', null);
    }


}
