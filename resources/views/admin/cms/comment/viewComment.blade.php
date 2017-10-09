<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
        评论详情
    </h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <form id="AddForm" method="post" role="form" class="form-horizontal">
                <input type="hidden" name="id" value="{{$comment->id}}"/>
                <input type="hidden" name="status" id="status" />
                <div class="form-body" style="min-height: 240px;">

                    <div class="form-group">
                        <label class="col-md-3 control-label">文章标题：</label>
                        <div class="col-md-8">
                            <p class="form-control-static">{{$comment->cms_article_title}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">评论内容：</label>
                        <div class="col-md-8">
                            <p class="form-control-static">{{$comment->content}}</p>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn blue" onclick="Function_Audit(1);">审核通过</button>
    <button type="button" class="btn blue" onclick="Function_Audit(2);">审核拒绝</button>
    <button type="button" data-dismiss="modal" class="btn btn-default">关闭</button>
</div>

<script type="text/javascript">

    $(function(){

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
                        WX.toastr({'type':'success','message':'修改成功！', 'onHidden':function(){
                            location.href = "/admin/cms/comment";
                        }});
                    }else{
                        WX.toastr({'type':'error','message': '修改失败'});
                    }
                }
            }
        };
        $('#AddForm').ajaxForm(options);

    })

    function Function_Audit(status){
        $("#status").val(status) ;

        $("#AddForm").attr('action','/admin/cms/comment/updateStatus');
        $("#AddForm").submit();
    }

</script>
