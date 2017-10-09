<?php

namespace App\Services;

use App\Models\AdItem;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class AdItemService
{
    public function __construct()
    {
        $this->PrimaryKey = "ad_item_id";
        $this->TableName  = 'ad_item';
    }

    public function getItemByAd($ad_id)
    {
        return AdItem::where('ad_id', '=', $ad_id)->get();
    }

    public function getItemById($ad_item_id)
    {
        return AdItem::where('ad_item_id', '=', $ad_item_id)->first();
    }

    public function getAdItemByCode($code)
    {
        return AdItem::leftJoin('ad','ad.id', '=', 'ad_item.ad_id')
            ->where('ad.code', '=', $code)->get();
    }

    public function insertAdItem($arrData)
    {
        return AdItem::create($arrData);
    }

    public function updateAdItem($arrData)
    {
        $ad_item_id = $arrData['ad_item_id'];
        return AdItem::where('ad_item_id','=',$ad_item_id)->update($arrData);
    }

    public function deleteAdItem($ad_item_id)
    {
        return AdItem::where('ad_item_id', '=', $ad_item_id)->delete();
    }

}