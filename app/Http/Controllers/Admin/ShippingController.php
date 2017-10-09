<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShippingController extends Controller
{
    protected $shippingService;

    public function __construct(ShippingService $shippingService)
    {
        $this->middleware('auth');
        $this->shippingService = $shippingService;
    }

    public function index(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            return view('admin/shipping/addShipping');
        }elseif ($act == 'edit'){
            $data = array();
            $shipping = $this->shippingService->getShippingById($request['id']);
            $data['item'] = $shipping ;

            return view('admin/shipping/editShipping',$data);
        }else{
            return view('admin/shipping/index');
        }

    }

    public function queryShipping(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $result = $this->shippingService->queryShipping($queryParam);
        return $this->showPageResult($result);
    }

    public function saveShipping(Request $request)
    {
        $this->shippingService->insertShipping($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function updateShipping(Request $request)
    {
        $this->shippingService->updateShipping($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteShipping($id)
    {
        $this->shippingService->deleteShipping($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

}
