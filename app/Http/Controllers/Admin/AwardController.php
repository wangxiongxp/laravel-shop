<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AwardService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AwardController extends Controller
{
    protected $awardService;

    public function __construct(AwardService $awardService)
    {
        $this->middleware('auth');
        $this->awardService = $awardService;
    }

    public function index()
    {
        return view('admin/award/index');
    }

    public function cards(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            return view('admin/award/cards/addCards');
        }elseif ($act == 'edit'){
            $data = array();
            $item = $this->awardService->getAwardById($request['id']);
            $data['item'] = $item ;
            return view('admin/award/cards/editCards',$data);
        }else{
            return view('admin/award/cards/index');
        }
    }

    public function wheel(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            return view('admin/award/wheel/addCards');
        }elseif ($act == 'edit'){
            $data = array();
            $item = $this->awardService->getAwardById($request['id']);
            $data['item'] = $item ;
            return view('admin/award/wheel/editCards',$data);
        }else{
            return view('admin/award/wheel/index');
        }
    }

    public function goldenEgg(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            return view('admin/award/goldenEgg/addCards');
        }elseif ($act == 'edit'){
            $data = array();
            $item = $this->awardService->getAwardById($request['id']);
            $data['item'] = $item ;
            return view('admin/award/goldenEgg/editCards',$data);
        }else{
            return view('admin/award/goldenEgg/index');
        }
    }

    public function zodiac(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            return view('admin/award/zodiac/addCards');
        }elseif ($act == 'edit'){
            $data = array();
            $item = $this->awardService->getAwardById($request['id']);
            $data['item'] = $item ;
            return view('admin/award/zodiac/editCards',$data);
        }else{
            return view('admin/award/zodiac/index');
        }
    }

    public function shake(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            return view('admin/award/shake/addCards');
        }elseif ($act == 'edit'){
            $data = array();
            $item = $this->awardService->getAwardById($request['id']);
            $data['item'] = $item ;
            return view('admin/award/shake/editCards',$data);
        }else{
            return view('admin/award/shake/index');
        }
    }

    public function queryAward(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);

        $queryParam['award_type'] = $request['award_type'] ;
        $result = $this->awardService->queryAward($queryParam);
        return $this->showPageResult($result);
    }

    public function saveAward(Request $request)
    {
        $this->awardService->insertAward($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function updateAward(Request $request)
    {
        $this->awardService->updateAward($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteAward($id)
    {
        $this->awardService->deleteAward($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

}
