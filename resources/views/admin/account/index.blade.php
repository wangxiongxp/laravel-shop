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
                <a href="#">管理员管理</a>
            </li>
        </ul>
    </div>

    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12" >
            <div class="portlet light bordered">
                <!-- Begin: life time stats -->
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> 管理员管理</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided" >
                            <label onclick="GridClickFunction_Add()" class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                <i class="fa fa-plus"></i> 新增成员</label>
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
                            <th>用户名</th>
                            <th>真实姓名</th>
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
        opts += '<a href="javascript:void(0)" class="btn-edit">修改信息</a><br/>';
        opts += '<a href="javascript:void(0)" class="btn-resetPwd">重置密码</a><br/>';
        opts += '<a href="javascript:void(0)" class="btn-delete">删除账号</a> ';
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
                    "url": "/admin/account/query",
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
            if($(e.target).is('.btn-edit')){
                e.stopPropagation();
                GridClickFunction_Edit(rowData);
            }else if($(e.target).is('.btn-resetPwd')){
                e.stopPropagation();
                GridClickFunction_ResetPwd(rowData);
            }else if($(e.target).is('.btn-delete')){
                e.stopPropagation();
                GridClickFunction_Delete(rowData);
            }
        });
    });

    function GridClickFunction_Add(){
        var url = '/admin/account?act=add';
        location.href = url ;

        // $.ajax({
        //     type: "GET",
        //     url: url,
        //     dataType: 'html',
        //     success: function(data){
        //         $('#popupModel .modal-content').html(data);
        //         App.initSlimScroll('.scroller');
        //     }
        // });
        // $('#popupModel').modal('show');
    }

    function GridClickFunction_Edit(item){
        var url = "/admin/account?act=edit&id="+item.account_id;
        location.href = url ;

        // $.ajax({
        //     type: "GET",
        //     url: url,
        //     dataType: 'html',
        //     success: function(data){
        //         $('#popupModel .modal-content').html(data);
        //         App.initSlimScroll('.scroller');
        //     }
        // });
        // $('#popupModel').modal('show');
    }

    function GridClickFunction_Delete(item){
        var account_id = item.account_id;
        WX.Confirm('确定要删除该帐号么？',function(){
            var url = "/admin/account/delete/"+account_id;
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

    function GridClickFunction_ResetPwd(item){
        var account_id = item.account_id;
        var url = '/admin/account/showResetPassword/'+account_id ;

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