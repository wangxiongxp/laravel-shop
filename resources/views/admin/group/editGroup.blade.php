<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
        组织信息修改
    </h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <form id="EditForm" method="post" role="form" class="form-horizontal">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">所属部门 </label>
                        <div class="col-md-10">
                            <p class="form-control-static" id="s_group_parent">
                                {{ $group->s_group_parent_name}}
                            </p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">组织名称 </label>
                        <div class="col-md-10">
                            <input type="hidden" id="s_group_id" name="s_group_id" value="{{ $group->s_group_id}}" placeholder="" class="form-control">
                            <input type="text" id="s_group_name" name="s_group_name" value="{{ $group->s_group_name}}" placeholder="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">组织类型 </label>
                        <div class="col-md-10">
                            <select class="form-control" id="s_group_type_id" name="s_group_type_id">
                                <option value="1" selected>公司</option>
                                <option value="2">组织</option>
                                <option value="3">小组</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">组织备注 </label>
                        <div class="col-md-10">
                            <textarea id="s_group_desc" name="s_group_desc" placeholder=" " class="form-control">{{$group->s_group_desc}}</textarea>
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

        $("#s_group_type_id").val({{ $group->s_group_type_id }});
        App.initUniform();

        var setting = {
            rules: {
                s_group_name: {
                    required: true
                },
            },
        }

        WX.Validate('EditForm',setting);

        var options = {
            dataType:  'json',
            //beforeSubmit: ShowRequest ,
            success: ShowResponse ,
        };
        $('#EditForm').ajaxForm(options);

        });

        function ShowResponse(responseText, statusText) {
            data = responseText;
            if(data){
                if(data.code == 1)
                {
                    WX.toastr({'type':'success','message':'更新成功!','onHidden':function(){
                        location.href = "/admin/group";
                    }});
                }else{
                    WX.toastr({'type':'error','message':'更新失败!'});
                }
            }
        }

        function Function_SaveForm(){
            $("#EditForm").attr('action','/admin/group/update');
            $("#EditForm").submit();
        }
</script>