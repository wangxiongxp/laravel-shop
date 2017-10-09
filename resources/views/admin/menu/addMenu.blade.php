<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
        新增菜单
    </h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <form id="AddForm" method="post" role="form" class="form-horizontal">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">父级菜单<span class="required" >*</span></label>
                        <div class="col-md-6">
                            <select class="form-control" id="menu_parent" name="menu_parent">
                                <option value='0'>一级菜单</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">菜单名称<span class="required" >*</span></label>
                        <div class="col-md-6">
                            <input type="text" id="menu_text" name="menu_text" placeholder="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">菜单Url<span class="required" ></span></label>
                        <div class="col-md-6">
                            <input type="text" id="menu_url" name="menu_url" placeholder="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">图标<span class="required" ></span></label>
                        <div class="col-md-6">
                            <input type="text" id="menu_css" name="menu_css" placeholder="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">排序<span class="required" >*</span></label>
                        <div class="col-md-6">
                            <input type="text" id="menu_sort" name="menu_sort" placeholder="" class="form-control">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn blue" onclick="Function_SaveForm();">保存</button>
    <button type="button" data-dismiss="modal" class="btn btn-default">关闭</button>
</div>

<script type="text/javascript">

    $(document).ready(function(){
        ajaxSelectSimple('/admin/menu/getFirstMenu','menu_parent','menu_id','menu_text');

        var setting = {
            rules: {
                menu_parent: {
                    required: true
                },
                menu_text: {
                    required: true,
                },
//                menu_url: {
//                    required: true,
//                },
//                menu_css: {
//                    required: true,
//                },
                menu_sort: {
                    required: true,
                    number: true
                },
            },
        }
        WX.Validate('AddForm',setting);

        var options = {
            dataType:  'json',
            //beforeSubmit: ShowRequest ,
            success: ShowResponse ,
        };
        $('#AddForm').ajaxForm(options);
    });

    function ShowResponse(responseText, statusText) {
        data = responseText;
        if(data){
            if(data.code == 1)
            {
                WX.toastr({'type':'success','message':'保存成功.','onHidden':function(){
                    location.href = "/admin/menu";
                }});
            }else{
                WX.toastr({'type':'error','message':'保存失败!'});
            }
        }
    }

    function Function_SaveForm(){
        $("#AddForm").attr('action','/admin/menu/save');
        $("#AddForm").submit();
    }
</script>