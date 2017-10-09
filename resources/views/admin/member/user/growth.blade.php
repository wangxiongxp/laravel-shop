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
                <a href="#">成长值明细</a>
            </li>
        </ul>
    </div>

    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12" >
            <div class="portlet light bordered">

                <div class="portlet-body">

                    <div id="data_tables_wrapper" class="dataTables_wrapper dataTables_extended_wrapper no-footer">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label>每页
                                    <select name="data_tables_length" class="m-page-size form-control input-xs input-sm input-inline">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select> 条
                                </label>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <form method="get" action="/admin/growth" >
                                    <div class="input-group input-medium pull-right">
                                        <input id="keyword" name="keyword" value="{{$keyword}}" placeholder="关键字" class="keyword form-control" type="text" />
                                        <span class="input-group-btn"> <button class="btn green searchbutton"> <i class="fa fa-search"></i> </button> </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-scrollable">
                            <table id="data_tables" class="table table-bordered table-hover table-checkable dataTable no-footer" >
                                <thead>
                                <tr role="row">
                                    <th class="sorting_disabled" >#</th>
                                    <th class="sorting" >成长值</th>
                                    <th class="sorting_disabled" >备注</th>
                                    <th class="sorting_disabled" style="width: 120px;" >创建时间</th>
                                    <th class="sorting_disabled" style="width: 80px;" >操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $index=>$item)
                                <tr role="row" class="odd">
                                    <td>{{$index+1}}</td>
                                    <td>{{$item->growth}}</td>
                                    <td>{{$item->remark}}</td>
                                    <td>{{$item->created_at}}</td>
                                    <td>
                                        {{--<a href="javascript:void(0)" class="btn-detail">详情</a>--}}
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">

                            <div class="col-md-7 col-sm-7">
                                <div class="m-page-info" id="data_tables_info" >
                                    第 1 页 ( 共 0 条记录 )
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-5">
                                <div class=" dataTables_paginate paging_bootstrap_full_number" id="data_tables_paginate">
                                    <ul class="m-pagination pagination" style="visibility: visible;">
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
@endsection

@section('foot_script')
<script type="text/javascript" src="/assets/global/plugins/datatables/datatables.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"></script>
<script type="text/javascript" src="/assets/global/scripts/datatable.js" ></script>

<script type="text/javascript" src="/assets/global/scripts/table/pagination.js" ></script>
<script type="text/javascript" src="/assets/global/scripts/table/table.js" ></script>

<script type="text/javascript" >

    var config = {
        id: 'book-infoGrid',
        pageNo: '{{$pageNo}}',
        pageSize: '{{$pageSize}}',
        totalCount: '{{$totalCount}}',
        pageCount: '{{$pageCount}}',
        orderBy: '{{$orderBy}}',
        asc: '{{$asc}}',
        params: {
            'keyword': '{{$keyword}}',
        },
    };

    var table;

    $(function() {
        table = new Table(config);
        table.configPagination('.m-pagination');
        table.configPageInfo('.m-page-info');
        table.configPageSize('.m-page-size');
    });

</script>
@endsection