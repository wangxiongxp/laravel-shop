<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Services\AccountService;
use App\Services\ProductCatService;
use Illuminate\Http\Request;

class ProductCatController extends Controller
{
    protected $productCatService;

    public function __construct(ProductCatService $productCatService)
    {
        $this->middleware('auth');
        $this->productCatService = $productCatService;
    }

    public function index(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            return view('admin/product/productCat/addCategory');
        }elseif ($act == 'edit'){
            $data = array();
            $cat = $this->productCatService->getCategoryById($request['cat_id']);
            $data['cat'] = $cat ;
            return view('admin/product/productCat/editCategory',$data);
        }else{
            $data = array();
            $data['cats'] = $this->productCatService->GetCategoryTree(0);
            return view('admin/product/productCat/index',$data);
        }
    }

    public function getFirstCategory()
    {
        $result = $this->productCatService->getFirstCategory();
        return $this->showJsonResult(true, '查询成功', $result);
    }

    public function getCatalogByParent($parent_id)
    {
        $result = $this->productCatService->getCatalogByParent($parent_id);
        return $this->showJsonResult(true, '查询成功', $result);
    }

    public function saveProductCat(Request $request)
    {
        $this->productCatService->insertCategory($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function updateProductCat(Request $request)
    {
        $this->productCatService->updateCategory($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteProductCat($id)
    {
        $this->productCatService->deleteCategory($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

}
