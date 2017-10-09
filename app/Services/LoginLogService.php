<?php

namespace App\Services;

use App\Models\LoginLog;
use Illuminate\Support\Facades\DB;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class LoginLogService
{
    public function __construct()
    {
        $this->PrimaryKey = "log_id";
        $this->TableName  = 'log_login';
    }

    public function queryLoginLog($arrData)
    {
        $draw       = $arrData['draw'] ;
        $keyword    = $arrData['keyword'] ;

        $length     = $arrData['length'] ;
        $start      = $arrData['start'] ;

        $query = DB::table($this->TableName)
            ->leftJoin('account'  ,'account.account_id' ,'=' ,'log_login.account_id')
            ->select('log_login.*','account.account_name');
        if(!empty($keyword)){
            $query->where('account.account_name','like', '%'.$keyword.'%');
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

    public function insertLoginLog($arrData)
    {
        return LoginLog::create($arrData);
    }

    public function deleteLoginLog($log_id)
    {
        LoginLog::where('log_id', '=', $log_id)->delete();
        return true;
    }

}