<?php

namespace App\Services;

use App\Models\GrowthEvent;
use Illuminate\Support\Facades\DB;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class GrowthEventService
{
    protected $roleRepository;

    public function __construct()
    {
        $this->PrimaryKey = "id";
        $this->TableName  = 'growth_event';
    }

    public function queryGrowthEvent($arrData)
    {
        $draw       = $arrData['draw'] ;
        $keyword    = $arrData['keyword'] ;

        $length     = $arrData['length'] ;
        $start      = $arrData['start'] ;

        $query = DB::table($this->TableName);
        if(!empty($keyword)){
            $query->where('name','like', '%'.$keyword.'%');
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

    public function getGrowthEventById($id)
    {
        return GrowthEvent::where('id', '=', $id)->first();
    }

    public function insertGrowthEvent($arrData)
    {
        $arrData['status'] = 1 ;
        return GrowthEvent::create($arrData);
    }

    public function updateGrowthEvent($arrData)
    {
        if(isset($arrData['status']) && $arrData['status'] == 'on'){
            $arrData['status'] = 1 ;
        }else{
            $arrData['status'] = 0 ;
        }

        $id = $arrData['id'];
        return GrowthEvent::where('id','=',$id)->update($arrData);
    }

    public function deleteGrowthEvent($id)
    {
        return GrowthEvent::where('id', '=', $id)->delete();
    }

}