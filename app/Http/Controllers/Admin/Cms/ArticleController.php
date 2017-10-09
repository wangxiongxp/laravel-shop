<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Http\Controllers\Controller;
use App\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->middleware('auth');
        $this->articleService = $articleService;
    }

    public function index(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            return view('admin/cms/article/addArticle');
        }elseif ($act == 'edit'){
            $data = array();
            $article = $this->articleService->getArticleById($request['id']);
            $data['article'] = $article ;
            return view('admin/cms/article/editArticle',$data);
        }else{
            return view('admin/cms/article/index');
        }
    }

    public function queryArticle(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $result = $this->articleService->queryArticle($queryParam);
        return $this->showPageResult($result);
    }

    public function saveArticle(Request $request)
    {
        $this->articleService->insertArticle($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function updateArticle(Request $request)
    {
        $this->articleService->updateArticle($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteArticle($id)
    {
        $this->articleService->deleteArticle($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

    public function updateIsTopStatus($id,$status)
    {
        $this->articleService->updateIsTopStatus($id,$status);
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function updateCommentStatus($id,$status)
    {
        $this->articleService->updateCommentStatus($id,$status);
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function updateVisibilityStatus($id,$status)
    {
        $this->articleService->updateVisibilityStatus($id,$status);
        return $this->showJsonResult(true, '更新成功', null);
    }

}
