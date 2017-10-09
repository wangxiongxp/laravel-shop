<?php

namespace App\Services;

use App\Models\Topic;
use Illuminate\Support\Facades\DB;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class TopicService
{
    protected $roleRepository;

    public function __construct()
    {
        $this->PrimaryKey = "topic_id";
        $this->TableName  = 'topic';
    }

    public function queryTopic($arrData)
    {
        $draw       = $arrData['draw'] ;
        $keyword    = $arrData['keyword'] ;

        $length     = $arrData['length'] ;
        $start      = $arrData['start'] ;

        $query = DB::table($this->TableName);
        if(!empty($keyword)){
            $query->where('topic_title','like', '%'.$keyword.'%');
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

    public function getTopicById($topic_id)
    {
        return Topic::where('topic_id', '=', $topic_id)->first();
    }

    public function insertTopic($arrData)
    {
        return Topic::create($arrData);
    }

    public function updateTopic($arrData)
    {
        $topic_id = $arrData['topic_id'];
        return Topic::where('topic_id','=',$topic_id)->update($arrData);
    }

    public function deleteTopic($topic_id)
    {
        return Topic::where('topic_id', '=', $topic_id)->delete();
    }

}