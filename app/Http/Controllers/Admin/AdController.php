<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AccountService;
use App\Services\AdItemService;
use App\Services\AdService;
use Illuminate\Http\Request;

class AdController extends Controller
{
    protected $adService;
    protected $adItemService;

    public function __construct()
    {
        $this->middleware('auth');
        $this->adService = new AdService();
        $this->adItemService = new AdItemService();
    }

    public function index(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            return view('admin/ad/addAd');
        }elseif ($act == 'edit'){
            $data = array();
            $ad = $this->adService->getAdById($request['id']);
            $data['ad'] = $ad ;
            return view('admin/ad/editAd',$data);
        }else{
            return view('admin/ad/index');
        }
    }

    public function queryAd(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $result = $this->adService->queryAd($queryParam);
        return $this->showPageResult($result);
    }

    public function saveAd(Request $request)
    {
        $this->adService->insertAd($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function updateAd(Request $request)
    {
        $this->adService->updateAd($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteAd($id)
    {
        $this->adService->deleteAd($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

    public function adItem(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            $data['ad_id'] = $request['id'];
            return view('admin/ad/addAdItem',$data);
        }elseif ($act == 'edit'){
            $data = array();
            $item = $this->adItemService->getItemById($request['id']);
            $data['item'] = $item ;
            return view('admin/ad/editAdItem',$data);
        }else{
            $ad = $this->adService->getAdById($request['id']);
            $data['ad'] = $ad ;

            $adItems = $this->adItemService->getItemByAd($request['id']);
            $data['adItems'] = $adItems ;

            return view('admin/ad/adItem',$data);
        }
    }

    public function saveAdItem(Request $request)
    {
        $this->adItemService->insertAdItem($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function deleteAdItem($ad_item_id)
    {
        $this->adItemService->deleteAdItem($ad_item_id);
        return $this->showJsonResult(true, '删除成功', null);
    }

    public function updateAdItem(Request $request)
    {
        $this->adItemService->updateAdItem($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

}
