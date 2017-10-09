<?php

namespace App\Services;

use App\Models\Promotion;
use App\Models\PromotionProduct;
use App\Models\PromotionRule;
use Illuminate\Support\Facades\DB;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class PromotionService
{
    public function __construct()
    {
        $this->PrimaryKey = "prom_id";
        $this->TableName  = 'promotion';
    }

    public function queryPromotion($arrData)
    {
        $draw       = $arrData['draw'] ;
        $keyword    = $arrData['keyword'] ;

        $length     = $arrData['length'] ;
        $start      = $arrData['start'] ;

        $query = DB::table($this->TableName);
        if(!empty($keyword)){
            $query->where('prom_title','like', '%'.$keyword.'%');
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

    public function getPromotionById($prom_id)
    {
        return Promotion::where('prom_id', '=', $prom_id)->first();
    }

    public function insertPromotion($arrData)
    {
        if($arrData['prom_scope']=='category'){
            $arrData['brand_id'] = 0;
        }else if($arrData['prom_scope']=='brand'){
            $arrData['category_id'] = 0;
        }else{
            $arrData['category_id'] = 0;
            $arrData['brand_id'] = 0;
        }
        $arrData['status'] = 0 ;

        $promotion = Promotion::create($arrData);

        $arrParam = array();
        $arrParam['prom_id'] = $promotion->prom_id ;

        //使用门槛
        if($arrData['buy_cond']==1){
            $arrParam['min_price'] = $arrData['min_price'];
        }else if($arrData['buy_cond']==2){
            $arrParam['min_num'] = $arrData['min_num'];
        }else{
            $arrParam['min_price'] = 0;
            $arrParam['min_num'] = 0;
        }

        //优惠形式
        if($arrData['prom_type'] == 1){
            $arrParam['minus'] = $arrData['minus'];
        }else if($arrData['prom_type'] == 2){
            $arrParam['discount'] = $arrData['discount'];
        }else if($arrData['prom_type'] == 3){
            $arrParam['free_ship'] = 1;
        }

        PromotionRule::create($arrParam);

        return true;
    }

    public function updatePromotion($arrData)
    {
        $prom_id = $arrData['prom_id'];
        return Promotion::where('prom_id','=',$prom_id)->update($arrData);
    }

    public function deletePromotion($prom_id)
    {
        Promotion::where('prom_id', '=', $prom_id)->delete();
        PromotionProduct::where('prom_id', '=', $prom_id)->delete();
        PromotionRule::where('prom_id', '=', $prom_id)->delete();

        return true ;
    }

    public function updateStatus($id,$status)
    {
        return Promotion::where('prom_id','=',$id)->update(['status'=>$status]);
    }

    //促销商品列表
    public function queryPromotionGoods($arrData)
    {
        $draw       = $arrData['draw'] ;
        $keyword    = $arrData['keyword'] ;

        $length     = $arrData['length'] ;
        $start      = $arrData['start'] ;

        $query = DB::table("promotion_product")
            ->leftJoin("product","promotion_product.product_id","=","product.product_id")
            ->leftJoin("product_category","product_category.cat_id","=","product.product_cat_id")
            ->select("product.*","product_category.cat_title as product_cat_title","promotion_product.id")
            ->where("promotion_product.prom_id",$arrData['prom_id']);

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
                    ->where("promotion_product.prom_id",$arrData['prom_id']);
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

    public function insertPromotionGoods($arrData)
    {

        $prom_id = $arrData['prom_id'];
        $ids = $arrData['ids'];

        $arrIds = explode(',', $ids);

        foreach ($arrIds as $id) {
            $arrParam = array();
            $arrParam['prom_id'] = $prom_id ;
            $arrParam['product_id'] = $id ;
            PromotionProduct::create($arrParam);
        }

        return true;
    }

    public function deletePromotionGoodsById($id)
    {
        return PromotionProduct::where('id', '=', $id)->delete();
    }


}