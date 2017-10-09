<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
        编辑属性
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
                            <p class="form-control-static">{{ $cat->cat_title }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">属性名称<span class="required" >*</span></label>
                        <div class="col-md-6">
                            <input type="hidden" id="attr_id" name="attr_id" value="{{ $attr->attr_id}}" >
                            <input type="text" id="attr_name" name="attr_name" value="{{ $attr->attr_name}}" placeholder="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">属性类型<span class="required" >*</span></label>
                        <div class="col-md-6">
                            <select id="attr_type" name="attr_type" class="form-control">
                                <option value="UT_CHECKBOX">UT_CHECKBOX</option>
                                <option value="UT_SELECT">UT_SELECT</option>
                                <option value="UT_INPUT">UT_INPUT</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">必填属性<span class="required" >*</span></label>
                        <div class="col-md-6">
                            <div class="radio-list ">
                                <label class="radio-inline">
                                    <input type="radio" name="is_required" value="0" checked="checked" />否
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="is_required" value="1" />是
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">排序<span class="required" >*</span></label>
                        <div class="col-md-6">
                            <input type="text" id="attr_sort" name="attr_sort" value="{{ $attr->attr_sort}}" placeholder="" class="form-control">
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

        $("#attr_type").val('{{ $attr->attr_type}}');
        SetRadioSelected('is_required','{{$attr->is_required}}');
        App.initUniform();

        var setting = {
            rules: {
                attr_name: {
                    required: true
                },
                attr_type: {
                    required: true
                },
                attr_sort: {
                    required: true,
                },
                is_required: {
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
                WX.toastr({'type':'success','message':'修改成功.','onHidden':function(){
                    location.href = "/admin/productCatAttr?cat_id={{ $cat->cat_id }}";
                }});
            }else{
                WX.toastr({'type':'error','message':'修改失败!'});
            }
        }
    }

    function Function_SaveForm(){
        $("#AddForm").attr('action','/admin/productCatAttr/update');
        $("#AddForm").submit();
    }
</script>