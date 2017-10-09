<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
        编辑角色
    </h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <form id="AddForm" method="post" role="form" class="form-horizontal">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">角色名称<span class="required" >*</span></label>
                        <div class="col-md-6">
                            <input type="hidden" id="s_role_id" name="s_role_id" value="{{ $role->s_role_id}}" >
                            <input type="text" id="s_role_name" name="s_role_name" value="{{ $role->s_role_name}}" placeholder="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">备注<span class="required" >&nbsp;</span></label>
                        <div class="col-md-6">
                            <textarea id="s_role_desc" name="s_role_desc" placeholder="" class="form-control">{{ $role->s_role_desc}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">排序<span class="required" >*</span></label>
                        <div class="col-md-6">
                            <input type="text" id="s_role_sort" name="s_role_sort" value="{{ $role->s_role_sort}}"  placeholder="" class="form-control">
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

        var setting = {
            rules: {
                s_role_name: {
                    required: true
                },
                s_role_sort: {
                    required: true,
                    number: true
                }
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
                WX.toastr({'type':'success','message':'修改成功.','onHidden':function(){
                    location.href = "/admin/role";
                }});
            }else{
                WX.toastr({'type':'error','message':'修改失败!'});
            }
        }
    }

    function Function_SaveForm(){
        $("#AddForm").attr('action','/admin/role/update');
        $("#AddForm").submit();
    }
</script>