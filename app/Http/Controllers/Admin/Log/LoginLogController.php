<?php

namespace App\Http\Controllers\Admin\Log;

use App\Http\Controllers\Controller;
use App\Services\LoginLogService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginLogController extends Controller
{
    protected $loginLogService;

    public function __construct(LoginLogService $loginLogService)
    {
        $this->middleware('auth');
        $this->loginLogService = $loginLogService;
    }

    public function index()
    {
        return view('admin/log/loginLog/index');
    }

    public function queryLoginLog(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $result = $this->loginLogService->queryLoginLog($queryParam);
        return $this->showPageResult($result);
    }

    public function deleteLoginLog($id)
    {
        $this->loginLogService->deleteLoginLog($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

}
