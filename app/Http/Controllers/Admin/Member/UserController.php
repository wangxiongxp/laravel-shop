<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\Services\AccountService;
use App\Services\AddressService;
use App\Services\CartService;
use App\Services\CollectionService;
use App\Services\GrowthDetailService;
use App\Services\UserAddressService;
use App\Services\UserCartService;
use App\Services\UserCollectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin/member/user/userList');
    }

    public function queryUser(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $queryParam['account_type'] = 2 ;//2为会员账号
        $accountService = new AccountService();
        $result = $accountService->queryAccount($queryParam);
        return $this->showPageResult($result);
    }

    public function userDetail()
    {
        $account = Auth::user();
        $data = array();
        $data['account'] = $account;

        $addressService = new UserAddressService();
        $data['address'] = $addressService->getUserAddressByAccountId($account->account_id);

        $cartService = new UserCartService();
        $data['carts'] = $cartService->getCartByAccountId($account->account_id);



        return view('admin/member/user/userDetail', $data);
    }

    public function growth(Request $request)
    {
        $growthDetailService = new GrowthDetailService();
        $result = $growthDetailService->queryGrowthDetail($request->all());
        return view('admin/member/user/growth', $result);
    }

    public function shopCart(Request $request)
    {
        $cartService = new UserCartService();
        $result = $cartService->queryUserCart($request->all());
        return view('admin/member/user/shopCart', $result);
    }

    public function collection(Request $request)
    {
        $collectionService = new UserCollectionService();
        $result = $collectionService->queryUserCollection($request->all());
        return view('admin/member/user/collection', $result);
    }

}
