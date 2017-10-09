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
                <a href="#">会员管理</a>
            </li>
        </ul>
    </div>

    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12" >
            <div class="portlet light bordered">

                <div class="portlet-body">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="javascript:void(0)" > 会员列表 </a>
                        </li>
                        <li>
                            <a href="/admin/growth" > 会员等级 </a>
                        </li>
                        <li>
                            <a href="/admin/growthEvent" > 积分规则 </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="tab_1_1">
                            <div class="portlet-body table-container">
                                <div class="table-group-search-wrapper" style="display:none">
                                    <div class="input-group input-medium pull-right">
                                        <input type="text" id="keyword" name="keyword" placeholder="关键字" class="keyword form-control" />
                                        <span class="input-group-btn">
                                <button class="btn green searchbutton">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                                    </div>
                                </div>
                                <table id="data_tables" class="table table-striped table-bordered table-hover table-checkable order-column" >
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>姓名</th>
                                        <th>邮箱</th>
                                        <th>手机</th>
                                        <th>状态</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                </table>
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

    var table;

    function RenderOptionCol(val,type,item)
    {
        var opts = '';
        opts += '<a href="javascript:void(0)" class="btn-detail">会员详情</a><br/>';
        opts += '<a href="javascript:void(0)" class="btn-login">模拟登陆</a> ';
        return opts;
    }

    $(document).ready(function(){

        var cols = [
            // {data:'accountId',name:'sys_account_id',orderable:false,createdCell:function(cell, cellData, rowData, rowIndex, colIndex){
            //     $(cell).html("<input type='checkbox' name='checkList' value='" + cellData + "'/>")} },
            {data:'account_id',name:'account_id',orderable:false,createdCell:function(cell, cellData, rowData, rowIndex, colIndex){
                $(cell).html(rowIndex+1)} },
            {data:'account_real_name',name:'account_real_name',orderable:true,searchable:true,visible:true,render:function(val){
                return val} },
            {data:'account_email',name:'account_email',orderable:true,searchable:true,render:function(val){
                return val}},
            {data:'account_tel',name:'account_tel',orderable:true,searchable:true,render:function(val){
                return val}},
            {data:'account_status',name:'account_status',orderable:false,searchable:true,render:function(val){
                if(val==1){
                    return '<span class="badge badge-success">正常</span>'
                }else{
                    return '<span class="badge badge-warning">锁定</span>';
                }
            }},
            {data:'','name':'',orderable:false,searchable:false,width:'120px',render:RenderOptionCol },
        ];

        var grid = new Datatable();
        grid.init({
            src: $("#data_tables"),
            dataTable: {
                "columns":cols,
                "ajax": {
                    "url": "/admin/userList/queryUser",
                },
                "order": [
                    [4, "desc"]
                ]
            }
        });

        table = grid.getDataTable();
        table.on('click','td',function(e){
            var rowIndex = table.cell(this).index().row;
            var rowData  = table.row(rowIndex).data();
            if($(e.target).is('.btn-detail')){
                e.stopPropagation();
                GridClickFunction_Detail(rowData);
            }else if($(e.target).is('.btn-login')){
                e.stopPropagation();
                GridClickFunction_Login(rowData);
            }
        });
    });

    function GridClickFunction_Login(item){

    }

    function GridClickFunction_Detail(item){
        var account_id = item.account_id;
        var url = '/admin/userList/userDetail' ;
        location.href = url ;
    }

</script>
@endsection