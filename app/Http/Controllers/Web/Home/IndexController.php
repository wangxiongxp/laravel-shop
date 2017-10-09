<?php

namespace App\Http\Controllers\Web\Home;

use App\Http\Controllers\Controller;
use App\Services\AdItemService;
use App\Services\AdService;
use App\Services\ChannelService;
use App\Services\MallChannelService;
use App\Services\ProductCatService;
use App\Services\ProductCatViewService;

class IndexController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {

        $data = array();

        //首页轮播广告
        $adItemService = new AdItemService();
        $ads = $adItemService->getAdItemByCode("ad_index_slider");
        $data['ad_slider'] = $ads;

        $productCatService = new ProductCatService();

        //侧边导航
        $cats = $productCatService->getCatalogByParent(0);
        $data['side_nav'] = $cats;

        //楼层导航
        $channelService = new ChannelService();
        $channels = $channelService->getAllChannel();
        $data['channels'] = $channels;

        return view('web/home/index',$data);
    }

    public function category()
    {
        $data = array();
        $productCatService = new ProductCatService();
        $data['cats'] = $productCatService->GetCategoryTree(0);
        return view('web/home/category',$data);
    }

    public function introduction($product_id)
    {
        $data = array();

        return view('web/home/introduction',$data);
    }

    public function search()
    {
        $data = array();

        return view('web/home/search',$data);
    }

    public function cart()
    {
        $data = array();

        return view('web/home/shopCart',$data);
    }

}
