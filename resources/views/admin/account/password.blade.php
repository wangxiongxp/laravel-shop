<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
        重置密码
    </h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <form id="AddForm" method="post" role="form" class="form-horizontal">
                <input type="hidden" name="account_id" value="{{$account_id}}" />
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">新密码<span class="required" >*</span></label>
                        <div class="col-md-6">
                            <input type="password" name="password" class="form-control" id="register_password" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">确认新密码<span class="required" >*</span></label>
                        <div class="col-md-6">
                            <input type="password" name="confirm_password" class="form-control" />
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
                register_password: {
                    required: true
                },
                confirm_password: {
                    equalTo: "#register_password"
                }
            },
            messages: {
                register_password: {
                    required: "密码必须填写"
                },
                confirm_password: {
                    equalTo: '两次输入密码不一致'
                }
            }
        };
        WX.Validate('AddForm',setting);

        var options = {
            dataType:  'json',
            beforeSubmit:  function() {
                App.blockUI({ animate: true});
                return true;
            },
            success: function(responseText){
                App.unblockUI();
                if(responseText){
                    if(responseText.code == 1) {
                        WX.toastr({'type':'success','message':'重置密码成功', 'onHidden':function(){
                            location.href = "/admin/account";
                        }});
                    }else{
                        WX.toastr({'type':'error','message': '重置密码失败'});
                    }
                }
            }
        };
        $('#AddForm').ajaxForm(options);
    });

    function Function_SaveForm(){
        $("#AddForm").attr('action','/admin/account/resetPassword');
        $("#AddForm").submit();
    }
</script>

</html>