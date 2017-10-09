@extends('admin.layouts.default')

@section('head_css')
    <link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/datatables.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/global/plugins/jstree/dist/themes/default/style.min.css"/>
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
                <a href="#">群组成员管理</a>
            </li>
        </ul>
    </div>

    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12">
            <div class="portlet light bordered">

                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase"> 群组成员管理</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided" >
                            <label onclick="GridClickFunction_Add()" class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                <i class="fa fa-plus"></i> 添加成员</label>
                        </div>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="portlet light" style="padding-left:5px;min-height: 380px;">
                                <div class="portlet-body">
                                    <div id="tree_group" class="tree-demo"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9" >
                            <!-- Begin: life time stats -->
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
                                        <th>成员</th>
                                        <th>群组名称</th>
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
    <script type="text/javascript" src="/assets/global/plugins/jstree/dist/jstree.min.js"></script>

    <script>

        $('#tree_group').jstree({
            "core" : {
                "themes" : {
                    "responsive": false
                },
                'data': {
                    'url' : function (node) {
                        return '/admin/group/getGroupTree';
                    },
                    'data' : function (node) {
                        return { };
                    },
                }
            },
            "types" : {
                "default" : {
                    "icon" : "fa fa-folder icon-state-warning icon-lg"
                },
                "file" : {
                    "icon" : "fa fa-file icon-state-warning icon-lg"
                }
            },
            "plugins": ["types"]
        });

        var table;
        var groupId;

        function RenderOptionCol(val,type,item)
        {
            var opts = '';
            opts += '<a href="javascript:void(0)" class="btn-delete">删除</a> ';
            opts += '<a href="javascript:void(0)" class="btn-oauth">群组授权</a> ';
            return opts;
        }

        $(document).ready(function(){
            var cols = [
                {data:'s_group_id',name:'s_group_id',orderable:false,createdCell:function(cell, cellData, rowData, rowIndex, colIndex){
                    $(cell).html(rowIndex+1)} },
                {data:'account_real_name',name:'account_real_name',orderable:true,searchable:true,visible:true,render:function(val){
                    return val} },
                {data:'s_group_name',name:'s_group_name',orderable:true,searchable:true,visible:true,render:function(val){
                    return val} },
                {data:'','name':'',orderable:false,searchable:false,width:'120px',render:RenderOptionCol },
            ];

            var grid = new Datatable();
            grid.init({
                src: $("#data_tables"),
                dataTable: {
                    "columns":cols,
                    "ajax": {
                        "url": "/admin/groupMember/query",
                    },
                    "order": [
                        [2, "desc"]
                    ]
                }

            });

            table = grid.getDataTable();
            table.on('click','td',function(e){
                var rowIndex = table.cell(this).index().row;
                var rowData  = table.row(rowIndex).data();
                if($(e.target).is('.btn-delete')){
                    e.stopPropagation();
                    GridClickFunction_Delete(rowData);
                }else if($(e.target).is('.btn-oauth')){
                    e.stopPropagation();
                    GridClickFunction_Group(rowData);
                }
            });

            $('#tree_group').on('select_node.jstree', function(e,data) {
                groupId = data.node.id ;
                grid.setAjaxParam('s_group_id',groupId);
                $(".keyword").val("");
                table.ajax.reload();
            });

        });

        function GridClickFunction_Add(){

            if(undefined == groupId || null == groupId || groupId == ''){
                WX.toastr({'type':'info','message':'请选择群组.'});
                return ;
            }

            var url = '/admin/groupMember/add';
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
            var s_group_id = item.s_group_id;
            var account_id = item.account_id;
            WX.Confirm('确定要删除么？',function(){
                var url = "/admin/groupMember/delete/"+s_group_id+"/"+account_id;
                AjaxAction({'url':url, 'method' : 'GET', 'success':function(data){
                    if(data.code == 1) {
                        WX.toastr({'type':'success','message':"删除成功.",'onHidden':function(){
                            table.ajax.reload();
                        }});
                    } else {
                        WX.toastr({'type':'error','message':'删除失败.'});
                    }
                }});
            });
        }

        function GridClickFunction_Group(item){
            var account_id = item.account_id;
            var url = '/admin/groupMember/selectGroup/'+account_id ;
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'html',
                success: function(data){
                    $('#popupModel .modal-content').html(data);
                    App.initSlimScroll('.scroller');
                    App.initUniform();
                }
            });
            $('#popupModel').modal('show');

        }

        function GridClickFunction_Position(item){

        }

    </script>
@endsection

