<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\Services\GrowthService;
use Illuminate\Http\Request;

class GrowthController extends Controller
{
    protected $growthService;

    public function __construct(GrowthService $growthService)
    {
        $this->middleware('auth');
        $this->growthService = $growthService;
    }

    public function index(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            return view('admin/member/growth/addGrowth');
        }elseif ($act == 'edit'){
            $navigation = $this->growthService->getGrowthById($request['id']);
            $data['item'] = $navigation ;
            return view('admin/member/growth/editGrowth',$data);
        }else{
            return view('admin/member/growth/index');
        }
    }

    public function queryGrowth(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $result = $this->growthService->queryGrowth($queryParam);
        return $this->showPageResult($result);
    }

    public function saveGrowth(Request $request)
    {
        $this->growthService->insertGrowth($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function updateGrowth(Request $request)
    {
        $this->growthService->updateGrowth($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteGrowth($id)
    {
        $this->growthService->deleteGrowth($id);
        return $this->showJsonResult(true, '删除成功', null);
    }


}
