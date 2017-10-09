<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">选择商品</h4>
    </div>
    <div class="modal-body">
        <div class="row" >
            <div class="col-md-12" >
                <div class="portlet light bordered">

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
                        <table id="product_tables" class="table table-striped table-bordered table-hover table-checkable order-column" >
                            <thead>
                            <tr>
                                <th><input type="checkbox" class="group-checkable" /> </th>
                                <th>图片</th>
                                <th>产品标题</th>
                                <th>产品分类</th>
                                <th>价格</th>
                                <th>数量</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn dark btn-outline" data-dismiss="modal">关闭</button>
        <button type="button" class="btn green" onclick="Function_SaveProduct()">保存</button>
    </div>
</div>

<script>

    var grid_product;

    $(document).ready(function(){
        var cols_product = [
             {data:'product_id',name:'product_id',orderable:false,createdCell:function(cell, cellData, rowData, rowIndex, colIndex){
                 $(cell).html("<input type='checkbox' name='checkList' value='" + cellData + "'/>")} },
            {data:'product_image',name:'product_image',orderable:false,searchable:true,visible:true,render:function(val){
                return "<img style='width:40px;height:40px;' src='"+val+"'>"} },
            {data:'product_title',name:'product_title',orderable:true,searchable:true,render:function(val){
                return val}},
            {data:'cat_title',name:'cat_title',orderable:false,searchable:true,visible:true,render:function(val){
                return val} },
            {data:'product_price',name:'product_price',orderable:true,searchable:true,render:function(val){
                return val}},
            {data:'product_qty',name:'product_qty',orderable:true,searchable:true,render:function(val){
                return val}},
            {data:'created_at',name:'created_at',orderable:false,visible:false,render:function(val){
                return val}},
        ];

        grid_product = new Datatable();
        grid_product.init({
            src: $("#product_tables"),
            dataTable: {
                "columns":cols_product,
                "ajax": {
                    "url": "/admin/special/querySelectGoods",
                },
                "order": [
                    [6, "desc"]
                ]
            }
        });

    });

    function Function_SaveProduct(){
        var ids = grid_product.getSelectedRows().join(',');
        var special_id = $("#special_id").val();
        var url = "/admin/special/saveSpecialGoods"

        if(ids=='' || special_id==''){
            $('#large-model').modal('hide');
            return false;
        }

        AjaxAction({'url':url,'method':"POST", 'data':{ids:ids,special_id:special_id}, 'success':function(data){
            if(data.code == 1) {
                WX.toastr({'type':'success','message':'保存成功.','onHidden':function(){
                    table.ajax.reload();
                    $('#large-model').modal('hide');
                }});
            } else {
                WX.toastr({'type':'error','message':'保存失败.'});
            }
        }});

    }

</script>


