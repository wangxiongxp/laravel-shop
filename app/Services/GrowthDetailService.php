<?php

namespace App\Services;

use App\Models\Growth;
use Illuminate\Support\Facades\DB;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class GrowthDetailService
{
    protected $roleRepository;

    public function __construct()
    {
        $this->PrimaryKey = "id";
        $this->TableName  = 'growth_detail';
    }

    public function queryGrowthDetail($arrData)
    {
        $pageNo      = isset($arrData['pageNo']) ? $arrData['pageNo'] : 1 ;
        $pageSize    = isset($arrData['pageSize']) ? $arrData['pageSize'] : 10 ;

        $orderBy     = isset($arrData['orderBy']) ? $arrData['orderBy']: "" ;
        $order       = isset($arrData['order']) ? $arrData['order'] : "ASC" ;

        $keyword     = isset($arrData['keyword']) ? $arrData['keyword'] : "" ;

        $query = DB::table($this->TableName);
        if(!empty($keyword)){
            $query->where('order_id','like', '%'.$keyword.'%');
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






    public function getUserLevelById($channel_id)
    {
        return Growth::where('channel_id', '=', $channel_id)->first();
    }

    public function insertUserLevel($arrData)
    {
        return Growth::create($arrData);
    }

    public function updateUserLevel($arrData)
    {
        $channel_id = $arrData['channel_id'];
        return Growth::where('channel_id','=',$channel_id)->update($arrData);
    }

    public function deleteUserLevel($channel_id)
    {
        return Growth::where('channel_id', '=', $channel_id)->delete();
    }

}