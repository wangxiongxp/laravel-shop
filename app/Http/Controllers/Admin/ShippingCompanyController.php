<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ShippingCompanyService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShippingCompanyController extends Controller
{
    protected $shippingCompanyService;

    public function __construct(ShippingCompanyService $shippingCompanyService)
    {
        $this->middleware('auth');
        $this->shippingCompanyService = $shippingCompanyService;
    }

    public function index(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            return view('admin/shippingCompany/addShippingCompany');
        }elseif ($act == 'edit'){
            $data = array();
            $shipping = $this->shippingCompanyService->getShippingCompanyById($request['id']);
            $data['item'] = $shipping ;

            return view('admin/shippingCompany/editShippingCompany',$data);
        }else{
            return view('admin/shippingCompany/index');
        }
    }

    public function queryShippingCompany(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $result = $this->shippingCompanyService->queryShippingCompany($queryParam);
        return $this->showPageResult($result);
    }

    public function getShippingCompany()
    {
        $result = $this->shippingCompanyService->getShippingCompany();
        return $this->showJsonResult(true, '查询成功', $result);
    }

    public function saveShippingCompany(Request $request)
    {
        $this->shippingCompanyService->insertShippingCompany($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function updateShippingCompany(Request $request)
    {
        $this->shippingCompanyService->updateShippingCompany($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteShippingCompany($id)
    {
        $this->shippingCompanyService->deleteShippingCompany($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

}
