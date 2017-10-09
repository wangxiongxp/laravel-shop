<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PageService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PageController extends Controller
{
    protected $pageService;

    public function __construct(PageService $pageService)
    {
        $this->middleware('auth');
        $this->pageService = $pageService;
    }

    public function index(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            return view('admin/page/addPage');
        }elseif ($act == 'edit'){
            $data = array();
            $page = $this->pageService->getPageById($request['id']);
            $data['item'] = $page ;

            return view('admin/page/editPage',$data);
        }else{
            return view('admin/page/index');
        }

    }

    public function queryPage(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $result = $this->pageService->queryPage($queryParam);
        return $this->showPageResult($result);
    }

    public function savePage(Request $request)
    {
        $this->pageService->insertPage($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function updatePage(Request $request)
    {
        $this->pageService->updatePage($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deletePage($id)
    {
        $this->pageService->deletePage($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

}
