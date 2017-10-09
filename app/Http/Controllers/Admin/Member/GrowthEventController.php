<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\Services\AccountService;
use App\Services\AdItemService;
use App\Services\AdService;
use App\Services\GrowthEventService;
use Illuminate\Http\Request;

class GrowthEventController extends Controller
{
    protected $growthEventService;

    public function __construct()
    {
        $this->middleware('auth');
        $this->growthEventService = new GrowthEventService();
    }

    public function index(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            return view('admin/member/growthEvent/addGrowthEvent');
        }elseif ($act == 'edit'){
            $data = array();
            $ad = $this->growthEventService->getGrowthEventById($request['id']);
            $data['item'] = $ad ;
            return view('admin/member/growthEvent/editGrowthEvent',$data);
        }else{
            return view('admin/member/growthEvent/index');
        }
    }

    public function queryGrowthEvent(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $result = $this->growthEventService->queryGrowthEvent($queryParam);
        return $this->showPageResult($result);
    }

    public function saveGrowthEvent(Request $request)
    {
        $this->growthEventService->insertGrowthEvent($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function updateGrowthEvent(Request $request)
    {
        $this->growthEventService->updateGrowthEvent($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteGrowthEvent($id)
    {
        $this->growthEventService->deleteGrowthEvent($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

}
