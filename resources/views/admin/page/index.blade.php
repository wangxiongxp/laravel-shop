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
                <a href="#">页面管理</a>
            </li>
        </ul>
    </div>

    <div class="row" style="margin-top:20px;">
        <div class="col-md-12" >
            <div class="portlet light bordered">
            <!-- Begin: life time stats -->

                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> 页面管理</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided" >
                            <label onclick="GridClickFunction_Add()" class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                <i class="fa fa-plus"></i> 新增页面</label>
                        </div>
                    </div>
                </div>

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
                            <th>页面名称</th>
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
                {data:'page_id',name:'page_id',orderable:true,searchable:true,width:'60px',render:function(val){
                    return val} },
                {data:'page_name',name:'page_name',orderable:true,searchable:true,render:function(val){
                    return val} },
                {data:'status',name:'status',orderable:true,searchable:false,width:'100px',render:function(val){
                    return val == 1 ? '开启' : '关闭'}},
                {data:'','name':'',orderable:false,searchable:false,width:'100px',render:RenderOptionCol },
            ];

            var grid = new Datatable();
            grid.init({
                src: $("#data_tables"),
                dataTable: {
                    "columns":cols,
                    "ajax": {
                        "url": "/admin/page/query",
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
            location.href = '/admin/page?act=add';
        }

        function GridClickFunction_Edit(item){
            var page_id = item.page_id;
            var url = "/admin/page?act=edit&id="+page_id;
            location.href = url ;
        }

        function GridClickFunction_Delete(item){
            var page_id = item.page_id;
            WX.Confirm('确定要删除么？',function(){
                var url = "/admin/page/delete/"+page_id;
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
