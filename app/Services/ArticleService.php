<?php

namespace App\Services;

use App\Http\Utils;
use App\Models\Article;
use Illuminate\Support\Facades\DB;

/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class ArticleService
{
    public function __construct()
    {
        $this->PrimaryKey = "id";
        $this->TableName  = 'cms_article';
    }

    public function queryArticle($arrData)
    {
        $draw       = $arrData['draw'] ;
        $keyword    = $arrData['keyword'] ;

        $length     = $arrData['length'] ;
        $start      = $arrData['start'] ;

        $query = DB::table($this->TableName)
            ->leftJoin('cms_catalog','cms_catalog.id', '=', 'cms_article.catalog_id')
            ->select("cms_article.*","cms_catalog.name as cms_catalog_name");

        if(!empty($keyword)){
            $query->where('title','like', '%'.$keyword.'%');
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

    public function getArticleById($id)
    {
        return Article::select("cms_article.*","cms_catalog.name as catalog_name")
            ->leftJoin("cms_catalog","cms_catalog.id", "=", "cms_article.catalog_id")
            ->where('cms_article.id', '=', $id)
            ->first();
    }

    public function insertArticle($arrData)
    {
        if($arrData['status'] == 'PUBLISHED'){
            $arrData['publish_time'] = Utils::GetDatetimeWithUTC();
        }
        return Article::create($arrData);
    }

    public function updateArticle($arrData)
    {
        $id = $arrData['id'];
        if($arrData['status'] == 'PUBLISHED'){
            $arrData['publish_time'] = Utils::GetDatetimeWithUTC();
        }
        return Article::where('id','=',$id)->update($arrData);
    }

    public function deleteArticle($id)
    {
        return Article::where('id', '=', $id)->delete();
    }

    public function updateIsTopStatus($id,$status)
    {
        return Article::where('id','=',$id)->update(["is_top"=>$status]);
    }

    public function updateCommentStatus($id,$status)
    {
        return Article::where('id','=',$id)->update(["allow_comment"=>$status]);
    }

    public function updateVisibilityStatus($id,$status)
    {
        return Article::where('id','=',$id)->update(["visibility"=>$status]);
    }

}