<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpecialGoods;
use App\Services\SpecialService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SpecialController extends Controller
{
    protected $specialService;

    public function __construct(SpecialService $specialService)
    {
        $this->middleware('auth');
        $this->specialService = $specialService;
    }

    public function index(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            return view('admin/special/addSpecial');
        }elseif ($act == 'edit'){
            $data = array();
            $special = $this->specialService->getSpecialById($request['id']);
            $data['item'] = $special ;

            return view('admin/special/editSpecial',$data);
        }else{
            return view('admin/special/index');
        }

    }

    public function querySpecial(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $result = $this->specialService->querySpecial($queryParam);
        foreach ($result['items'] as &$item) {
            $item->goods = SpecialGoods::where('special_id',$item->id)->count();
        }

        return $this->showPageResult($result);
    }

    public function saveSpecial(Request $request)
    {
        $this->specialService->insertSpecial($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function updateSpecial(Request $request)
    {
        $this->specialService->updateSpecial($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteSpecial($id)
    {
        $this->specialService->deleteSpecial($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

    public function deleteExpiredGoods($id)
    {
        $this->specialService->deleteExpiredGoods($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

    //限时特价商品列表
    public function listSpecialGoods($special_id)
    {
        $data['special_id'] = $special_id ;
        return view('admin/special/listGoods',$data);
    }

    public function querySpecialGoods(Request $request,$id)
    {
        $queryParam = $this->buildSearchParam($request);
        $queryParam['special_id'] = $id ;
        $result = $this->specialService->querySpecialGoods($queryParam);

        return $this->showPageResult($result);
    }

    public function selectGoods()
    {
        return view('admin/special/selectGoods');
    }

    public function querySelectGoods(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $result = $this->specialService->querySelectGoods($queryParam);

        return $this->showPageResult($result);
    }

    public function saveSpecialGoods(Request $request)
    {
        $this->specialService->insertSpecialGoods($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function deleteSpecialGoodsById($id)
    {
        $this->specialService->deleteSpecialGoodsById($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

}
