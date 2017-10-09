<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->middleware('auth');
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        return view('admin/order/index');
    }

    public function queryOrder(Request $request)
    {
        $queryParam = $this->buildSearchParam($request);
        $result = $this->orderService->queryOrder($queryParam);
        return $this->showPageResult($result);
    }

    public function saveOrder(Request $request)
    {
        $this->orderService->insertOrder($request->all());
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function updateOrder(Request $request)
    {
        $this->orderService->updateOrder($request->all());
        return $this->showJsonResult(true, '更新成功', null);
    }

    public function deleteOrder($id)
    {
        $this->orderService->deleteOrder($id);
        return $this->showJsonResult(true, '删除成功', null);
    }

}
