<?php

namespace App\Http\Controllers\Web\Personal;

use App\Http\Controllers\Controller;
use App\Services\AccountService;
use App\Services\AddressService;
use App\Services\AdItemService;
use App\Services\AdService;
use App\Services\FootService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FootController extends Controller
{
    protected $footService;

    public function __construct()
    {
        $this->middleware('auth');
        $this->footService = new FootService();
    }

    public function index()
    {
        $userInfo = Auth::user();
        $data = array();
        return view('web/personal/foot',$data);
    }

    public function queryFoot(Request $request)
    {
        $page      = $request['page']?$request['page']:1;
        $limit     = $request['limit']?$request['limit']:8;

        $queryParam = array();
        $queryParam['account_id'] = Auth::user()->account_id;
        $queryParam['page']  = $page;
        $queryParam['limit'] = $limit;

        $result = $this->footService->queryFoot($queryParam);

        return $this->showJsonResult(true,"查询成功",$result);
    }


}
