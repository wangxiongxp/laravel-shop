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
                <a href="#">评论管理</a>
            </li>
        </ul>
    </div>

    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12" >
            <div class="portlet light bordered">
                <!-- Begin: life time stats -->

                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> 评论管理</span>
                    </div>
                    <div class="actions">
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
                            <th>评论文章</th>
                            <th>评论内容</th>
                            <th>评论时间</th>
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

<script>

    var table;

    function RenderOptionCol(val,type,item)
    {
        var opts = '';
        opts += '<a href="javascript:void(0)" class="btn-view">查看</a>&nbsp;&nbsp;';
        opts += '<a href="javascript:void(0)" class="btn-edit">修改</a>&nbsp;&nbsp;';
        opts += '<a href="javascript:void(0)" class="btn-delete">删除</a> ';
        return opts;
    }

    $(document).ready(function(){
        var cols = [
            // {data:'accountId',name:'sys_account_id',orderable:false,createdCell:function(cell, cellData, rowData, rowIndex, colIndex){
            //     $(cell).html("<input type='checkbox' name='checkList' value='" + cellData + "'/>")} },
            {data:'id',name:'id',orderable:false,createdCell:function(cell, cellData, rowData, rowIndex, colIndex){
                $(cell).html(rowIndex+1)} },
            {data:'cms_article_title',name:'cms_article_title',orderable:false,searchable:true,visible:true,render:function(val){
                return val} },
            {data:'content',name:'content',orderable:false,searchable:true,visible:true,render:function(val){
                return val.substring(0,30)+'...'} },
            {data:'created_at',name:'created_at',orderable:true,searchable:true,render:function(val){
                return val}},
            {data:'status',name:'status',orderable:false,searchable:true,render:function(val){
                if(val==1){
                    return '审核通过'
                }else if(val==2){
                    return '审核拒绝';
                }else{
                    return '待审核';
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
                    "url": "/admin/cms/comment/query",
                },
                "order": [
                    [0, "desc"]
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
            }else if($(e.target).is('.btn-view')){
                e.stopPropagation();
                GridClickFunction_View(rowData);
            }
        });
    });

    function GridClickFunction_Add(){
        var url = '/admin/cms/comment/add';
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

    function GridClickFunction_View(item){
        var url = "/admin/cms/comment/view/"+item.id;
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
        var url = "/admin/cms/comment/edit/"+item.id;
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
        WX.Confirm('确定要删除么？',function(){
            var url = "/admin/cms/comment/delete/"+item.id;
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


</script>
@endsection