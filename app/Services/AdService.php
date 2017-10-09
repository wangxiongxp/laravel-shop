<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\AdItem;
use Illuminate\Support\Facades\DB;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class AdService
{
    public function __construct()
    {
        $this->PrimaryKey = "id";
        $this->TableName  = 'ad';
    }

    public function queryAd($arrData)
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

    public function getAdById($id)
    {
        return Ad::where('id', '=', $id)->first();
    }

    public function insertAd($arrData)
    {
        return Ad::create($arrData);
    }

    public function updateAd($arrData)
    {
        $id = $arrData['id'];
        return Ad::where('id','=',$id)->update($arrData);
    }

    public function deleteAd($id)
    {
        Ad::where('id', '=', $id)->delete();
        AdItem::where('ad_id', '=', $id)->delete();
        return true;
    }

}