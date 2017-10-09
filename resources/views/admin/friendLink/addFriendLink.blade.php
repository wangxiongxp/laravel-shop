@extends('admin.layouts.default')

@section('head_css')
    <script type="text/javascript" src="/assets/global/plugins/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/plupload/js/plupload.full.min.js"></script>
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
                    <a href="#">友情链接</a>
                </li>
            </ul>
        </div>

        <div class="row" style="margin-top:20px;margin-left:0;margin-right:0">
            <div class="col-md-12">

                <div class="portlet light bordered">

                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <span class="caption-subject bold uppercase"> 新增友情链接</span>
                        </div>
                    </div>

                    <div class="portlet-body form">
                        <form role="form" class="form-horizontal" method="post" id="AddForm" action="">
                            <div class="form-body" style="padding-top:30px;">

                                <div class="form-group">
                                    <label class="col-md-2 control-label">链接名称<span class="required" >*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" id="link_title" name="link_title" placeholder="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">链接地址<span class="required" >*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" id="link_href" name="link_href" placeholder="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">链接图片<span class="required" ></span></label>
                                    <div class="col-md-4">
                                        <input type="hidden" id="link_image" name="link_image" >
                                        <a class="btn btn-default" id="select_image">选择图片</a>
                                        <img src="" style="display: none;width:32px;"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">备注<span class="required" >&nbsp;</span></label>
                                    <div class="col-md-4">
                                        <textarea id="link_desc" name="link_desc" placeholder="" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">排序<span class="required" >*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" id="link_sort" name="link_sort" placeholder="" class="form-control">
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

    <script type="text/javascript">

        $(document).ready(function(){

            var setting = {
                rules: {
                    link_title: {
                        required: true
                    },
                    link_href: {
                        required: true
                    },
                    link_sort: {
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
                        location.href = "/admin/friendLink";
                    }});
                }else{
                    WX.toastr({'type':'error','message':'保存失败!'});
                }
            }
        }

        function Function_Save(){
            $("#AddForm").attr('action','/admin/friendLink/save');
            $("#AddForm").submit();
        }

        function Function_Back(){
            location.href = "/admin/friendLink" ;
        }
    </script>


    <script type="text/javascript" src="/assets/global/plugins/plupload/js/plupload.full.min.js"></script>

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
            $("#link_image").val(response.path);
            $("#select_image").next('img').attr('src',response.path).show() ;
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
