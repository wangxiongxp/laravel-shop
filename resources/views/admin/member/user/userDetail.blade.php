@extends('admin.layouts.default')

@section('head_css')
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/datatables.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css"/>
@endsection

@section('content')
<div class="page-content">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="/">首页</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">会员详情</a>
            </li>
        </ul>
    </div>

    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12" >
            <div class="portlet light bordered">

                <div class="portlet-body">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_userinfo" data-toggle="tab"> 会员信息 </a>
                        </li>
                        <li>
                            <a href="#tab_address" data-toggle="tab"> 收货地址 </a>
                        </li>
                        <li>
                            <a href="#tab_order" data-toggle="tab" > 订单列表 </a>
                        </li>
                        <li>
                            <a href="#tab_collection" data-toggle="tab" > 收藏列表 </a>
                        </li>
                        <li>
                            <a href="#tab_cart" data-toggle="tab"> 购物车 </a>
                        </li>
                        <li>
                            <a href="#tab_coupon" data-toggle="tab" > 优惠券 </a>
                        </li>
                        <li>
                            <a href="#tab_growth" data-toggle="tab" > 成长值 </a>
                        </li>

                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="tab_userinfo">
                            <div class="portlet-body table-container">
                                <form role="form" class="form-horizontal" method="post" id="SaveForm" action="/admin/sysParam/save">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">用户名<span class="required" ></span></label>
                                            <div class="col-md-4">
                                                <input type="text" id="account_name" name="account_name" value="{{$account->account_name}}" placeholder="" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">密码<span class="required" ></span></label>
                                            <div class="col-md-4">
                                                <input type="text" id="password" name="password" value="" placeholder="" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">姓名<span class="required" ></span></label>
                                            <div class="col-md-4">
                                                <input type="text" id="account_real_email" name="account_real_email" value="{{$account->account_real_email}}" placeholder="" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">性别<span class="required" ></span></label>
                                            <div  class="col-md-10" >
                                                <div class="radio-list ">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="account_sex" id="account_sex_0" value="0" checked="checked" />保密
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="account_sex" id="account_sex_1" value="1" />男
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="account_sex" id="account_sex_2" value="2" />女
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">邮箱<span class="required" ></span></label>
                                            <div class="col-md-4">
                                                <input type="text" id="account_email" name="account_email" value="{{$account->account_email}}" placeholder="" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">联系电话<span class="required" ></span></label>
                                            <div class="col-md-4">
                                                <input type="text" id="account_tel" name="account_tel" value="{{$account->account_tel}}" placeholder="" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">地址<span class="required" ></span></label>
                                            <div class="col-md-8">
                                                <input type="text" id="account_address" name="account_address" value="{{$account->account_address}}" placeholder="" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">简介<span class="required" ></span></label>
                                            <div class="col-md-8">
                                                <textarea rows="3" id="account_intro" name="account_intro" class="form-control">{{$account->account_intro}}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">上次登录IP<span class="required" ></span></label>
                                            <div class="col-md-4">
                                                <p class="form-control-static">{{ $account->account_last_ip }}</p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">最后登录时间<span class="required" ></span></label>
                                            <div class="col-md-4">
                                                <p class="form-control-static">{{ $account->account_last_login }}</p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">状态<span class="required" ></span></label>
                                            <div class="col-md-4">
                                                <select class="form-control" id="account_status" name="account_status">
                                                    <option value="1">激活</option>
                                                    <option value="0">禁用</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button class="btn green" type="button" onclick="Function_save()">保存</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_address">
                            <div class="tab-content">
                                <div class="table-scrollable">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th> # </th>
                                            <th> 姓名 </th>
                                            <th> 联系电话 </th>
                                            <th> 详细地址 </th>
                                            <th> 默认地址 </th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($address as $index=>$addr)
                                            <tr>
                                                <td> {{$index+1}} </td>
                                                <td> {{$addr->receiver_name}} </td>
                                                <td> {{$addr->receiver_phone}} </td>
                                                <td> {{$addr->receiver_full_address}} </td>
                                                <td>{{$addr->is_default==1?'是':'否'}} </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_order">
                            <div class="tab-content">
                                <div id="data_tables_wrapper" class="dataTables_wrapper dataTables_extended_wrapper no-footer">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="table-group-search">
                                                <div class="input-group input-medium pull-right">
                                                    <input id="keyword" name="keyword" placeholder="关键字" class="keyword form-control" type="text" />
                                                    <span class="input-group-btn"> <button class="btn green searchbutton"> <i class="fa fa-search"></i> </button> </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-scrollable">
                                        <table id="data_tables" class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer" role="grid" aria-describedby="data_tables_info">
                                            <thead>
                                            <tr role="row">
                                                <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="ID">ID</th>
                                                <th class="sorting" tabindex="0" aria-controls="data_tables" rowspan="1" colspan="1" aria-label="姓名: activate to sort column ascending">姓名</th>
                                                <th class="sorting" tabindex="0" aria-controls="data_tables" rowspan="1" colspan="1" aria-label="邮箱: activate to sort column ascending">邮箱</th>
                                                <th class="sorting" tabindex="0" aria-controls="data_tables" rowspan="1" colspan="1" aria-label="手机: activate to sort column ascending">手机</th>
                                                <th class="sorting_desc" rowspan="1" colspan="1" aria-label="状态">状态</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 120px;" aria-label="操作">操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr role="row" class="odd">
                                                <td>1</td>
                                                <td>张三</td>
                                                <td>zhangsan@163.com</td>
                                                <td>15135163333</td>
                                                <td class="sorting_1"><span class="badge badge-warning">锁定</span></td>
                                                <td><a href="javascript:void(0)" class="btn-detail">会员详情</a><br /><a href="javascript:void(0)" class="btn-login">模拟登陆</a> </td>
                                            </tr>
                                            <tr role="row" class="even">
                                                <td>2</td>
                                                <td>李四</td>
                                                <td>lisi@163.com</td>
                                                <td>15135164444</td>
                                                <td class="sorting_1"><span class="badge badge-warning">锁定</span></td>
                                                <td><a href="javascript:void(0)" class="btn-detail">会员详情</a><br /><a href="javascript:void(0)" class="btn-login">模拟登陆</a> </td>
                                            </tr>
                                            <tr role="row" class="odd">
                                                <td>3</td>
                                                <td>王五</td>
                                                <td>wangwu@163.com</td>
                                                <td>15135165555</td>
                                                <td class="sorting_1"><span class="badge badge-warning">锁定</span></td>
                                                <td><a href="javascript:void(0)" class="btn-detail">会员详情</a><br /><a href="javascript:void(0)" class="btn-login">模拟登陆</a> </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7 col-sm-7">
                                            <div class="dataTables_info" id="data_tables_info" role="status" aria-live="polite">
                                                第 1 页 ( 共 1 页，3 条记录 )
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-sm-5">
                                            <div class="dataTables_paginate paging_bootstrap_full_number" id="data_tables_paginate">
                                                <ul class="pagination" style="visibility: visible;">
                                                    <li class="prev disabled"><a href="#" title="首页"><i class="fa fa-angle-double-left"></i></a></li>
                                                    <li class="prev disabled"><a href="#" title="上一页"><i class="fa fa-angle-left"></i></a></li>
                                                    <li class="active"><a href="#">1</a></li>
                                                    <li class="next disabled"><a href="#" title="下一页"><i class="fa fa-angle-right"></i></a></li>
                                                    <li class="next disabled"><a href="#" title="尾页"><i class="fa fa-angle-double-right"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_collection">
                            <div class="tab-content">
                                <div id="data_tables_wrapper" class="dataTables_wrapper dataTables_extended_wrapper no-footer">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="table-group-search">
                                                <div class="input-group input-medium pull-right">
                                                    <input id="keyword" name="keyword" placeholder="关键字" class="keyword form-control" type="text" />
                                                    <span class="input-group-btn"> <button class="btn green searchbutton"> <i class="fa fa-search"></i> </button> </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-scrollable">
                                        <table id="data_tables" class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer" role="grid" aria-describedby="data_tables_info">
                                            <thead>
                                            <tr role="row">
                                                <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="ID">ID</th>
                                                <th class="sorting" tabindex="0" aria-controls="data_tables" rowspan="1" colspan="1" aria-label="姓名: activate to sort column ascending">姓名</th>
                                                <th class="sorting" tabindex="0" aria-controls="data_tables" rowspan="1" colspan="1" aria-label="邮箱: activate to sort column ascending">邮箱</th>
                                                <th class="sorting" tabindex="0" aria-controls="data_tables" rowspan="1" colspan="1" aria-label="手机: activate to sort column ascending">手机</th>
                                                <th class="sorting_desc" rowspan="1" colspan="1" aria-label="状态">状态</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 120px;" aria-label="操作">操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr role="row" class="odd">
                                                <td>1</td>
                                                <td>张三</td>
                                                <td>zhangsan@163.com</td>
                                                <td>15135163333</td>
                                                <td class="sorting_1"><span class="badge badge-warning">锁定</span></td>
                                                <td><a href="javascript:void(0)" class="btn-detail">会员详情</a><br /><a href="javascript:void(0)" class="btn-login">模拟登陆</a> </td>
                                            </tr>
                                            <tr role="row" class="even">
                                                <td>2</td>
                                                <td>李四</td>
                                                <td>lisi@163.com</td>
                                                <td>15135164444</td>
                                                <td class="sorting_1"><span class="badge badge-warning">锁定</span></td>
                                                <td><a href="javascript:void(0)" class="btn-detail">会员详情</a><br /><a href="javascript:void(0)" class="btn-login">模拟登陆</a> </td>
                                            </tr>
                                            <tr role="row" class="odd">
                                                <td>3</td>
                                                <td>王五</td>
                                                <td>wangwu@163.com</td>
                                                <td>15135165555</td>
                                                <td class="sorting_1"><span class="badge badge-warning">锁定</span></td>
                                                <td><a href="javascript:void(0)" class="btn-detail">会员详情</a><br /><a href="javascript:void(0)" class="btn-login">模拟登陆</a> </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7 col-sm-7">
                                            <div class="dataTables_info" id="data_tables_info" role="status" aria-live="polite">
                                                第 1 页 ( 共 1 页，3 条记录 )
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-sm-5">
                                            <div class="dataTables_paginate paging_bootstrap_full_number" id="data_tables_paginate">
                                                <ul class="pagination" style="visibility: visible;">
                                                    <li class="prev disabled"><a href="#" title="首页"><i class="fa fa-angle-double-left"></i></a></li>
                                                    <li class="prev disabled"><a href="#" title="上一页"><i class="fa fa-angle-left"></i></a></li>
                                                    <li class="active"><a href="#">1</a></li>
                                                    <li class="next disabled"><a href="#" title="下一页"><i class="fa fa-angle-right"></i></a></li>
                                                    <li class="next disabled"><a href="#" title="尾页"><i class="fa fa-angle-double-right"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_cart">
                            <div class="table-scrollable">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> 商品图片 </th>
                                        <th> 商品货号 </th>
                                        <th> 商品标题 </th>
                                        <th> 价格 </th>
                                        <th> 数量 </th>
                                        <th> 库存 </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($carts as $index=>$cart)
                                        <tr>
                                            <td> {{$index+1}} </td>
                                            <td> {{$cart->product_id}} </td>
                                            <td> {{$cart->product_id}} </td>
                                            <td> {{$cart->product_id}} </td>
                                            <td> {{$cart->product_id}} </td>
                                            <td> {{$cart->product_id}} </td>
                                            <td> {{$cart->product_id}} </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_coupon">
                            <div class="tab-content">
                                <div id="data_tables_wrapper" class="dataTables_wrapper dataTables_extended_wrapper no-footer">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="table-group-search">
                                                <div class="input-group input-medium pull-right">
                                                    <input id="keyword" name="keyword" placeholder="关键字" class="keyword form-control" type="text" />
                                                    <span class="input-group-btn"> <button class="btn green searchbutton"> <i class="fa fa-search"></i> </button> </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-scrollable">
                                        <table id="data_tables" class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer" role="grid" aria-describedby="data_tables_info">
                                            <thead>
                                            <tr role="row">
                                                <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="ID">ID</th>
                                                <th class="sorting" tabindex="0" aria-controls="data_tables" rowspan="1" colspan="1" aria-label="姓名: activate to sort column ascending">姓名</th>
                                                <th class="sorting" tabindex="0" aria-controls="data_tables" rowspan="1" colspan="1" aria-label="邮箱: activate to sort column ascending">邮箱</th>
                                                <th class="sorting" tabindex="0" aria-controls="data_tables" rowspan="1" colspan="1" aria-label="手机: activate to sort column ascending">手机</th>
                                                <th class="sorting_desc" rowspan="1" colspan="1" aria-label="状态">状态</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 120px;" aria-label="操作">操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr role="row" class="odd">
                                                <td>1</td>
                                                <td>张三</td>
                                                <td>zhangsan@163.com</td>
                                                <td>15135163333</td>
                                                <td class="sorting_1"><span class="badge badge-warning">锁定</span></td>
                                                <td><a href="javascript:void(0)" class="btn-detail">会员详情</a><br /><a href="javascript:void(0)" class="btn-login">模拟登陆</a> </td>
                                            </tr>
                                            <tr role="row" class="even">
                                                <td>2</td>
                                                <td>李四</td>
                                                <td>lisi@163.com</td>
                                                <td>15135164444</td>
                                                <td class="sorting_1"><span class="badge badge-warning">锁定</span></td>
                                                <td><a href="javascript:void(0)" class="btn-detail">会员详情</a><br /><a href="javascript:void(0)" class="btn-login">模拟登陆</a> </td>
                                            </tr>
                                            <tr role="row" class="odd">
                                                <td>3</td>
                                                <td>王五</td>
                                                <td>wangwu@163.com</td>
                                                <td>15135165555</td>
                                                <td class="sorting_1"><span class="badge badge-warning">锁定</span></td>
                                                <td><a href="javascript:void(0)" class="btn-detail">会员详情</a><br /><a href="javascript:void(0)" class="btn-login">模拟登陆</a> </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7 col-sm-7">
                                            <div class="dataTables_info" id="data_tables_info" role="status" aria-live="polite">
                                                第 1 页 ( 共 1 页，3 条记录 )
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-sm-5">
                                            <div class="dataTables_paginate paging_bootstrap_full_number" id="data_tables_paginate">
                                                <ul class="pagination" style="visibility: visible;">
                                                    <li class="prev disabled"><a href="#" title="首页"><i class="fa fa-angle-double-left"></i></a></li>
                                                    <li class="prev disabled"><a href="#" title="上一页"><i class="fa fa-angle-left"></i></a></li>
                                                    <li class="active"><a href="#">1</a></li>
                                                    <li class="next disabled"><a href="#" title="下一页"><i class="fa fa-angle-right"></i></a></li>
                                                    <li class="next disabled"><a href="#" title="尾页"><i class="fa fa-angle-double-right"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_growth">
                            <div class="tab-content">
                                <div id="data_tables_wrapper" class="dataTables_wrapper dataTables_extended_wrapper no-footer">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="table-group-search">
                                                <div class="input-group input-medium pull-right">
                                                    <input id="keyword" name="keyword" placeholder="关键字" class="keyword form-control" type="text" />
                                                    <span class="input-group-btn"> <button class="btn green searchbutton"> <i class="fa fa-search"></i> </button> </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-scrollable">
                                        <table id="data_tables" class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer" role="grid" aria-describedby="data_tables_info">
                                            <thead>
                                            <tr role="row">
                                                <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="ID">ID</th>
                                                <th class="sorting" tabindex="0" aria-controls="data_tables" rowspan="1" colspan="1" aria-label="姓名: activate to sort column ascending">姓名</th>
                                                <th class="sorting" tabindex="0" aria-controls="data_tables" rowspan="1" colspan="1" aria-label="邮箱: activate to sort column ascending">邮箱</th>
                                                <th class="sorting" tabindex="0" aria-controls="data_tables" rowspan="1" colspan="1" aria-label="手机: activate to sort column ascending">手机</th>
                                                <th class="sorting_desc" rowspan="1" colspan="1" aria-label="状态">状态</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 120px;" aria-label="操作">操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr role="row" class="odd">
                                                <td>1</td>
                                                <td>张三</td>
                                                <td>zhangsan@163.com</td>
                                                <td>15135163333</td>
                                                <td class="sorting_1"><span class="badge badge-warning">锁定</span></td>
                                                <td><a href="javascript:void(0)" class="btn-detail">会员详情</a><br /><a href="javascript:void(0)" class="btn-login">模拟登陆</a> </td>
                                            </tr>
                                            <tr role="row" class="even">
                                                <td>2</td>
                                                <td>李四</td>
                                                <td>lisi@163.com</td>
                                                <td>15135164444</td>
                                                <td class="sorting_1"><span class="badge badge-warning">锁定</span></td>
                                                <td><a href="javascript:void(0)" class="btn-detail">会员详情</a><br /><a href="javascript:void(0)" class="btn-login">模拟登陆</a> </td>
                                            </tr>
                                            <tr role="row" class="odd">
                                                <td>3</td>
                                                <td>王五</td>
                                                <td>wangwu@163.com</td>
                                                <td>15135165555</td>
                                                <td class="sorting_1"><span class="badge badge-warning">锁定</span></td>
                                                <td><a href="javascript:void(0)" class="btn-detail">会员详情</a><br /><a href="javascript:void(0)" class="btn-login">模拟登陆</a> </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7 col-sm-7">
                                            <div class="dataTables_info" id="data_tables_info" role="status" aria-live="polite">
                                                第 1 页 ( 共 1 页，3 条记录 )
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-sm-5">
                                            <div class="dataTables_paginate paging_bootstrap_full_number" id="data_tables_paginate">
                                                <ul class="pagination" style="visibility: visible;">
                                                    <li class="prev disabled"><a href="#" title="首页"><i class="fa fa-angle-double-left"></i></a></li>
                                                    <li class="prev disabled"><a href="#" title="上一页"><i class="fa fa-angle-left"></i></a></li>
                                                    <li class="active"><a href="#">1</a></li>
                                                    <li class="next disabled"><a href="#" title="下一页"><i class="fa fa-angle-right"></i></a></li>
                                                    <li class="next disabled"><a href="#" title="尾页"><i class="fa fa-angle-double-right"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('foot_script')
