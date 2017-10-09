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
                    <a href="#">互动营销</a>
                </li>
            </ul>
        </div>

        <div class="row" style="margin-top:20px;">
            <div class="col-md-12" >
                <div class="portlet light bordered">
                    <!-- Begin: life time stats -->

                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <span class="caption-subject bold uppercase"> 摇一摇</span>
                        </div>
                        <div class="actions">
                            <div class="btn-group btn-group-devided" >
                                <label onclick="GridClickFunction_Add()" class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                    <i class="fa fa-plus"></i> 新增活动</label>
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
                                <th>名称</th>
                                <th>开始时间</th>
                                <th>结束时间</th>
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
                {data:'award_id',name:'award_id',orderable:true,searchable:true,width:'60px',render:function(val){
                    return val} },
                {data:'award_name',name:'award_name',orderable:true,searchable:true,render:function(val){
                    return val} },
                {data:'start_time',name:'start_time',orderable:false,searchable:false,render:function(val){
                    return val}},
                {data:'end_time',name:'end_time',orderable:false,searchable:false,render:function(val){
                    return val}},
                {data:'status',name:'status',orderable:false,searchable:false,width:'100px',render:function(val){
                    return val == 1 ? '开启' : '关闭'}},
                {data:'','name':'',orderable:false,searchable:false,width:'100px',render:RenderOptionCol },
            ];

            var grid = new Datatable();
            grid.setAjaxParam('award_type','5');
            grid.init({
                src: $("#data_tables"),
                dataTable: {
                    "columns":cols,
                    "ajax": {
                        "url": "/admin/award/query",
                    },
                    "order": [
                        [0, "asc"]
                    ]
                }
            });

            table = grid.getDataTable();
            grid.setAjaxParam('award_type','5');
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
            var url = '/admin/award/shake?act=add';
            location.href = url;
        }

        function GridClickFunction_Edit(item){
            var id = item.award_id;
            var url = "/admin/award/shake?act=edit&id="+id;
            location.href = url;
        }

        function GridClickFunction_Delete(item){
            var award_id = item.award_id;
            WX.Confirm('确定要删除么？',function(){
                var url = "/admin/award/delete/"+award_id;
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
