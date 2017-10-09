<?php

namespace App\Http\Controllers\Web\Personal;

use App\Http\Controllers\Controller;
use App\Services\AccountService;
use App\Services\AdItemService;
use App\Services\AdService;
use App\Services\MallChannelService;
use App\Services\ProductCatViewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        return view('web/personal/profile');
    }

    public function information()
    {
        $userInfo = Auth::user();
        $account_id = $userInfo->account_id;
        $accountService = new AccountService();
        $accountInfo = $accountService->getAccountById($account_id);
        $data = array();
        $data['userInfo'] = $accountInfo;

        return view('web/personal/information',$data);
    }

    public function updateInformation(Request $request)
    {
        $userInfo = Auth::user();
        $request['account_id'] = $userInfo->account_id;
        $accountService = new AccountService();
        $accountService->updateAccount($request->all());

        return $this->showJsonResult(true,"保存成功",null);
    }

    public function safety()
    {
        return view('web/personal/safety');
    }

    public function password()
    {
        return view('web/personal/password');
    }

    public function bindPhone()
    {
        return view('web/personal/bindPhone');
    }

    public function email()
    {
        return view('web/personal/email');
    }

    public function idCard()
    {
        return view('web/personal/idCard');
    }

    public function question()
    {
        return view('web/personal/question');
    }

    public function setPay()
    {
        return view('web/personal/setPay');
    }

}
