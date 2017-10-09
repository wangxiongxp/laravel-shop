<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FriendLinkService;
use Illuminate\Http\Request;

class FriendLinkController extends Controller
{
    protected $friendLinkService;

    public function __construct()
    {
        $this->middleware('auth');
        $this->friendLinkService = new FriendLinkService();
    }

    public function index(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            return view('admin/friendLink/addFriendLink');
        }elseif ($act == 'edit'){
            $data = array();
            $item = $this->friendLinkService->getFriendLinkById($request['id']);
            $data['item'] = $item ;
            return view('admin/friendLink/editFriendLink',$data);
        }else{
            return view('admin/friendLink/index');
        }
    }

    public function queryFriendLink(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $result = $this->friendLinkService->queryFriendLink($queryParam);
        return $this->showPageResult($result);
    }

    public function saveFriendLink(Request $request)
    {
        $this->friendLinkService->insertFriendLink($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function updateFriendLink(Request $request)
    {
        $this->friendLinkService->updateFriendLink($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteFriendLink($id)
    {
        $this->friendLinkService->deleteFriendLink($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

}
