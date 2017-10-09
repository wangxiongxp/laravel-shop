<?php

namespace App\Services;

use App\Http\Utils;
use App\Models\SysParam;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class SysParamService
{
    public function __construct()
    {
        $this->PrimaryKey = "param_id";
        $this->TableName  = 'sys_param';
    }

    public function getParamByType($param_type)
    {
        return SysParam::where('param_type', '=', $param_type)->get();
    }

    public function saveParam()
    {
        foreach ($_POST as $key => $value) {
            if(isset($value)){
                SysParam::where('param_key','=',$key)->update(['param_value'=>$value]);
            }
        }
        return true;
    }


}