<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\PromotionProduct;
use App\Models\PromotionRule;
use Illuminate\Support\Facades\DB;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class CouponService
{
    public function __construct()
    {
        $this->PrimaryKey = "coupon_id";
        $this->TableName  = 'coupon';
    }

    public function queryCoupon($arrData)
    {
        $draw       = $arrData['draw'] ;
        $keyword    = $arrData['keyword'] ;

        $length     = $arrData['length'] ;
        $start      = $arrData['start'] ;

        $query = DB::table($this->TableName);
        if(!empty($keyword)){
            $query->where('coupon_code','like', '%'.$keyword.'%');
        }

        $sum = $query->count();

        if(isset($arrData['orderBy'])){
            $arrSort = explode('.', $arrData['orderBy']);
            $query->orderBy($arrSort[0], $arrSort[1]);
        }

        if($sum > 0){
            $rows = $query->skip($start)->take($length)->get();
        }else{
            $rows = array();
        }

        //当前第几页
        $start = intval($start) + 1 ;
        if($start % $length == 0){
            $page = $start / $length ;
        }else{
            $page = $start / $length + 1 ;
        }

        $resultData = array();
        $resultData['draw']            = $draw ;
        $resultData['page']            = intval($page);//当前第几页
        $resultData['recordsTotal']    = $sum ;//总数量
        $resultData['recordsFiltered'] = $sum ;
        $resultData['items']           = $rows ;//数据

        return $resultData ;
    }

    public function getCouponById($coupon_id)
    {
        return Coupon::where('coupon_id', '=', $coupon_id)->first();
    }

    public function insertCoupon($arrData)
    {
        if($arrData['coupon_scope']=='category'){
            $arrData['brand_id'] = 0;
        }else if($arrData['coupon_scope']=='brand'){
            $arrData['category_id'] = 0;
        }else{
            $arrData['category_id'] = 0;
            $arrData['brand_id'] = 0;
        }
        $arrData['coupon_status'] = 0 ;

        $arrParam = array();

        //使用门槛
        if($arrData['buy_cond']==1){
            $arrParam['min_price'] = $arrData['min_price'];
        }

        //优惠形式
        if($arrData['coupon_type'] == 1){
            $arrParam['minus'] = $arrData['coupon_face_value'];
        }else if($arrData['coupon_type'] == 2){
            $arrParam['discount'] = $arrData['coupon_discount'];
            $arrData['coupon_face_value'] = 0;
            $arrData['coupon_face_value_to'] = 0;
        }else if($arrData['coupon_type'] == 3){
            $arrParam['free_ship'] = 1;
            $arrData['coupon_face_value'] = 0;
            $arrData['coupon_face_value_to'] = 0;
        }

        $coupon = Coupon::create($arrData);

        $arrParam['coupon_id'] = $coupon->coupon_id ;
        PromotionRule::create($arrParam);

        return true;
    }

    public function updateCoupon($arrData)
    {
        $coupon_id = $arrData['coupon_id'];
        return Coupon::where('coupon_id','=',$coupon_id)->update($arrData);
    }

    public function deleteCoupon($coupon_id)
    {
        Coupon::where('coupon_id', '=', $coupon_id)->delete();
        PromotionProduct::where('coupon_id', '=', $coupon_id)->delete();
        PromotionRule::where('coupon_id', '=', $coupon_id)->delete();

        return true;
    }

    public function updateStatus($coupon_id,$status)
    {
        return Coupon::where('coupon_id', '=', $coupon_id)->update(["coupon_status"=>$status]);
    }

    //优惠券商品列表
    public function queryCouponGoods($arrData)
    {
        $draw       = $arrData['draw'] ;
        $keyword    = $arrData['keyword'] ;

        $length     = $arrData['length'] ;
        $start      = $arrData['start'] ;

        $query = DB::table("promotion_product")
            ->leftJoin("product","promotion_product.product_id","=","product.product_id")
            ->leftJoin("product_category","product_category.cat_id","=","product.product_cat_id")
            ->select("product.*","product_category.cat_title as product_cat_title","promotion_product.id")
            ->where("promotion_product.coupon_id",$arrData['coupon_id']);

        if(!empty($keyword)){
            $query->where('product.product_title','like', '%'.$keyword.'%');
        }

        $sum = $query->count();
        if(isset($arrData['orderBy']) ){
            $arrSort = explode('.', $arrData['orderBy']);
            $query->orderBy($arrSort[0], $arrSort[1]);
        }

        if($sum > 0){
            $rows = $query->skip($start)->take($length)->get();
        }else{
            $rows = array();
        }

        //当前第几页
        $start = intval($start) + 1 ;
        if($start % $length == 0){
            $page = $start / $length ;
        }else{
            $page = $start / $length + 1 ;
        }

        $resultData = array();
        $resultData['draw']            = $draw ;
        $resultData['page']            = intval($page);//当前第几页
        $resultData['recordsTotal']    = $sum ;//总数量
        $resultData['recordsFiltered'] = $sum ;
        $resultData['items']           = $rows ;//数据

        return $resultData ;
    }

    public function querySelectGoods($arrData)
    {
        $draw       = $arrData['draw'] ;
        $keyword    = $arrData['keyword'] ;

        $length     = $arrData['length'] ;
        $start      = $arrData['start'] ;

        $query = DB::table("product")
            ->leftJoin("promotion_product",function ($join) use ($arrData){
                $join->on("promotion_product.product_id","=","product.product_id")
                    ->where("promotion_product.coupon_id",$arrData['coupon_id']);
            })
            ->leftJoin("product_category","product_category.cat_id","=","product.product_cat_id")
            ->select("product.*","product_category.cat_title")
            ->whereNull("promotion_product.id");

        if(!empty($keyword)){
            $query->where('product_title','like', '%'.$keyword.'%');
        }

        $sum = $query->count();

        if(isset($arrData['orderBy'])){
            $arrSort = explode('.', $arrData['orderBy']);
            $query->orderBy($arrSort[0], $arrSort[1]);
        }

        if($sum > 0){
            $rows = $query->skip($start)->take($length)->get();
        }else{
            $rows = array();
        }

        //当前第几页
        $start = intval($start) + 1 ;
        if($start % $length == 0){
            $page = $start / $length ;
        }else{
            $page = $start / $length + 1 ;
        }

        $resultData = array();
        $resultData['draw']            = $draw ;
        $resultData['page']            = intval($page);//当前第几页
        $resultData['recordsTotal']    = $sum ;//总数量
        $resultData['recordsFiltered'] = $sum ;
        $resultData['items']           = $rows ;//数据

        return $resultData ;
    }

    public function insertCouponGoods($arrData)
    {

        $coupon_id = $arrData['coupon_id'];
        $ids = $arrData['ids'];

        $arrIds = explode(',', $ids);

        foreach ($arrIds as $id) {
            $arrParam = array();
            $arrParam['coupon_id'] = $coupon_id ;
            $arrParam['product_id'] = $id ;
            PromotionProduct::create($arrParam);
        }

        return true;
    }

    public function deleteCouponGoodsById($id)
    {
        return PromotionProduct::where('id', '=', $id)->delete();
    }

}