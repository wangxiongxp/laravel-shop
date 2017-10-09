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
                <a href="#">角色管理</a>
            </li>
        </ul>
    </div>

    <div class="row" style="margin-top:20px;">
        <div class="col-md-12" >
            <div class="portlet light bordered">
            <!-- Begin: life time stats -->

                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> 角色设定</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided" >
                            <label onclick="GridClickFunction_Add()" class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                <i class="fa fa-plus"></i> 新增角色</label>
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
                            <th>角色名称</th>
                            <th>备注</th>
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

    <script>

        var table;

        function RenderOptionCol(val,type,item)
        {
            var opts = '';
            opts += '<a href="javascript:void(0)" class="btn-edit">编辑角色</a><br/>';
            opts += '<a href="javascript:void(0)" class="btn-menu">菜单设定</a><br/>';
            opts += '<a href="javascript:void(0)" class="btn-delete">删除角色</a> ';
            return opts;
        }

        $(document).ready(function(){
            var cols = [
                {data:'s_role_id',name:'s_role_id',orderable:false,createdCell:function(cell, cellData, rowData, rowIndex, colIndex){
                    $(cell).html(rowIndex+1)} },
                {data:'s_role_id',name:'s_role_id',orderable:true,searchable:true,visible:false,render:function(val){
                    return val} },
                {data:'s_role_name',name:'s_role_name',orderable:true,searchable:true,visible:true,render:function(val){
                    return val} },
                {data:'s_role_desc',name:'s_role_desc',orderable:true,searchable:true,render:function(val){
                    return val}},
                {data:'','name':'',orderable:false,searchable:false,width:'120px',render:RenderOptionCol },
            ];

            var grid = new Datatable();
            grid.init({
                src: $("#data_tables"),
                dataTable: {
                    "columns":cols,
                    "ajax": {
                        "url": "/admin/role/query",
                    },
                    "order": [
                        [1, "asc"]
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
                }else if($(e.target).is('.btn-auth')){
                    e.stopPropagation();
                    GridClickFunction_Auth(rowData);
                }else if($(e.target).is('.btn-menu')){
                    e.stopPropagation();
                    GridClickFunction_Menu(rowData);
                }else if($(e.target).is('.btn-delete')){
                    e.stopPropagation();
                    GridClickFunction_Delete(rowData);
                }
            });
        });

        function GridClickFunction_Add(){
            var url = '/admin/role/add';
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'html',
                success: function(data){
                    $('#popupModel .modal-content').html(data);
                    App.initSlimScroll('.scroller');
                }
            });
            $('#popupModel').modal('show');
        }

        function GridClickFunction_Edit(item){
            var s_role_id = item.s_role_id;
            var url = "/admin/role/edit/"+s_role_id;
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'html',
                success: function(data){
                    $('#popupModel .modal-content').html(data);
                    App.initSlimScroll('.scroller');
                }
            });
            $('#popupModel').modal('show');
        }

        function GridClickFunction_Delete(item){
            var s_role_id = item.s_role_id;
            WX.Confirm('确定要删除么？',function(){
                var url = "/admin/role/delete/"+s_role_id;
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

        function GridClickFunction_Auth(item){

        }

        function GridClickFunction_Menu(item){
            var s_role_id = item.s_role_id;
            var url = '/admin/role/selectMenus/'+s_role_id ;
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'html',
                success: function(data){
                    $('#popupModel .modal-content').html(data);
                    App.initSlimScroll('.scroller');
                }
            });
            $('#popupModel').modal('show');
        }
    </script>
@endsection
