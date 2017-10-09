<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductBrand;
use App\Models\ProductCat;
use App\Models\PromotionProduct;
use App\Models\PromotionRule;
use App\Services\PromotionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PromotionController extends Controller
{
    protected $promotionService;

    public function __construct(PromotionService $promotionService)
    {
        $this->middleware('auth');
        $this->promotionService = $promotionService;
    }

    public function index(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            return view('admin/promotion/addPromotion');
        }elseif ($act == 'edit'){
            $data = array();
            $promotion = $this->promotionService->getPromotionById($request['id']);
            $data['item'] = $promotion ;

            if($promotion->prom_scope == 'category'){
                $category = ProductCat::where('cat_id',$promotion->category_id)->first();
                $data['category'] = $category ;
            }else if($promotion->prom_scope == 'brand'){
                $brand = ProductBrand::where('brand_id',$promotion->brand_id)->first();
                $data['brand'] = $brand ;
            }

            $rule = PromotionRule::where('prom_id',$promotion->prom_id)->first();
            if($rule->min_price == 0 && $rule->min_num == 0){
                $rule->buy_cond = 3;
            }else if($rule->min_price != 0){
                $rule->buy_cond = 1;
            }else if($rule->min_num != 0){
                $rule->buy_cond = 2;
            }
            $data['rule'] = $rule ;

            return view('admin/promotion/editPromotion',$data);
        }else{
            return view('admin/promotion/index');
        }

    }

    public function queryPromotion(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $result = $this->promotionService->queryPromotion($queryParam);

        foreach ($result['items'] as &$item) {
            $item->goods = PromotionProduct::where('prom_id',$item->prom_id)->count();
        }

        return $this->showPageResult($result);
    }

    public function savePromotion(Request $request)
    {
        $this->promotionService->insertPromotion($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function updatePromotion(Request $request)
    {
        $this->promotionService->updatePromotion($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deletePromotion($id)
    {
        $this->promotionService->deletePromotion($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

    public function updateStatus($id,$status)
    {
        $this->promotionService->updateStatus($id,$status);
        return $this->showJsonResult(true, '修改成功', null);
    }

    //优惠券商品列表
    public function listPromotionGoods($prom_id)
    {
        $data['prom_id'] = $prom_id ;
        return view('admin/promotion/listGoods',$data);
    }

    public function queryPromotionGoods(Request $request,$id)
    {
        $queryParam = $this->buildSearchParam($request);
        $queryParam['prom_id'] = $id ;
        $result = $this->promotionService->queryPromotionGoods($queryParam);

        return $this->showPageResult($result);
    }

    public function selectGoods()
    {
        return view('admin/promotion/selectGoods');
    }

    public function querySelectGoods(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $queryParam['prom_id'] = $request['prom_id'];
        $result = $this->promotionService->querySelectGoods($queryParam);

        return $this->showPageResult($result);
    }

    public function savePromotionGoods(Request $request)
    {
        $this->promotionService->insertPromotionGoods($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function deletePromotionGoodsById($id)
    {
        $this->promotionService->deletePromotionGoodsById($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

}
