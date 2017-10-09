<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Http\Controllers\Controller;
use App\Services\CatalogService;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    protected $catalogService;

    public function __construct(CatalogService $catalogService)
    {
        $this->middleware('auth');
        $this->catalogService = $catalogService;
    }

    public function index(Request $request)
    {
        $act = $request['act'] ? $request['act'] : '' ;
        if($act == 'add'){
            return view('admin/cms/catalog/addCatalog');
        }elseif ($act == 'edit'){
            $data = array();
            $catalog = $this->catalogService->getCatalogById($request['id']);
            $data['catalog'] = $catalog ;
            return view('admin/cms/catalog/editCatalog',$data);
        }else{
            $data = array();
            $data['catalogs'] = $this->catalogService->getCatalogTree(0);
            return view('admin/cms/catalog/index',$data);
        }
    }

    public function saveCatalog(Request $request)
    {
        $this->catalogService->insertCatalog($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function updateCatalog(Request $request)
    {
        $this->catalogService->updateCatalog($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteCatalog($id)
    {
        $this->catalogService->deleteCatalog($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

    public function getCatalogByParent($parent_id)
    {
        $result = $this->catalogService->getCatalogByParent($parent_id);
        return $this->showJsonResult(true, '查询成功', $result);
    }

}
