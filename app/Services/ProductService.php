<?php

namespace App\Services;

use App\Http\Utils;
use App\Models\Product;
use App\Models\ProductAttr;
use App\Models\ProductCat;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class ProductService
{
    public function __construct()
    {
        $this->PrimaryKey = "product_id";
        $this->TableName  = 'product';
    }

    public function queryProduct($arrData)
    {
        $draw       = $arrData['draw'] ;
        $keyword    = $arrData['keyword'] ;

        $length     = $arrData['length'] ;
        $start      = $arrData['start'] ;

        $query = DB::table($this->TableName)
            ->leftJoin("product_category as B","product.product_cat_id","=","B.cat_id")
            ->select("product.*","B.cat_title")
            ->where("product.product_status","!=","-1");
        if(!empty($keyword)){
            $query->where('product_title','like', '%'.$keyword.'%');
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

    public function getProductById($product_id)
    {
        return Product::where('product_id', '=', $product_id)->first();
    }

    public function getProductInfoById($product_id)
    {
        $data = array();
        $data['product'] = Product::where('product_id', '=', $product_id)->first();

        $data['product_cat'] = ProductCat::where('cat_id', '=', $data['product']->product_cat_id)->first();

        $attrs = ProductAttr::where('product_id', '=', $product_id)
            ->leftJoin("product_category_attr","product_attr.attr_id","=","product_category_attr.attr_id")
            ->select("product_attr.*","product_category_attr.attr_type")->get();
        $data['product_attr'] = json_encode($attrs);

        $data['product_images'] = ProductImage::where('product_id', '=', $product_id)->get();
        return $data;
    }

    public function insertProduct($arrData)
    {

        //保存产品信息
        $productInfo = array();
        $productInfo['product_cat_id'] = $arrData['product_cat_id'] ;
        $productInfo['product_title']  = $arrData['product_title'] ;
        $productInfo['product_sub_title'] = $arrData['product_sub_title'] ;
        $productInfo['product_price']  = $arrData['product_price'] ;
        $productInfo['product_qty']    = $arrData['product_qty'] ;
        $productInfo['product_status'] = $arrData['product_status'] ;
        $productInfo['product_desc']   = $arrData['product_desc'] ;
        $productInfo['product_image']  = $arrData ['image_url'][0] ;

        $product = Product::create($arrData);

        //保存产品图片
        $arrImageUrl  = $arrData ['image_url'] ;
        $arrImageName = $arrData ['image_name'] ;
        if (is_array ( $arrImageUrl ) ) {
            for($i=0;$i<count($arrImageUrl);$i++){
                $productImage = array();
                $productImage['image_url']   = $arrImageUrl[$i] ;
                $productImage['image_title'] = $arrImageName[$i] ; ;
                $productImage['product_id']  = $product['product_id'] ;
                $productImage['is_major']    = $i == 0?1:0 ;

                ProductImage::create($productImage);
            }
        }

        //保存产品attr
        $attrs = $arrData['attr_data'];
        if (get_magic_quotes_gpc () == 1) {
            $attrs = stripslashes ( $attrs );
        }
        $objAttr = Utils::object_to_array ( json_decode ( $attrs ) );
        if (count ( $objAttr ) > 0) {
            foreach ( $objAttr as $attr ) {
                $arrParam = array ();
                $arrParam ['product_id'] = $product['product_id'];
                $arrParam ['attr_id']    = $attr ['attr_id'];
                $arrParam ['attr_value'] = isset($attr ['attr_value'])?$attr ['attr_value']:null;
                $arrParam ['option_id']  = isset($attr ['option_id'])?$attr ['option_id']:null;
                $arrParam ['option_value'] = isset($attr ['option_value'])?$attr ['option_value']:null;

                ProductAttr::create($arrParam);
            }
        }

        return true ;
    }

    public function updateProduct($arrData)
    {

        $product_id = $arrData['product_id'];

        //保存产品信息
        $productInfo = array();
        $productInfo['product_cat_id'] = $arrData['product_cat_id'] ;
        $productInfo['product_title']  = $arrData['product_title'] ;
        $productInfo['product_sub_title'] = $arrData['product_sub_title'] ;
        $productInfo['product_price']  = $arrData['product_price'] ;
        $productInfo['product_qty']    = $arrData['product_qty'] ;
        $productInfo['product_status'] = $arrData['product_status'] ;
        $productInfo['product_desc']   = $arrData['product_desc'] ;
        $productInfo['product_image']  = $arrData ['image_url'][0] ;

        $product = Product::where('product_id','=',$product_id)->update($productInfo);

        //保存产品图片
        ProductImage::where("product_id","=",$product_id)->delete();

        $arrImageUrl  = $arrData ['image_url'] ;
        $arrImageName = $arrData ['image_name'] ;
        if (is_array ( $arrImageUrl ) ) {
            for($i=0;$i<count($arrImageUrl);$i++){
                $productImage = array();
                $productImage['image_url']   = $arrImageUrl[$i] ;
                $productImage['image_title'] = $arrImageName[$i] ; ;
                $productImage['product_id']  = $product_id ;
                $productImage['is_major']    = $i == 0?1:0 ;

                ProductImage::create($productImage);
            }
        }

        //保存产品attr
        ProductAttr::where("product_id","=",$product_id)->delete();

        $attrs = $arrData['attr_data'];
        if (get_magic_quotes_gpc () == 1) {
            $attrs = stripslashes ( $attrs );
        }
        $objAttr = Utils::object_to_array ( json_decode ( $attrs ) );
        if (count ( $objAttr ) > 0) {
            foreach ( $objAttr as $attr ) {
                $arrParam = array ();
                $arrParam ['product_id'] = $product_id;
                $arrParam ['attr_id']    = $attr ['attr_id'];
                $arrParam ['attr_value'] = isset($attr ['attr_value'])?$attr ['attr_value']:null;
                $arrParam ['option_id']  = isset($attr ['option_id'])?$attr ['option_id']:null;
                $arrParam ['option_value'] = isset($attr ['option_value'])?$attr ['option_value']:null;

                ProductAttr::create($arrParam);
            }
        }

        return true ;
    }

    public function deleteProduct($product_id)
    {
        return Product::where('product_id', '=', $product_id)->delete();
    }

    public function updateStatus($product_id,$status)
    {
        return Product::where('product_id', '=', $product_id)->update(["product_status"=>$status]);
    }

}