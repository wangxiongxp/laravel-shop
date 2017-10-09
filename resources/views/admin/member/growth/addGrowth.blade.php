@extends('admin.layouts.default')

@section('head_css')
@endsection

@section('content')
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="/">首页</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">会员等级</a>
                </li>
            </ul>
        </div>

        <div class="row" style="margin-top:20px;margin-left:0;margin-right:0">
            <div class="col-md-12">

                <div class="portlet light bordered">

                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase"> 新增会员等级</span>
                        </div>
                    </div>

                    <div class="portlet-body form">
                        <form role="form" class="form-horizontal" method="post" id="EditForm" action="/admin/growth/save">
                            <div class="form-body" style="padding-top:30px;">

                                <div class="form-group">
                                    <label class="col-md-2 control-label">等级图标<span class="required" >*</span></label>
                                    <div class="col-md-10">
                                        <input type="hidden" id="image" name="image" value="">
                                        <a class="btn btn-default" id="select_image">选择图片</a>
                                        <img src="" style="display: none;width:32px;"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">等级名称<span class="required" >*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" id="name" name="name" value="" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">起始成长值<span class="required" >*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" id="min_growth" name="min_growth" value="" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">最大成长值<span class="required" >*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" id="max_growth" name="max_growth" value="" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">备注<span class="required" >&nbsp;</span></label>
                                    <div class="col-md-10">
                                        <textarea id="remark" name="remark" value="" placeholder="" class="form-control"></textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-2 col-md-10">
                                        <button class="btn green" type="button" onclick="Function_Save()">保存</button>
                                        <button class="btn default" type="button" onclick="Function_Back()">返回</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('foot_script')
    <script type="text/javascript" src="/assets/global/plugins/plupload/js/plupload.full.min.js"></script>

    <script>

        $(function(){

            var setting = {
                rules: {
                    name:{
                        required: true
                    },
                    min_growth:{
                        required: true
                    },
                    max_growth:{
                        required: true
                    },
                },
            }

            WX.Validate('EditForm',setting);

            var options = {
                dataType:  'json',
                success: ShowResponse
            };

            $('#EditForm').ajaxForm(options);

        })

        function ShowResponse(responseText, statusText)
        {
            data = responseText;
            if(data){
                if(data.code == 1)
                {
                    WX.toastr({'type':'success','message':'新增成功','onHidden':function(){
                        location.href = '/admin/growth';
                    }});
                }else{
                    WX.toastr({'type':'error','message':'新增失败'});
                }
            }
        }

        function Function_Save(){

            $('#EditForm').submit();
        }

        function Function_Back(){
            location.href = '/admin/growth';
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
            $("#image").val(response.path);
        });
        uploader.bind('UploadComplete',function(uploader,files){
            //console.log(files);
        });
        uploader.bind('Error',function(uploader,errObject){
            console.log(errObject);
            WX.toastr({'type':'error','timeOut':3000,'message':errObject.message});
        });

    </script>

@endsection


