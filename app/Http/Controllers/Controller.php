<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function buildSearchParam($request){

        //获取客户端需要那一列排序
        if(isset($request["order"])){
            $orderColumn = $request["order"][0]["column"] ;
            $orderColumn = $request["columns"][$orderColumn]["name"] ;
        }else{
            $orderColumn = null;
        }

        //获取排序方式 默认为asc
        $orderDir    = $request["order"][0]["dir"];
        //获取查询关键字
        $keyword     = $request["keyword"];
        $draw        = $request["draw"];

        //每页显示数量
        $length   = $request["length"] ? $request["length"] : 10;
        //第几条开始
        $start    = $request["start"] ? $request["start"] : 0;

        $result = array();
        $result['draw']     = $draw ;
        $result['length']   = $length ;
        $result['start']    = $start ;
        $result['keyword']  = $keyword ;
        if(!empty($orderColumn)){
            $result["orderBy"] = $orderColumn . "." . $orderDir ;
        }
        $result['param'] = $request->all();
        return $result;
    }

    function showPageResult($data){
        return response()->json($data, Response::HTTP_OK);
    }

    function showJsonResult($code, $msg , $data = array()){
        $result = array();
        $result['code']	= $code ? 1 : 0 ;
        $result['msg']  = $msg ;
        $result['data']	= $data ;
        return response()->json($result, Response::HTTP_OK) ;
    }


}
