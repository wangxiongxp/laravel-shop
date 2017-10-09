<?php

namespace App\Services;

use App\Models\Shipping;
use Illuminate\Support\Facades\DB;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class ShippingService
{
    protected $roleRepository;

    public function __construct()
    {
        $this->PrimaryKey = "shipping_id";
        $this->TableName  = 'shipping';
    }

    public function queryShipping($arrData)
    {
        $draw       = $arrData['draw'] ;
        $keyword    = $arrData['keyword'] ;

        $length     = $arrData['length'] ;
        $start      = $arrData['start'] ;

        $query = DB::table($this->TableName)
            ->leftJoin("shipping_company",'shipping.company_id','=','shipping_company.company_id')
            ->select('shipping.*','shipping_company.company_name');

        if(!empty($keyword)){
            $query->where('shipping_name','like', '%'.$keyword.'%');
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

    public function getShippingById($shipping_id)
    {
        return Shipping::where('shipping_id', '=', $shipping_id)->first();
    }

    public function insertShipping($arrData)
    {
        return Shipping::create($arrData);
    }

    public function updateShipping($arrData)
    {
        $shipping_id = $arrData['shipping_id'];
        return Shipping::where('shipping_id','=',$shipping_id)->update($arrData);
    }

    public function deleteShipping($shipping_id)
    {
        return Shipping::where('shipping_id', '=', $shipping_id)->delete();
    }

}