<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Services\BrandService;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BrandController extends Controller
{
    protected $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->middleware('auth');
        $this->brandService = $brandService;
    }

    public function index(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            return view('admin/product/brand/addBrand');
        }elseif ($act == 'edit'){
            $data = array();
            $brand = $this->brandService->getBrandById($request['id']);
            $data['item'] = $brand ;
            return view('admin/product/brand/editBrand',$data);
        }else{
            return view('admin/product/brand/index');
        }
    }

    public function queryBrand(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $result = $this->brandService->queryBrand($queryParam);
        return $this->showPageResult($result);
    }

    public function getAllBrand()
    {
        $return = $this->brandService->getAllBrand();
        return $this->showJsonResult(true, '查询成功', $return);
    }

    public function saveBrand(Request $request)
    {
        $this->brandService->insertBrand($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function updateBrand(Request $request)
    {
        $this->brandService->updateBrand($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteBrand($id)
    {
        $this->brandService->deleteBrand($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

}
