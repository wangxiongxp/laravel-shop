<?php

namespace App\Services;

use App\Models\FriendLink;
use Illuminate\Support\Facades\DB;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class FriendLinkService
{
    public function __construct()
    {
        $this->PrimaryKey = "link_id";
        $this->TableName  = 'friend_link';
    }

    public function queryFriendLink($arrData)
    {
        $draw       = $arrData['draw'] ;
        $keyword    = $arrData['keyword'] ;

        $length     = $arrData['length'] ;
        $start      = $arrData['start'] ;

        $query = DB::table($this->TableName);
        if(!empty($keyword)){
            $query->where('link_title','like', '%'.$keyword.'%');
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

    public function getFriendLinkById($link_id)
    {
        return FriendLink::where('link_id', '=', $link_id)->first();
    }

    public function insertFriendLink($arrData)
    {
        return FriendLink::create($arrData);
    }

    public function updateFriendLink($arrData)
    {
        $link_id = $arrData['link_id'];
        return FriendLink::where('link_id','=',$link_id)->update($arrData);
    }

    public function deleteFriendLink($link_id)
    {
        FriendLink::where('link_id', '=', $link_id)->delete();
        return true;
    }

}