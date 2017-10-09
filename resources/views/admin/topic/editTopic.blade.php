@extends('admin.layouts.default')

@section('head_css')

@endsection

@section('content')
    <div class="page-content" id="app">
        <!-- BEGIN PAGE HEADER-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="/">首页</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">专题推广</a>
                </li>
            </ul>
        </div>

        <div class="row" style="margin-top:20px;margin-left:0;margin-right:0">
            <div class="col-md-12">
                <div class="portlet light bordered">

                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <span class="caption-subject bold uppercase"> 编辑专题</span>
                        </div>
                    </div>

                    <div class="portlet-body form">

                        <form id="AddForm" method="post" role="form" class="form-horizontal">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">专题名称<span class="required" >*</span></label>
                                    <div class="col-md-8">
                                        <input type="hidden" id="topic_id" name="topic_id" value="{{$item->topic_id}}">
                                        <input type="text" id="topic_title" name="topic_title" value="{{$item->topic_title}}" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">专题摘要<span class="required" >&nbsp;</span></label>
                                    <div class="col-md-8">
                                        <textarea id="topic_summary" name="topic_summary" placeholder="" class="form-control">{{$item->topic_summary}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">专题图片<span class="required" >*</span></label>
                                    <div class="col-md-8">
                                        <input type="hidden" id="topic_image" name="topic_image" >
                                        <a class="btn btn-default" id="select_image">选择图片</a>
                                        @if(!empty($item->topic_image))
                                            <img src="{{$item->topic_image}}" style="width:32px;"/>
                                        @else
                                            <img src="" style="display:none;width:32px;"/>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">详细信息<span class="required" >*</span></label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" id="topic_desc" name="topic_desc">{{$item->topic_desc}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">状态<span class="required" >*</span></label>
                                    <div  class="col-md-10" >
                                        <div class="radio-list ">
                                            <label class="radio-inline">
                                                <input type="radio" name="topic_status" id="topic_status_1" value="1" />显示
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="topic_status" id="topic_status_2" value="0" />不显示
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-2 col-md-10">
                                            <button class="btn green" type="button" onclick="Function_SaveForm()">保存</button>
                                            <button class="btn default" type="button" onclick="Function_Back()">返回</button>
                                        </div>
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
    <script type="text/javascript" src="/assets/global/plugins/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/plupload/js/plupload.full.min.js"></script>
    <script>

        $(document).ready(function(){

            SetRadioSelected('topic_status','{{$item->topic_status}}')
            App.initUniform();

            CKEDITOR.replace('topic_desc',{ toolbar : 'Basic'});
            var setting = {
                rules: {
                    topic_title: {
                        required: true
                    },
                    topic_image: {
                        required: true
                    },
                    topic_status: {
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
            var data = responseText;
            if(data){
                if(data.code == 1)
                {
                    WX.toastr({'type':'success','message':'保存成功.','onHidden':function(){
                        location.href = "/admin/topic";
                    }});
                }else{
                    WX.toastr({'type':'error','message':'保存失败!'});
                }
            }
        }

        function Function_SaveForm(){
            var pdata = CKEDITOR.instances.topic_desc.getData();
            $("#topic_desc").val(pdata);

            if( pdata.length == 0){
                WX.toastr({'type':'info','message':'请完善详情...'});
                return false;
            }
            $("#AddForm").attr('action','/admin/topic/update');
            $("#AddForm").submit();
        }

        function Function_Back(){
            location.href = "/admin/topic";
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
            $("#topic_image").val(response.path);
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
