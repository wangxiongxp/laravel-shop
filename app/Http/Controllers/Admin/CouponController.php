<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductBrand;
use App\Models\ProductCat;
use App\Models\PromotionProduct;
use App\Models\PromotionRule;
use App\Services\CouponService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


/**
 *
 * 打折/优惠券/活动(打折和满减活动不能同时生效)
 *
 * 优惠券：
 * 优惠券编号
 * ===优惠券类别（私有，公共）
 * 优惠券名称
 * 优惠券备注
 * 优惠券有效期
 * 参与范围（全场，分类，品牌，部分商品）
 * 是否可叠加使用
 * 领取方式（主动领取，系统发送）
 * 优惠券类型（现金券，满减券，折扣券）
 * 优惠券面值（face_value）
 * 优惠券最高抵扣(max_value)
 * 发送总量
 * 每人限领（默认一次）
 *
 * 用户优惠券
 * ID
 * 优惠券编号
 * 领取时间
 * 用户ID
 * 优惠券状态
 *
 */
class CouponController extends Controller
{
    protected $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->middleware('auth');
        $this->couponService = $couponService;
    }

    public function index(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            return view('admin/coupon/addCoupon');
        }elseif ($act == 'edit'){
            $data = array();
            $coupon = $this->couponService->getCouponById($request['id']);
            $data['item'] = $coupon ;

            if($coupon->coupon_scope == 'category'){
                $category = ProductCat::where('cat_id',$coupon->category_id)->first();
                $data['category'] = $category ;
            }else if($coupon->coupon_scope == 'brand'){
                $brand = ProductBrand::where('brand_id',$coupon->brand_id)->first();
                $data['brand'] = $brand ;
            }

            $rule = PromotionRule::where('coupon_id',$coupon->coupon_id)->first();
            if($rule->min_price == 0){
                $rule->buy_cond = 2;
            }else{
                $rule->buy_cond = 1;
            }
            $data['rule'] = $rule ;

            return view('admin/coupon/editCoupon',$data);
        }else{
            return view('admin/coupon/index');
        }

    }

    public function queryCoupon(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $result = $this->couponService->queryCoupon($queryParam);

        foreach ($result['items'] as &$item) {
            $item->goods = PromotionProduct::where('coupon_id',$item->coupon_id)->count();
        }

        return $this->showPageResult($result);
    }

    public function saveCoupon(Request $request)
    {
        $this->couponService->insertCoupon($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function updateCoupon(Request $request)
    {
        $this->couponService->updateCoupon($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteCoupon($id)
    {
        $this->couponService->deleteCoupon($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

    public function updateStatus($id,$status)
    {
        $this->couponService->updateStatus($id,$status);
        return $this->showJsonResult(true, '修改成功', null);
    }

    //优惠券商品列表
    public function listCouponGoods($coupon_id)
    {
        $data['coupon_id'] = $coupon_id ;
        return view('admin/coupon/listGoods',$data);
    }

    public function queryCouponGoods(Request $request,$id)
    {
        $queryParam = $this->buildSearchParam($request);
        $queryParam['coupon_id'] = $id ;
        $result = $this->couponService->queryCouponGoods($queryParam);

        return $this->showPageResult($result);
    }

    public function selectGoods()
    {
        return view('admin/coupon/selectGoods');
    }

    public function querySelectGoods(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $queryParam['coupon_id'] = $request['coupon_id'];
        $result = $this->couponService->querySelectGoods($queryParam);

        return $this->showPageResult($result);
    }

    public function saveCouponGoods(Request $request)
    {
        $this->couponService->insertCouponGoods($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function deleteCouponGoodsById($id)
    {
        $this->couponService->deleteCouponGoodsById($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

}
