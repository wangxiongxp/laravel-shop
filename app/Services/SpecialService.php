<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Special;
use App\Models\SpecialGoods;
use Illuminate\Support\Facades\DB;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class SpecialService
{
    protected $roleRepository;

    public function __construct()
    {
        $this->PrimaryKey = "special_id";
        $this->TableName  = 'special';
    }

    public function querySpecial($arrData)
    {
        $draw       = $arrData['draw'] ;
        $keyword    = $arrData['keyword'] ;

        $length     = $arrData['length'] ;
        $start      = $arrData['start'] ;

        $query = DB::table($this->TableName);
        if(!empty($keyword)){
            $query->where('special_title','like', '%'.$keyword.'%');
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

    public function querySpecialGoods($arrData)
    {
        $draw       = $arrData['draw'] ;
        $keyword    = $arrData['keyword'] ;

        $length     = $arrData['length'] ;
        $start      = $arrData['start'] ;

        $query = DB::table("special_goods_def")
            ->leftJoin("special","special_goods_def.special_id","=","special.id")
            ->leftJoin("product","special_goods_def.product_id","=","product.product_id")
            ->leftJoin("product_category","product_category.cat_id","=","product.product_cat_id")
            ->select("product.*","product_category.cat_title as product_cat_title","special.start_time","special.end_time","special.discount","special_goods_def.id")
            ->where("special_goods_def.special_id",$arrData['special_id']);

        if(!empty($keyword)){
            $query->where('special_title','like', '%'.$keyword.'%');
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

    public function querySelectGoods($arrData)
    {
        $draw       = $arrData['draw'] ;
        $keyword    = $arrData['keyword'] ;

        $length     = $arrData['length'] ;
        $start      = $arrData['start'] ;

        $query = DB::table("product")
            ->leftJoin("special_goods_def","special_goods_def.product_id","=","product.product_id")
            ->leftJoin("product_category","product_category.cat_id","=","product.product_cat_id")
            ->select("product.*","product_category.cat_title")
            ->whereNull("special_goods_def.id");

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

    public function getSpecialById($id)
    {
        return Special::where('id', '=', $id)->first();
    }

    public function insertSpecial($arrData)
    {
        if($arrData['scope']=='is_goods'){
            //置指定商品
            $arrData['category_id'] = 0;
            $arrData['brand_id'] = 0;
            $arrData['is_goods'] = 1;
        }elseif ($arrData['scope']=='is_brand'){
            //指定品牌
            $brand_id = $arrData['brand_id'];
            $special = Special::create($arrData);
            $products = Product::where('brand_id',$brand_id)->get();
            if(count($products)>0){
                foreach ($products as $item) {
                    $arrParam = array();
                    $arrParam['special_id'] = $special->id ;
                    $arrParam['product_id'] = $item->product_id ;
                    $arrParam['status'] = 1 ;
                    SpecialGoods::create($arrParam);
                }
            }

        }elseif ($arrData['scope']=='is_category'){
            //指定分类
            $category_id = $arrData['category_id'];
            $special = Special::create($arrData);

            $products = Product::where('product_cat_id',$category_id)->get();
            if(count($products)>0){
                foreach ($products as $item) {
                    $arrParam = array();
                    $arrParam['special_id'] = $special->id ;
                    $arrParam['product_id'] = $item->product_id ;
                    $arrParam['status'] = 1 ;
                    SpecialGoods::create($arrParam);
                }
            }
        }

        return true;
    }

    public function insertSpecialGoods($arrData)
    {

        $special_id = $arrData['special_id'];
        $ids = $arrData['ids'];

        $arrIds = explode(',', $ids);

        foreach ($arrIds as $id) {
            $arrParam = array();
            $arrParam['special_id'] = $special_id ;
            $arrParam['product_id'] = $id ;
            $arrParam['status'] = 1 ;
            SpecialGoods::create($arrParam);
        }

        return true;
    }

    public function updateSpecial($arrData)
    {
        $id = $arrData['id'];
        return Special::where('id','=',$id)->update($arrData);
    }

    public function deleteSpecial($id)
    {
        Special::where('id', '=', $id)->delete();
        SpecialGoods::where('special_id', '=', $id)->delete();
        return true;
    }

    public function deleteExpiredGoods($id)
    {
        return SpecialGoods::where('special_id', '=', $id)
            ->leftJoin('product','special_goods_def.product_id','=','product.product_id')
            ->where('product.product_status','!=','1')
            ->delete();
    }

    public function deleteSpecialGoodsById($id)
    {
        return SpecialGoods::where('id', '=', $id)->delete();
    }

}