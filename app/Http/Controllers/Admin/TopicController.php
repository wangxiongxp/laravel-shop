<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TopicService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TopicController extends Controller
{
    protected $topicService;

    public function __construct(TopicService $topicService)
    {
        $this->middleware('auth');
        $this->topicService = $topicService;
    }

    public function index(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            return view('admin/topic/addTopic');
        }elseif ($act == 'edit'){
            $data = array();
            $topic = $this->topicService->getTopicById($request['id']);
            $data['item'] = $topic ;

            return view('admin/topic/editTopic',$data);
        }else{
            return view('admin/topic/index');
        }

    }

    public function queryTopic(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $result = $this->topicService->queryTopic($queryParam);
        return $this->showPageResult($result);
    }

    public function saveTopic(Request $request)
    {
        $this->topicService->insertTopic($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function updateTopic(Request $request)
    {
        $this->topicService->updateTopic($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteTopic($id)
    {
        $this->topicService->deleteTopic($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

}
