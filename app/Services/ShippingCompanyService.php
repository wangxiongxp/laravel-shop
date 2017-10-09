<?php

namespace App\Services;

use App\Models\ShippingCompany;
use Illuminate\Support\Facades\DB;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class ShippingCompanyService
{

    public function __construct()
    {
        $this->PrimaryKey = "id";
        $this->TableName  = 'shipping_company';
    }

    public function queryShippingCompany($arrData)
    {
        $draw       = $arrData['draw'] ;
        $keyword    = $arrData['keyword'] ;

        $length     = $arrData['length'] ;
        $start      = $arrData['start'] ;

        $query = DB::table($this->TableName);
        if(!empty($keyword)){
            $query->where('company_name','like', '%'.$keyword.'%');
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

    public function getShippingCompany()
    {
        return ShippingCompany::all();
    }

    public function getShippingCompanyById($company_id)
    {
        return ShippingCompany::where('company_id', '=', $company_id)->first();
    }

    public function insertShippingCompany($arrData)
    {
        return ShippingCompany::create($arrData);
    }

    public function updateShippingCompany($arrData)
    {
        $company_id = $arrData['company_id'];
        return ShippingCompany::where('company_id','=',$company_id)->update($arrData);
    }

    public function deleteShippingCompany($company_id)
    {
        return ShippingCompany::where('company_id', '=', $company_id)->delete();
    }

}