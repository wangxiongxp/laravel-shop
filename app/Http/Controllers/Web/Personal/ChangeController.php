<?php

namespace App\Http\Controllers\Web\Personal;

use App\Http\Controllers\Controller;
use App\Services\AccountService;
use App\Services\AddressService;
use App\Services\AdItemService;
use App\Services\AdService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChangeController extends Controller
{
    protected $orderService;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userInfo = Auth::user();
        $data = array();
        return view('web/personal/change',$data);
    }

    public function record()
    {
        $userInfo = Auth::user();
        $data = array();
        return view('web/personal/record',$data);
    }

}