<?php

namespace App\Services;

use App\Models\Channel;
use Illuminate\Support\Facades\DB;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class ChannelService
{
    protected $roleRepository;

    public function __construct()
    {
        $this->PrimaryKey = "channel_id";
        $this->TableName  = 'channel';
    }

    public function queryChannel($arrData)
    {
        $draw       = $arrData['draw'] ;
        $keyword    = $arrData['keyword'] ;

        $length     = $arrData['length'] ;
        $start      = $arrData['start'] ;

        $query = DB::table($this->TableName)
            ->leftJoin('product_category','channel.category_id','=','product_category.cat_id')
            ->select('channel.*','product_category.cat_title');

        if(!empty($keyword)){
            $query->where('channel_title','like', '%'.$keyword.'%');
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

    public function getAllChannel()
    {
        return Channel::all();
    }

    public function getChannelById($channel_id)
    {
        return Channel::where('channel_id', '=', $channel_id)->first();
    }

    public function insertChannel($arrData)
    {
        return Channel::create($arrData);
    }

    public function updateChannel($arrData)
    {
        $channel_id = $arrData['channel_id'];
        return Channel::where('channel_id','=',$channel_id)->update($arrData);
    }

    public function deleteChannel($channel_id)
    {
        return Channel::where('channel_id', '=', $channel_id)->delete();
    }

}