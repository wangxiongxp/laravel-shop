<?php

namespace App\Services;

use App\Models\ProductBrand;
use Illuminate\Support\Facades\DB;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class BrandService
{
    protected $roleRepository;

    public function __construct()
    {
        $this->PrimaryKey = "brand_id";
        $this->TableName  = 'product_brand';
    }

    public function queryBrand($arrData)
    {
        $draw       = $arrData['draw'] ;
        $keyword    = $arrData['keyword'] ;

        $length     = $arrData['length'] ;
        $start      = $arrData['start'] ;

        $query = DB::table($this->TableName);
        if(!empty($keyword)){
            $query->where('brand_name','like', '%'.$keyword.'%');
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

    public function getAllBrand()
    {
        return ProductBrand::orderBy('brand_sort')->get();
    }

    public function getBrandById($brand_id)
    {
        return ProductBrand::where('brand_id', '=', $brand_id)->first();
    }

    public function insertBrand($arrData)
    {
        return ProductBrand::create($arrData);
    }

    public function updateBrand($arrData)
    {
        $brand_id = $arrData['brand_id'];
        return ProductBrand::where('brand_id','=',$brand_id)->update($arrData);
    }

    public function deleteBrand($brand_id)
    {
        return ProductBrand::where('brand_id', '=', $brand_id)->delete();
    }

}