<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Services\AccountService;
use App\Services\ProductCatAttrOptionService;
use App\Services\ProductCatAttrService;
use App\Services\ProductCatService;
use Illuminate\Http\Request;

class ProductCatAttrController extends Controller
{
    protected $productCatService;
    protected $productCatAttrService;
    protected $productCatAttrOptionService;

    public function __construct()
    {
        $this->middleware('auth');
        $this->productCatAttrOptionService = new ProductCatAttrOptionService();
        $this->productCatAttrService = new ProductCatAttrService();
        $this->productCatService = new ProductCatService();
    }

    public function index(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            $data = array();
            $cat_id = $request['cat_id'];
            $data['cat'] = $this->productCatService->getCategoryById($cat_id);
            return view('admin/product/productCatAttr/addCategoryAttr',$data);
        }elseif ($act == 'edit'){
            $data = array();
            $attr = $this->productCatAttrService->getCategoryAttrById($request['attr_id']);
            $cat = $this->productCatService->getCategoryById($attr->cat_id);
            $data['cat'] = $cat ;
            $data['attr'] = $attr ;
            return view('admin/product/productCatAttr/editCategoryAttr',$data);
        }else{
            $data = array();
            $cat_id = $request['cat_id'];
            $data['cat'] = $this->productCatService->getCategoryById($cat_id);
            $data['attrs']  = $this->productCatAttrService->getProductCatAttrByCatId($cat_id);
            return view('admin/product/productCatAttr/index',$data);
        }
    }

    public function getProductCatAttrByCatId(Request $request)
    {
        $data = array();
        $cat_id = $request['cat_id'];
        $attrs = $this->productCatAttrService->getProductCatAttrByCatId($cat_id);
        foreach ($attrs as $attr) {
            $options = $this->productCatAttrOptionService->getProductCatAttrOptionByAttrId($attr->attr_id);
            $attr['options'] = $options;
        }
        $data['attrs'] = $attrs;
        return $this->showJsonResult(true, '查询成功', $data);
    }

    public function saveProductCatAttr(Request $request)
    {
        $this->productCatAttrService->insertCategoryAttr($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function updateProductCatAttr(Request $request)
    {
        $this->productCatAttrService->updateCategoryAttr($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteProductCatAttr($attr_id)
    {
        $this->productCatAttrService->deleteCategoryAttrByAttrId($attr_id);
        return $this->showJsonResult(true, '删除成功', null);
    }

}
