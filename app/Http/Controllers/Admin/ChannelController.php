<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ChannelService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChannelController extends Controller
{
    protected $channelService;

    public function __construct(ChannelService $channelService)
    {
        $this->middleware('auth');
        $this->channelService = $channelService;
    }

    public function index(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            return view('admin/channel/addChannel');
        }elseif ($act == 'edit'){
            $data = array();
            $channel = $this->channelService->getChannelById($request['id']);
            $data['item'] = $channel ;

            return view('admin/channel/editChannel',$data);
        }else{
            return view('admin/channel/index');
        }

    }

    public function queryChannel(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $result = $this->channelService->queryChannel($queryParam);
        return $this->showPageResult($result);
    }

    public function saveChannel(Request $request)
    {
        $this->channelService->insertChannel($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function updateChannel(Request $request)
    {
        $this->channelService->updateChannel($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteChannel($id)
    {
        $this->channelService->deleteChannel($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

}
