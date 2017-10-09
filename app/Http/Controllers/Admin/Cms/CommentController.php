<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Http\Controllers\Controller;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->middleware('auth');
        $this->commentService = $commentService;
    }

    public function index()
    {
        return view('admin/cms/comment/index');
    }

    public function queryComment(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $result = $this->commentService->queryComment($queryParam);
        return $this->showPageResult($result);
    }

    public function addComment(){
        return view('admin/cms/comment/addComment');
    }

    public function saveComment(Request $request)
    {
        $this->commentService->insertComment($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function viewComment($id){
        $data = array();
        $comment = $this->commentService->getCommentById($id);
        $data['comment'] = $comment ;
        return view('admin/cms/comment/viewComment',$data);
    }

    public function editComment($id){
        $data = array();
        $comment = $this->commentService->getCommentById($id);
        $data['comment'] = $comment ;
        return view('admin/cms/comment/editComment',$data);
    }

    public function updateComment(Request $request)
    {
        $this->commentService->updateComment($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function updateStatus(Request $request)
    {
        $this->commentService->updateStatus($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteComment($id)
    {
        $this->commentService->deleteComment($id);
        return $this->showJsonResult(true, '删除成功', null);
    }


}
