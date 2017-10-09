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
                <a href="#">配送方式</a>
            </li>
        </ul>
    </div>

    <div class="row" style="margin-top:20px;">
        <div class="col-md-12" >
            <div class="portlet light bordered">
            <!-- Begin: life time stats -->

                <div class="portlet-body">

                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="javascript:void(0)" > 运费模板 </a>
                        </li>
                        <li>
                            <a href="/admin/shippingCompany" > 物流公司 </a>
                        </li>

                        <div style="float:right">
                            <label onclick="GridClickFunction_Add()" class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                <i class="fa fa-plus"></i> 新增运费模板</label>
                        </div>

                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade active in" >
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
                                        <th>序号</th>
                                        <th>模板名称</th>
                                        <th>发货时间</th>
                                        <th>是否包邮</th>
                                        <th>配送物流</th>
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
            opts += '<a href="javascript:void(0)" class="btn-edit">编辑</a>&nbsp;&nbsp;';
            opts += '<a href="javascript:void(0)" class="btn-delete">删除</a> ';
            return opts;
        }

        $(document).ready(function(){
            var cols = [
                {data:'shipping_id',name:'shipping_id',orderable:true,searchable:false,width:'60px',render:function(val){
                    return val} },
                {data:'shipping_name',name:'shipping_name',orderable:false,searchable:true,render:function(val){
                    return val} },
                {data:'delivery_time',name:'delivery_time',orderable:false,searchable:false,width:'80px',render:function(val){
                    return val+"天内"} },
                {data:'is_free',name:'is_free',orderable:true,searchable:true,width:'80px',render:function(val){
                    return val == 1 ? '包邮' : '不包邮'}},
                {data:'company_name',name:'company_name',orderable:false,searchable:false,render:function(val){
                    return val}},
                {data:'','name':'',orderable:false,searchable:false,width:'80px',render:RenderOptionCol },
            ];

            var grid = new Datatable();
            grid.init({
                src: $("#data_tables"),
                dataTable: {
                    "columns":cols,
                    "ajax": {
                        "url": "/admin/shipping/query",
                    },
                    "order": [
                        [0, "asc"]
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

        function GridClickFunction_Add(){
            var url = '/admin/shipping?act=add';
            location.href = url;
        }

        function GridClickFunction_Edit(item){
            var shipping_id = item.shipping_id;
            var url = "/admin/shipping?act=edit&id="+shipping_id;
            location.href = url;
        }

        function GridClickFunction_Delete(item){
            var shipping_id = item.shipping_id;
            WX.Confirm('确定要删除么？',function(){
                var url = "/admin/shipping/delete/"+shipping_id;
                AjaxAction({'url':url,'method':"GET", 'success':function(data){
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

    </script>
@endsection
