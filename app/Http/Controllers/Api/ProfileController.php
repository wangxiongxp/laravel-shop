<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AccountService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->middleware('auth');
        $this->accountService = $accountService;
    }


    public function getAccountById(Request $request)
    {
        $account = $request->user();
        $result = $this->accountService->getAccountById($account->account_id);
        return $this->showJsonResult(true,'查询成功',$result);
    }


}
