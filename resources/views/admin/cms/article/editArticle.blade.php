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
                    <a href="#">文章管理</a>
                </li>
            </ul>
        </div>

        <div class="row" style="margin-top:20px;margin-left:0;margin-right:0">
            <div class="col-md-12">

                <div class="portlet light bordered">

                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <span class="caption-subject bold uppercase"> 编辑文章</span>
                        </div>
                    </div>

                    <div class="portlet-body form">
                        <form role="form" class="form-horizontal" method="post" id="EditForm" action="/admin/cms/article/update">
                            <div class="form-body" style="padding-top:30px;">

                                <div class="form-group">
                                    <input type="hidden" id="id" name="id" value="{{$article->id}}" >
                                    <input type="hidden" id="status" name="status" value="{{$article->status}}" >
                                    <label class="col-md-2 control-label">所属栏目<span class="required" >*</span></label>
                                    <div class="col-md-4">
                                        <p class="form-control-static">{{$article->catalog_name}}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">文章标题<span class="required" >*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" id="title" name="title" value="{{$article->title}}" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">副标题<span class="required" ></span></label>
                                    <div class="col-md-10">
                                        <input type="text" id="sub_title" name="sub_title" value="{{$article->sub_title}}" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">文章主图<span class="required" >*</span></label>
                                    <div class="col-md-10">
                                        <input type="hidden" id="logo" name="logo" value="" >
                                        <a id="upload_image" class="btn btn-primary">选择图片</a>
                                        @if(!empty($article->logo))
                                            <img src="{{$article->logo}}" style="width:32px;"/>
                                        @else
                                            <img src="" style="display:none;width:32px;"/>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">文章摘要<span class="required" ></span></label>
                                    <div class="col-md-10">
                                        <textarea id="summary" name="summary" value="" placeholder="" class="form-control">{{$article->summary}}</textarea>
                                    </div>
                                </div>

                                {{--<div class="form-group">--}}
                                    {{--<label class="col-md-2 control-label">文章类型<span class="required" >*</span></label>--}}
                                    {{--<div class="col-md-10">--}}
                                        {{--<select id="type" name="type" value="" class="form-control">--}}
                                            {{--<option value="1">图文混排</option>--}}
                                            {{--<option value="2">图片</option>--}}
                                            {{--<option value="3">视频</option>--}}
                                        {{--</select>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                <div class="form-group">
                                    <label class="col-md-2 control-label">文章内容<span class="required" >*</span></label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" id="content" name="content">{{$article->content}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">允许评论<span class="required" >*</span></label>
                                    <div  class="col-md-8" >
                                        <div class="radio-list ">
                                            <label class="radio-inline">
                                                <input type="radio" name="allow_comment" value="1" checked="checked" />允许
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="allow_comment" value="0" />不允许
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-2 col-md-10">
                                        <button class="btn green" type="button" onclick="Function_Save(1)">立即发布</button>
                                        <button class="btn green" type="button" onclick="Function_Save(0)">保存草稿</button>
                                        <button class="btn default" type="button" onclick="Function_Back()">放弃保存</button>
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

        $(function(){

            SetRadioSelected('allow_comment','{{$article->allow_comment}}')
            App.initUniform();

            CKEDITOR.replace('content',{ toolbar : 'Basic'});

            $("#type").val('{{$article->type}}');

            var setting = {
                rules: {
                    title:{
                        required: true
                    },
                    allow_comment:{
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
                    WX.toastr({'type':'success','message':'发布成功','onHidden':function(){
                        location.href = '/admin/cms/article';
                    }});
                }else{
                    WX.toastr({'type':'error','message':'发布失败'});
                }
            }
        }

        function Function_Save(status){

            if(status==0){
                $("#status").val('DRAFT');
            }else if(status==1){
                $("#status").val('PUBLISHED');
            }else{
                return false;
            }

            var pdata = CKEDITOR.instances.content.getData();
            $("#content").val(pdata);

            if( pdata.length == 0){
                WX.toastr({'type':'info','message':'请完善文章详情...'});
                return false;
            }

            $('#EditForm').submit();
        }

        function Function_Back(){
            location.href = '/admin/cms/article';
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
                '_token':'{{ csrf_token() }}',
                'type':'productCategory'
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
            $("#logo").val(response.path);
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
