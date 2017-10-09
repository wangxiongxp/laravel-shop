<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\NavigationService;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    protected $navigationService;

    public function __construct(NavigationService $navigationService)
    {
        $this->middleware('auth');
        $this->navigationService = $navigationService;
    }

    public function index(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            return view('admin/navigation/addNavigation');
        }elseif ($act == 'edit'){
            $navigation = $this->navigationService->getNavigationById($request['id']);
            $data['item'] = $navigation ;
            return view('admin/navigation/editNavigation',$data);
        }else{
            $data = array();
            $data['navs'] = $this->navigationService->getNavigationTree(0);
            return view('admin/navigation/index',$data);
        }
    }

    public function saveNavigation(Request $request)
    {
        $this->navigationService->insertNavigation($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function updateNavigation(Request $request)
    {
        $this->navigationService->updateNavigation($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteNavigation($id)
    {
        $this->navigationService->deleteNavigation($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

    public function getFirstNav()
    {
        $result = $this->navigationService->getFirstNavigation();
        return $this->showJsonResult(true, '查询成功', $result);
    }

}
