<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
        新增属性值
    </h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <form id="AddForm" method="post" role="form" class="form-horizontal">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">分类名称<span class="required" >*</span></label>
                        <div class="col-md-6">
                            <input type="hidden" id="cat_id" name="cat_id" value="{{ $cat->cat_id }}">
                            <p class="form-control-static">{{ $cat->cat_title }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">属性名称<span class="required" >*</span></label>
                        <div class="col-md-6">
                            <input type="hidden" id="attr_id" name="attr_id" value="{{ $attr->attr_id }}">
                            <p class="form-control-static">{{ $attr->attr_name }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">属性值<span class="required" >*</span></label>
                        <div class="col-md-6">
                            <input type="text" id="option_name" name="option_name" placeholder="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">排序<span class="required" >*</span></label>
                        <div class="col-md-6">
                            <input type="text" id="option_sort" name="option_sort" placeholder="" class="form-control">
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
                option_name: {
                    required: true
                },
                option_sort: {
                    required: true,
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
                    location.href = "/admin/productCatAttrOption?attr_id={{ $attr->attr_id }}";
                }});
            }else{
                WX.toastr({'type':'error','message':'保存失败!'});
            }
        }
    }

    function Function_SaveForm(){
        $("#AddForm").attr('action','/admin/productCatAttrOption/save');
        $("#AddForm").submit();
    }
</script>