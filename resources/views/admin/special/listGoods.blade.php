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
                <a href="#">限时特价</a>
            </li>
        </ul>
    </div>

    <div class="row" style="margin-top:20px;">
        <div class="col-md-12" >
            <div class="portlet light bordered">
            <!-- Begin: life time stats -->

                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> 商品列表</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided" >
                            <label onclick="GridClickFunction_Add()" class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                <i class="fa fa-plus"></i> 新增商品</label>

                            <label onclick="location.href='/admin/special'" class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                <i class="fa fa-arrow-left"></i> 返回</label>
                        </div>
                    </div>
                </div>

                <input type="hidden" id="special_id" name="special_id" value="{{$special_id}}"/>

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
                            <th>图片</th>
                            <th>商品编码</th>
                            <th>商品名称</th>
                            <th>商品分类</th>
                            <th>销售价</th>
                            <th>原价</th>
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

<div class="modal fade bs-modal-lg " id="large-model" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">

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
            opts += '<a href="javascript:void(0)" class="btn-delete">删除</a>&nbsp;&nbsp;';
            return opts;
        }

        $(document).ready(function(){

            var cols = [
                {data:'product_image',name:'product_image',orderable:true,searchable:true,width:'60px',render:function(val){
                    var html = "<img width='32px' height='32px' src="+val+">"
                    return html} },
                {data:'product_id',name:'product_id',orderable:false,searchable:true,visible:true,render:function(val){
                    return val} },
                {data:'product_title',name:'product_title',orderable:false,searchable:true,render:function(val){
                    return val }},
                {data:'product_cat_title',name:'product_cat_title',orderable:false,searchable:true,visible:true,render:function(val){
                    return val} },
                {data:'product_price',name:'product_price',orderable:false,searchable:true,visible:true,render:function(val,type,item){
                    return val * item.discount/10 } },
                {data:'product_price',name:'product_price',orderable:false,searchable:true,visible:true,render:function(val){
                    return val} },
                {data:'start_time',name:'start_time',orderable:false,searchable:true,render:function(val){
                    return val}},
                {data:'end_time',name:'end_time',orderable:false,searchable:true,render:function(val){
                    return val}},
                {data:'status',name:'status',orderable:false,searchable:true,width:'50px',render:function(val){
                    return val == '1' ? '开启' : '关闭' }},
                {data:'','name':'',orderable:false,searchable:false,width:'60px',render:RenderOptionCol },
            ];

            var grid = new Datatable();
            grid.init({
                src: $("#data_tables"),
                dataTable: {
                    "columns":cols,
                    "ajax": {
                        "url": "/admin/special/queryGoods/{{$special_id}}",
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
                if($(e.target).is('.btn-delete')){
                    e.stopPropagation();
                    GridClickFunction_Delete(rowData);
                }
            });
        });

        function GridClickFunction_Add(){
            var url = '/admin/special/selectGoods';

             $.ajax({
                 type: "GET",
                 url: url,
                 dataType: 'html',
                 success: function(data){
                     $('#large-model .modal-dialog').html(data);

                     App.initSlimScroll('.scroller');
                 }
             });
             $('#large-model').modal('show');
        }

        function GridClickFunction_Delete(item){
            WX.Confirm('确定要删除么？',function(){
                var url = "/admin/special/deleteGoodsById/"+item.id;
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
