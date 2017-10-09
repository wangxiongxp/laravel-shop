<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MessageService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MessageController extends Controller
{
    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->middleware('auth');
        $this->messageService = $messageService;
    }

    public function index(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            return view('admin/message/addMessage');
        }elseif ($act == 'edit'){
            $data = array();
            $message = $this->messageService->getMessageById($request['id']);
            $data['item'] = $message ;

            return view('admin/message/editMessage',$data);
        }else{
            return view('admin/message/index');
        }

    }

    public function queryMessage(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $result = $this->messageService->queryMessage($queryParam);
        return $this->showPageResult($result);
    }

    public function saveMessage(Request $request)
    {
        $this->messageService->insertMessage($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function updateMessage(Request $request)
    {
        $this->messageService->updateMessage($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteMessage($id)
    {
        $this->messageService->deleteMessage($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

}
