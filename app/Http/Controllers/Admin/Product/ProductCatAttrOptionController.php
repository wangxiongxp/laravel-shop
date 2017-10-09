<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductCatAttrOption;
use App\Services\AccountService;
use App\Services\ProductCatAttrOptionService;
use App\Services\ProductCatAttrService;
use App\Services\ProductCatService;
use Illuminate\Http\Request;

class ProductCatAttrOptionController extends Controller
{
    protected $productCatService;
    protected $productCatAttrService;
    protected $productCatAttrOptionService;

    public function __construct()
    {
        $this->middleware('auth');
        $this->productCatService = new ProductCatService();
        $this->productCatAttrService = new ProductCatAttrService();
        $this->productCatAttrOptionService = new ProductCatAttrOptionService();
    }

    public function index(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            $data = array();
            $attr = $this->productCatAttrService->getCategoryAttrById($request['attr_id']);
            $data['attr'] = $attr ;
            $cat = $this->productCatService->getCategoryById($attr['cat_id']);
            $data['cat'] = $cat ;
            return view('admin/product/productCatAttrOption/addCategoryAttrOption',$data);
        }elseif ($act == 'edit'){
            $data = array();
            $option = $this->productCatAttrOptionService->getCategoryAttrOptionById($request['option_id']);
            $data['option'] = $option ;
            $attr = $this->productCatAttrService->getCategoryAttrById($option['attr_id']);
            $data['attr'] = $attr ;
            $cat = $this->productCatService->getCategoryById($attr['cat_id']);
            $data['cat'] = $cat ;
            return view('admin/product/productCatAttrOption/editCategoryAttrOption',$data);
        }else{
            $data = array();
            $attr = $this->productCatAttrService->getCategoryAttrById($request['attr_id']);
            $data['attr'] = $attr ;
            $data['options'] = $this->productCatAttrOptionService->getProductCatAttrOptionByAttrId($request['attr_id']);
            return view('admin/product/productCatAttrOption/index',$data);
        }
    }

    public function saveProductCatAttrOption(Request $request)
    {
        $this->productCatAttrOptionService->insertCategoryAttrOption($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function updateProductCatAttrOption(Request $request)
    {
        $this->productCatAttrOptionService->updateCategoryAttrOption($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteProductCatAttrOption($option_id)
    {
        $this->productCatAttrOptionService->deleteCategoryAttrOption($option_id);
        return $this->showJsonResult(true, '删除成功', null);
    }

}
