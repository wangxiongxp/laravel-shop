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
                <a href="#">产品管理</a>
            </li>
        </ul>
    </div>

    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12" >
            <div class="portlet light bordered">
                <!-- Begin: life time stats -->

                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> 产品管理</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided" >
                            <label onclick="GridClickFunction_Step1()" class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                <i class="fa fa-plus"></i> 新增产品</label>
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
                            <th>产品ID</th>
                            <th>图片</th>
                            <th>产品标题</th>
                            <th>产品分类</th>
                            <th>价格</th>
                            <th>数量</th>
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
        if(item.product_status == '1'){
            opts += '<a href="javascript:void(0)" class="btn-off-shelf">下架</a>&nbsp;&nbsp;';
        }else if(item.product_status == '0'){
            opts += '<a href="javascript:void(0)" class="btn-on-shelf">上架</a>&nbsp;&nbsp;';
        }

        opts += '<a href="javascript:void(0)" class="btn-delete">删除</a> ';
        return opts;
    }

    $(document).ready(function(){
        var cols = [
            // {data:'accountId',name:'sys_account_id',orderable:false,createdCell:function(cell, cellData, rowData, rowIndex, colIndex){
            //     $(cell).html("<input type='checkbox' name='checkList' value='" + cellData + "'/>")} },
            {data:'product_id',name:'product_id',orderable:false,searchable:true,visible:true,render:function(val){
                return val} },
            {data:'product_image',name:'product_image',orderable:false,searchable:true,visible:true,render:function(val){
                return "<img style='width:40px;height:40px;' src='"+val+"'>"} },
            {data:'product_title',name:'product_title',orderable:false,searchable:true,render:function(val){
                return val}},
            {data:'cat_title',name:'cat_title',orderable:false,searchable:true,visible:true,render:function(val){
                return val} },
            {data:'product_price',name:'product_price',orderable:true,searchable:true,render:function(val){
                return val}},
            {data:'product_qty',name:'product_qty',orderable:true,searchable:true,render:function(val){
                return val}},
            {data:'product_status',name:'product_status',orderable:false,searchable:true,render:function(val){
                if(val=='1'){
                    return '上架中';
                }else{
                    return '下架中';
                }
            }},
            {data:'created_at',name:'created_at',orderable:true,searchable:true,render:function(val){
                return val}},
            {data:'','name':'',orderable:false,searchable:false,width:'120px',render:RenderOptionCol },
        ];

        var grid = new Datatable();
        grid.init({
            src: $("#data_tables"),
            dataTable: {
                "columns":cols,
                "ajax": {
                    "url": "/admin/product/query",
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
            }else if($(e.target).is('.btn-on-shelf')){
                e.stopPropagation();
                GridClickFunction_updateStatus(rowData,'1');
            }else if($(e.target).is('.btn-off-shelf')){
                e.stopPropagation();
                GridClickFunction_updateStatus(rowData,'0');
            }
        });
    });

    function GridClickFunction_Step1(){
        var url = '/admin/product?act=step1';
        location.href = url ;
    }

    function GridClickFunction_Add(){
        var url = '/admin/product?act=add';
        location.href = url ;
    }

    function GridClickFunction_Edit(item){
        var url = "/admin/product?act=edit&id="+item.product_id;
        location.href = url ;
    }

    function GridClickFunction_Delete(item){
        WX.Confirm('确定要将该商品放入回收站么？',function(){
            var url = "/admin/product/updateStatus/"+item.product_id+"/-1";
            AjaxAction({'url':url, 'method':'POST','success':function(data){
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

    function GridClickFunction_updateStatus(item,status){
        var url = "/admin/product/updateStatus/"+item.product_id+"/"+status;
        AjaxAction({'url':url, 'method':'POST','success':function(data){
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