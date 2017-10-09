<?php

namespace App\Http\Controllers\Web\Personal;

use App\Http\Controllers\Controller;
use App\Services\AccountService;
use App\Services\AddressService;
use App\Services\AdItemService;
use App\Services\AdService;
use App\Services\CollectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    protected $collectionService;

    public function __construct()
    {
        $this->middleware('auth');
        $this->collectionService = new CollectionService();
    }

    public function index()
    {
        $userInfo = Auth::user();
        $data = array();
        return view('web/personal/collection',$data);
    }

    public function queryCollection(Request $request)
    {
        $page      = $request['page']?$request['page']:1;
        $limit     = $request['limit']?$request['limit']:8;

        $queryParam = array();
        $queryParam['account_id'] = Auth::user()->account_id;
        $queryParam['page']  = $page;
        $queryParam['limit'] = $limit;

        $result = $this->collectionService->queryCollection($queryParam);

        return $this->showJsonResult(true,"查询成功",$result);
    }





}
