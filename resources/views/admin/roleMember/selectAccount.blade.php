<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
        成员选择
    </h4>
</div>

<div class="modal-body">
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
        <table id="data_tables_account" class="table table-striped table-bordered table-hover table-checkable order-column" >
            <thead>
            <tr>
                <th>
                    <input type="checkbox" class="group-checkable">
                </th>
                <th>ID</th>
                <th>名称</th>
                <th>联系电话</th>
                <th>操作</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn blue" onclick="Function_SaveSelect();">保存</button>
    <button type="button" data-dismiss="modal" class="btn btn-default">关闭</button>
</div>

<script>

    var account_table;
    var account_grid

    $(document).ready(function(){
        var account_cols = [
            {data:'account_id',name:'account_id',orderable:false,createdCell:function(cell, cellData, rowData, rowIndex, colIndex){
                $(cell).html("<input type='checkbox' name='checkList' value='" + cellData + "'>")} },
            {data:'account_id',name:'account_id',orderable:false,createdCell:function(cell, cellData, rowData, rowIndex, colIndex){
                $(cell).html(rowIndex+1)} },
            {data:'account_real_name',name:'account_real_name',orderable:true,searchable:true,visible:true,render:function(val){
                return val} },
            {data:'account_tel',name:'account_tel',orderable:true,searchable:true,visible:true,render:function(val){
                return val} },
            {data:'account_status',name:'account_status',orderable:true,searchable:true,render:function(val){
                if(val==1){
                    return '<span class="badge badge-success">正常</span>'
                }else{
                    return '<span class="badge badge-warning">锁定</span>';
                }}},
        ];

        account_grid = new Datatable();
        account_grid.init({
            src: $("#data_tables_account"),
            dataTable: {
                "columns":account_cols,
                "ajax": {
                    "url": "/admin/account/query",
                },
                "order": [
                    [2, "desc"]
                ]
            }
        });

    });

    function Function_SaveSelect(){
        var accountIds = account_grid.getSelectedRows();
        var accountIdStr = accountIds.join('_');
        if(accountIdStr!=''){
            var url = "/admin/roleMember/save?s_role_id="+roleId+'&account_id='+accountIdStr;
            AjaxAction({'url':url,'method':'POST', 'success':function(data){
                if(data && data.code == 1) {
                    WX.toastr({'type':'success','message':'保存成功.'});
                    table.ajax.reload();
                } else {
                    WX.toastr({'type':'error','message':'保存失败.'});
                }
            }});
        }

        $('#popupModel').modal('hide');
    }



</script>
