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
                <a href="#">促销列表</a>
            </li>
        </ul>
    </div>

    <div class="row" style="margin-top:20px;">
        <div class="col-md-12" >
            <div class="portlet light bordered">
            <!-- Begin: life time stats -->

                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> 促销列表</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided" >
                            <label onclick="GridClickFunction_Add()" class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                <i class="fa fa-plus"></i> 新增促销</label>
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
                    <table id="data_tables" class="table table-striped table-bordered table-hover order-column" >
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>活动名称</th>
                            <th>参与范围</th>
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
                {data:'prom_id',name:'prom_id',orderable:true,searchable:true,visible:false,render:function(val){
                    return val} },
                {data:'prom_name',name:'prom_name',orderable:false,searchable:true,visible:true,render:function(val){
                    return val} },
                {data:'prom_scope',name:'prom_scope',orderable:false,searchable:true,visible:true,render:function(val,type,item){
                    if(val=='all'){
                        return "A类券（所有商品）" ;
                    }else if(val=='category'){
                        return "C类券（分类优惠）" ;
                    }else if(val=='brand'){
                        return "B类券（品牌优惠）" ;
                    }else if(val=='goods'){
                        return "S类券 <a href='/admin/promotion/listGoods/"+item.prom_id+"'>"+item.goods+"个关联商品</a>" ;
                    }
                    return "" }},
                {data:'start_time',name:'start_time',orderable:true,searchable:true,render:function(val){
                    return val}},
                {data:'end_time',name:'end_time',orderable:true,searchable:true,render:function(val){
                    return val}},
                {data:'status',name:'status',orderable:false,searchable:true,render:function(val,type,item){
                    if(val == 1){
                       return "<a href='javascript:void(0)' onclick='GridClickFunction_updateStatus("+item.prom_id+",0)'>关闭</a>"
                    }else{
                        return "<a href='javascript:void(0)' onclick='GridClickFunction_updateStatus("+item.prom_id+",1)'>开启</a>"
                    }
                }},
                {data:'','name':'',orderable:false,searchable:false,width:'80px',render:RenderOptionCol },
            ];

            var grid = new Datatable();
            grid.init({
                src: $("#data_tables"),
                dataTable: {
                    "columns":cols,
                    "ajax": {
                        "url": "/admin/promotion/query",
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
            var url = '/admin/promotion?act=add';
            location.href = url ;
        }

        function GridClickFunction_Edit(item){
            var prom_id = item.prom_id;
            var url = "/admin/promotion?act=edit&id="+prom_id;
            location.href = url ;
        }

        function GridClickFunction_Delete(item){
            var prom_id = item.prom_id;
            WX.Confirm('确定要删除么？',function(){
                var url = "/admin/promotion/delete/"+prom_id;
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

        function GridClickFunction_updateStatus(id,status){
            var url = "/admin/promotion/updateStatus/"+id+"/"+status;
            AjaxAction({'url':url,'method':"GET", 'success':function(data){
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
