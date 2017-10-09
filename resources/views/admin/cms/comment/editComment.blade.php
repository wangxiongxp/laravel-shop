<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
        编辑评论
    </h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <form id="EditForm" method="post" role="form" class="form-horizontal">
                <div class="form-body" style="min-height: 240px;">
                    <div class="form-group">
                        <label class="col-md-3 control-label">文章标题：</label>
                        <div class="col-md-8">
                            <input type="hidden" name="id" id="id" value="{{$comment->id}}"/>
                            <p class="form-control-static">{{$comment->cms_article_title}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">评论内容：</label>
                        <div class="col-md-8">
                            <textarea rows="6" id="content" name="content" class="form-control" >
                                {{$comment->content}}</textarea>
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
                content: {
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
                WX.toastr({'type':'success','message':'修改成功.','onHidden':function(){
                    location.href = "/admin/cms/comment";
                }});
            }else{
                WX.toastr({'type':'error','message':'修改失败!'});
            }
        }
    }

    function Function_SaveForm(){
        $("#EditForm").attr('action','/admin/cms/comment/update');
        $("#EditForm").submit();
    }
</script>

</html>