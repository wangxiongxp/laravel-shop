<?php

namespace App\Services;

use App\Models\Award;
use App\Models\AwardReward;
use Illuminate\Support\Facades\DB;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class AwardService
{
    public function __construct()
    {
        $this->PrimaryKey = "id";
        $this->TableName  = 'award';
    }

    public function queryAward($arrData)
    {
        $draw       = $arrData['draw'] ;
        $keyword    = $arrData['keyword'] ;

        $length     = $arrData['length'] ;
        $start      = $arrData['start'] ;

        $query = DB::table($this->TableName)
                ->where("award_type", $arrData['award_type']);

        if(!empty($keyword)){
            $query->where('award_title','like', '%'.$keyword.'%');
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

    public function getAwardById($award_id)
    {
        return Award::where('award_id', '=', $award_id)->first();
    }

    public function insertAward($arrData)
    {
        return Award::create($arrData);
    }

    public function updateAward($arrData)
    {
        $award_id = $arrData['award_id'];

        $arrParam = array();
        $arrParam['award_type'] = $arrData['award_type'];
        $arrParam['award_name'] = $arrData['award_name'];
        $arrParam['award_desc'] = $arrData['award_desc'];
        $arrParam['start_time'] = $arrData['start_time'];
        $arrParam['end_time']   = $arrData['end_time'];
        $arrParam['cost_point'] = $arrData['cost_point'];
        $arrParam['give_point'] = $arrData['give_point'];
        $arrParam['give_point_to_loser'] = $arrData['give_point_to_loser'];
        $arrParam['time_limit'] = $arrData['time_limit'];
        $arrParam['probability'] = $arrData['probability'];
        $arrParam['failed_desc'] = $arrData['failed_desc'];

        return Award::where('award_id','=',$award_id)->update($arrParam);
    }

    public function deleteAward($id)
    {
        Award::where('award_id', '=', $id)->delete();
        AwardReward::where('award_id', '=', $id)->delete();
        return true;
    }

}