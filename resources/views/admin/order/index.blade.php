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
                <a href="#">订单列表</a>
            </li>
        </ul>
    </div>

    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12" >
            <div class="portlet light bordered">
                <!-- Begin: life time stats -->
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> 订单列表</span>
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
                            <th>订单号</th>
                            <th>数量</th>
                            <th>买家</th>
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
        opts += '<a href="javascript:void(0)" class="btn-edit">详细信息</a><br/>';
        opts += '<a href="javascript:void(0)" class="btn-delete">删除</a> ';
        return opts;
    }

    $(document).ready(function(){

        var cols = [
            {data:'order_id',name:'order_id',orderable:true,searchable:true,visible:true,render:function(val){
                return val} },
            {data:'order_no',name:'order_no',orderable:true,searchable:true,visible:true,render:function(val){
                return val} },
            {data:'quantity',name:'quantity',orderable:true,searchable:true,render:function(val){
                return val}},
            {data:'buyer_nick',name:'buyer_nick',orderable:true,searchable:true,render:function(val){
                return val}},
            {data:'order_status',name:'order_status',orderable:false,searchable:true,render:function(val){
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
                    "url": "/admin/order/query",
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
            }
        });
    });

    function GridClickFunction_Edit(item){
        var url = "/admin/order?act=edit&id="+item.order_id;
        location.href = url ;
    }

    function GridClickFunction_Delete(item){
        var order_id = item.order_id;
        WX.Confirm('确定要删除么？',function(){
            var url = "/admin/order/delete/"+order_id;
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