<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Services\ProductCatService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;
    protected $productCatService;

    public function __construct()
    {
        $this->middleware('auth');
        $this->productService = new ProductService();
        $this->productCatService = new ProductCatService();
    }

    public function index(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'step1'){
            return view('admin/product/product/addProductStep1');
        }elseif($act == 'add'){
            $data = array();
            $category = $this->productCatService->getCategoryById($request['cat_id']);
            $data['category'] = $category ;
            $data['cat_id'] = $request['cat_id'] ;
            return view('admin/product/product/addProduct',$data);
        }elseif ($act == 'edit'){
            $data = array();
            $product = $this->productService->getProductInfoById($request['id']);
            $data = $product ;

            return view('admin/product/product/editProduct',$data);
        }else{
            return view('admin/product/product/index');
        }
    }

    public function queryProduct(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $result = $this->productService->queryProduct($queryParam);
        return $this->showPageResult($result);
    }

    public function saveProduct(Request $request)
    {
        $this->productService->insertProduct($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function updateProduct(Request $request)
    {
        $this->productService->updateProduct($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteProduct($id)
    {
        $this->productService->deleteProduct($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

    public function updateStatus($product_id,$status)
    {
        $this->productService->updateStatus($product_id,$status);
        return $this->showJsonResult(true, '更新成功', null);
    }

}
