<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class UserCollectionService
{
    public function __construct()
    {
        $this->PrimaryKey = "collection_id";
        $this->TableName  = 'user_collection';
    }

    public function queryUserCollection($arrData)
    {
        $pageNo      = isset($arrData['pageNo']) ? $arrData['pageNo'] : 1 ;
        $pageSize    = isset($arrData['pageSize']) ? $arrData['pageSize'] : 10 ;

        $orderBy     = isset($arrData['orderBy']) ? $arrData['orderBy']: "" ;
        $order       = isset($arrData['order']) ? $arrData['order'] : "ASC" ;

        $keyword     = isset($arrData['keyword']) ? $arrData['keyword'] : "" ;

        $query = DB::table($this->TableName);
        if(!empty($keyword)){
            $query->where('product_id','like', '%'.$keyword.'%');
        }

        $sum = $query->count();

        if(!empty($orderBy)){
            $query->orderBy($orderBy, $order);
        }

        if($sum > 0){
            $start = (intval($pageNo) - 1) * intval($pageSize) ;
            $rows = $query->skip($start)->take($pageSize)->get();
        }else{
            $rows = array();
        }

        if($sum % $pageSize == 0){
            $pageCount = intval($sum / $pageSize) ;
        }else{
            $pageCount = intval($sum / $pageSize) + 1 ;
        }

        $resultData = array();
        $resultData['pageNo']         = $pageNo ;
        $resultData['pageSize']       = $pageSize ;
        $resultData['totalCount']     = $sum ;
        $resultData['pageCount']      = $pageCount ;
        $resultData['orderBy']        = $orderBy ;
        $resultData['asc']            = $order ;
        $resultData['items']          = $rows ;
        $resultData['keyword']        = $keyword ;

        return $resultData ;
    }

    public function queryCollection($arrData)
    {
        $account_id  = $arrData['account_id'] ;

        $page        = $arrData['page'] ;
        $limit       = $arrData['limit'] ;

        $query = DB::table($this->TableName)
            ->leftJoin('product','product.product_id', '=', 'mall_collection.product_id')
            ->select("mall_collection.collection_id","product.*");
        if(!empty($account_id)){
            $query->where('mall_collection.account_id','=', $account_id );
        }

        $sum = $query->count();

        if(isset($arrData['orderBy'])){
            $query->orderBy('mall_collection.created_at', 'desc');
        }

        if($sum > 0){
            $start  = ($page-1) * $limit;
            $rows   = $query->skip($start)->take($limit)->get();
        }else{
            $rows   = array();
        }

        $resultData = array();
        $resultData['page']     = intval($page);//当前第几页
        $resultData['limit']    = intval($limit);//当前第几页
        $resultData['total']    = $sum ;//总数量
        $resultData['items']    = $rows ;//数据

        return $resultData ;
    }

}