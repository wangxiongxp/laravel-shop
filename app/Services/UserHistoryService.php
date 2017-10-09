<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class UserHistoryService
{
    public function __construct()
    {
        $this->PrimaryKey = "history_id";
        $this->TableName  = 'user_history';
    }

    public function queryUserHistory($arrData)
    {
        $account_id  = $arrData['account_id'] ;

        $page        = $arrData['page'] ;
        $limit       = $arrData['limit'] ;

        $query = DB::table($this->TableName)
            ->leftJoin('product','product.product_id', '=', 'user_history.product_id')
            ->select("user_history.history_id","product.*");
        if(!empty($account_id)){
            $query->where('user_history.account_id','=', $account_id );
        }

        $sum = $query->count();

        if(isset($arrData['orderBy'])){
            $query->orderBy('user_history.created_at', 'desc');
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