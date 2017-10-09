<?php

namespace App\Http\Controllers\Web\Personal;

use App\Http\Controllers\Controller;
use App\Services\AccountService;
use App\Services\AddressService;
use App\Services\AdItemService;
use App\Services\AdService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    protected $addressService;

    public function __construct()
    {
        $this->middleware('auth');
        $this->addressService = new AddressService();
    }

    public function index()
    {
        $userInfo = Auth::user();
        $data = array();
        $addrs = $this->addressService->getAddressByAccountId($userInfo->account_id);
        $data['addresses'] = $addrs;
        return view('web/personal/address',$data);
    }

    public function setDefault(Request $request)
    {
        $userInfo = Auth::user();
        $account_id = $userInfo->account_id;
        $address_id = $request['address_id'];
        $this->addressService->setDefault($account_id,$address_id);
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function getAddress(Request $request)
    {
        $result = $this->addressService->getAddress($request);
        return $this->showPageResult($result);
    }

    public function saveAddress(Request $request)
    {
        $this->addressService->insertAddress($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function updateAddress(Request $request)
    {
        $this->addressService->updateAddress($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteAddress($id)
    {
        $this->addressService->deleteAddress($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

}