<script type="text/javascript" src="/assets/global/plugins/datatables/datatables.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"></script>
<script type="text/javascript" src="/assets/global/scripts/datatable.js" ></script>

<script type="text/javascript" >
    $(function(){
        $("#account_status").val({{ $account->account_status}});
        SetRadioSelected('account_sex','{{ $account->account_sex}}');
        App.initUniform();
    })
</script>

<script type="text/javascript" >

    var table;

    function RenderOptionCol(val,type,item)
    {
        var opts = '';
        opts += '<a href="javascript:void(0)" class="btn-edit">编辑</a>&nbsp;&nbsp;';
        opts += '<a href="javascript:void(0)" class="btn-delete">删除</a> ';
        return opts;
    }

    $(document).ready(function(){

        var cols = [
            {data:'id',name:'id',orderable:false,createdCell:function(cell, cellData, rowData, rowIndex, colIndex){
                $(cell).html(rowIndex+1)} },
            {data:'image',name:'image',orderable:false,searchable:false,render:function(val){
                var html = "<img style='width:40px;height:40px;' src='"+val+"'>";
                return html}},
            {data:'name',name:'name',orderable:true,searchable:true,visible:true,render:function(val){
                return val} },
            {data:'min_growth',name:'min_growth',orderable:true,searchable:true,render:function(val){
                return val}},
            {data:'','name':'',orderable:false,searchable:false,width:'80px',render:RenderOptionCol },
        ];

        var grid = new Datatable();
        grid.init({
            src: $("#data_tables"),
            dataTable: {
                "columns":cols,
                "ajax": {
                    "url": "/admin/growth/query",
                },
                "order": [
                    [3, "asc"]
                ]
            }
        });

        table = grid.getDataTable();
        table.on('click','td',function(e){
            var rowIndex = table.cell(this).index().row;
            var rowData  = table.row(rowIndex).data();
            if($(e.target).is('.btn-edit')){
                e.stopPropagation();
                GridClickFunction_Edit(rowData);
            }else if($(e.target).is('.btn-delete')){
                e.stopPropagation();
                GridClickFunction_Delete(rowData);
            }
        });
    });

    function GridClickFunction_Delete(item){
        WX.Confirm('确定要删除么？',function(){
            var url = "/admin/growth/delete/"+item.id;
            AjaxAction({'url':url, 'method':'GET','success':function(data){
                if(data.code == 1) {
                    WX.toastr({'type':'success','message':'删除成功.','onHidden':function(){
                        table.ajax.reload();
                    }});
                } else {
                    WX.toastr({'type':'error','message':'删除失败.'});
                }
            }});
        });
    }

    function GridClickFunction_Add(){
        location.href = '/admin/growth?act=add';
    }

    function GridClickFunction_Edit(item){
        var url = "/admin/growth?act=edit&id="+item.id;
        location.href = url ;
    }

</script>
@endsection