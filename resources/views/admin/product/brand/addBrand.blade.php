<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
        新增品牌
    </h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <form id="AddForm" method="post" role="form" class="form-horizontal">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">品牌名称<span class="required" >*</span></label>
                        <div class="col-md-8">
                            <input type="text" id="brand_name" name="brand_name" placeholder="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">品牌编码<span class="required" >*</span></label>
                        <div class="col-md-8">
                            <input type="text" id="brand_code" name="brand_code" placeholder="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">品牌Logo<span class="required" ></span></label>
                        <div class="col-md-8">
                            <input type="hidden" id="brand_logo" name="brand_logo" >
                            <a class="btn btn-default" id="select_image">选择图片</a>
                            <img src="" style="display: none;width:32px;"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">备注<span class="required" >&nbsp;</span></label>
                        <div class="col-md-8">
                            <textarea id="brand_desc" name="brand_desc" placeholder="" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">排序<span class="required" >&nbsp;</span></label>
                        <div class="col-md-8">
                            <input type="text" id="brand_sort" name="brand_sort" placeholder="" class="form-control">
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

<script type="text/javascript" src="/assets/global/plugins/plupload/js/plupload.full.min.js"></script>
<script type="text/javascript">

    $(document).ready(function(){

        var setting = {
            rules: {
                brand_name: {
                    required: true
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
                    location.href = "/admin/brand";
                }});
            }else{
                WX.toastr({'type':'error','message':'保存失败!'});
            }
        }
    }

    function Function_SaveForm(){
        $("#AddForm").attr('action','/admin/brand/save');
        $("#AddForm").submit();
    }
</script>

<script>
    var uploader;

    var settings = {
        browse_button : 'select_image',
        url : '/admin/uploadImage',
        flash_swf_url : 'js/Moxie.swf',
        silverlight_xap_url : 'js/Moxie.xap',
        filters: {
            mime_types : [
                { title : "Image files", extensions : "jpg,gif,png,jpeg" },
            ],
            max_file_size : '20mb',
            prevent_duplicates : false,
        },
        multipart_params: {
            '_token':'{{ csrf_token() }}'
        },
        /*resize: {//可以使用该参数对将要上传的图片进行压缩，
         width: 400,
         height: 130,
         crop: true,
         quality: 90,
         preserve_headers: false
         },*/
        multi_selection:false,
        unique_names:true,
        runtimes:'html5,flash,silverlight,html4',
        file_data_name:'file',
    };
    uploader = new plupload.Uploader(settings);
    uploader.init();
    uploader.bind('FilesAdded',function(uploader,files){
        uploader.start();
    });
    uploader.bind('UploadProgress',function(uploader,file){
        //上传进度
    });
    uploader.bind('FileUploaded',function(uploader,file,responseObject){
        var response = eval('('+responseObject.response+')');
        $("#select_image").next('img').attr('src', response.path).show() ;
        $("#brand_logo").val(response.path);
    });
    uploader.bind('UploadComplete',function(uploader,files){
        //console.log(files);
    });
    uploader.bind('Error',function(uploader,errObject){
        console.log(errObject);
        WX.toastr({'type':'error','timeOut':3000,'message':errObject.message});
    });

</script>
