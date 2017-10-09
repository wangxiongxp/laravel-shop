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
                <a href="#">文章管理</a>
            </li>
        </ul>
    </div>

    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12" >
            <div class="portlet light bordered">
                <!-- Begin: life time stats -->

                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> 文章管理</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided" >
                            <label onclick="GridClickFunction_Add()" class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                <i class="fa fa-plus"></i> 新增文章</label>
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
                            <th>文章分类</th>
                            <th>文章标题</th>
                            <th>置顶</th>
                            <th>评论</th>
                            <th>状态</th>
                            <th>创建时间</th>
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
        opts += '<a href="javascript:void(0)" class="btn-edit">编辑</a>&nbsp;&nbsp;';
        if(item.visibility == 'LOCK'){
            opts += '<a href="javascript:void(0)" class="btn-public">公开</a>&nbsp;&nbsp;';
        }else{
            opts += '<a href="javascript:void(0)" class="btn-lock">锁定</a>&nbsp;&nbsp;';
        }

        opts += '<a href="javascript:void(0)" class="btn-delete">删除</a> ';
        return opts;
    }

    $(document).ready(function(){
        var cols = [
            // {data:'accountId',name:'sys_account_id',orderable:false,createdCell:function(cell, cellData, rowData, rowIndex, colIndex){
            //     $(cell).html("<input type='checkbox' name='checkList' value='" + cellData + "'/>")} },
            {data:'id',name:'id',orderable:false,createdCell:function(cell, cellData, rowData, rowIndex, colIndex){
                $(cell).html(rowIndex+1)} },
            {data:'cms_catalog_name',name:'cms_catalog_name',orderable:false,searchable:true,visible:true,render:function(val){
                return val} },
            {data:'title',name:'title',orderable:true,searchable:true,render:function(val){
                return val}},
            {data:'is_top',name:'is_top',orderable:false,searchable:true,render:function(val,type,item){
                if(val==1){
                    return "<a onclick='UpdateIsTopStatus("+item.id+",0)'>取消置顶</a>"
                }else{
                    return "<a onclick='UpdateIsTopStatus("+item.id+",1)'>置顶</a>"
                }
            }},
            {data:'allow_comment',name:'allow_comment',orderable:false,searchable:true,render:function(val,type,item){
                if(val==1){
                    return "<a onclick='UpdateCommentStatus("+item.id+",0)'>关闭评论</a>"
                }else{
                    return "<a onclick='UpdateCommentStatus("+item.id+",1)'>开启评论</a>"
                }
                return val}},
            {data:'status',name:'status',orderable:false,searchable:true,render:function(val){
                if(val=='PUBLISHED'){
                    return '已发布';
                }else{
                    return '草稿';
                }
            }},
            {data:'created_at',name:'created_at',orderable:false,searchable:true,render:function(val){
                return val}},
            {data:'','name':'',orderable:false,searchable:false,width:'120px',render:RenderOptionCol },
        ];

        var grid = new Datatable();
        grid.init({
            src: $("#data_tables"),
            dataTable: {
                "columns":cols,
                "ajax": {
                    "url": "/admin/article/query",
                },
                "order": [
                    [6, "desc"]
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
            }else if($(e.target).is('.btn-lock')){
                e.stopPropagation();
                GridClickFunction_Lock(rowData,'LOCK');
            }else if($(e.target).is('.btn-public')){
                e.stopPropagation();
                GridClickFunction_Lock(rowData,'PUBLIC');
            }
        });
    });

    function GridClickFunction_Add(){
        var url = '/admin/article?act=add';
        location.href = url ;
    }

    function GridClickFunction_Edit(item){
        var url = "/admin/article?act=edit&id="+item.id;
        location.href = url ;
    }

    function GridClickFunction_Delete(item){
        WX.Confirm('确定要删除么？',function(){
            var url = "/admin/article/delete/"+item.id;
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

    function GridClickFunction_Lock(item,status){
        var url = "/admin/article/updateVisibilityStatus/"+item.id+"/"+status;
        AjaxAction({'url':url, 'method':'GET','success':function(data){
            if(data.code == 1) {
                WX.toastr({'type':'success','message':'修改成功.','onHidden':function(){
                    table.ajax.reload();
                }});
            } else {
                WX.toastr({'type':'error','message':'修改失败.'});
            }
        }});
    }

    function UpdateIsTopStatus(id, status){
        var url = "/admin/article/updateIsTopStatus/"+id+"/"+status;
        AjaxAction({'url':url, 'method':'GET','success':function(data){
            if(data.code == 1) {
                WX.toastr({'type':'success','message':'修改成功.','onHidden':function(){
                    table.ajax.reload();
                }});
            } else {
                WX.toastr({'type':'error','message':'修改失败.'});
            }
        }});
    }

    function UpdateCommentStatus(id, status){
        var url = "/admin/article/updateCommentStatus/"+id+"/"+status;
        AjaxAction({'url':url, 'method':'GET','success':function(data){
            if(data.code == 1) {
                WX.toastr({'type':'success','message':'修改成功.','onHidden':function(){
                    table.ajax.reload();
                }});
            } else {
                WX.toastr({'type':'error','message':'修改失败.'});
            }
        }});
    }


</script>
@endsection