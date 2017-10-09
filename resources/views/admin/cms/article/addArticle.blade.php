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
                        <span class="caption-subject bold uppercase"> 新增文章</span>
                    </div>
                </div>

                <div class="portlet-body form">
                    <form role="form" class="form-horizontal" method="post" id="EditForm" action="/admin/cms/article/save">
                        <div class="form-body" style="padding-top:30px;">

                            <div class="form-group">
                                <input type="hidden" id="catalog_id" name="catalog_id" value="" >
                                <input type="hidden" id="status" name="status" value="PUBLISH" >
                                <label class="col-md-2 control-label">所属栏目<span class="required" >*</span></label>
                                <div class="col-md-4">
                                    <select id="catalog_id_1" name="catalog_id_1" class="table-group-action-input form-control input-medium">
                                        <option value="">==请选择==</option>
                                    </select>
                                </div>
                                <div class="col-md-4" >
                                    <select style="display: none" id="catalog_id_2" name="catalog_id_2" class="table-group-action-input form-control input-medium">
                                        <option value="">==请选择==</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">文章标题<span class="required" >*</span></label>
                                <div class="col-md-10">
                                    <input type="text" id="title" name="title" value="" placeholder="" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">副标题<span class="required" ></span></label>
                                <div class="col-md-10">
                                    <input type="text" id="sub_title" name="sub_title" value="" placeholder="" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">文章主图<span class="required" >*</span></label>
                                <div class="col-md-10">
                                    <input type="hidden" id="logo" name="logo" value="" >
                                    <a id="select_image" class="btn btn-primary">选择图片</a>
                                    <img style="display: none;" width="50px;" height="50px" id="" src=""/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">文章摘要<span class="required" ></span></label>
                                <div class="col-md-10">
                                    <textarea id="summary" name="summary" value="" placeholder="" class="form-control"></textarea>
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
                                    <textarea class="form-control" id="content" name="content"></textarea>
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

            CKEDITOR.replace('content',{ toolbar : 'Basic'});

            ajaxSelectSimple('/admin/catalog/getCatalogByParent/0','catalog_id_1','id','name','');

            $("#catalog_id_1").change(function(){
                $("#catalog_id").val('');

                $("#catalog_id_2").hide();
                $("#catalog_id_2").val('');
                $("#catalog_id_2 option:gt(0)").remove();

                var catalog_id_1 = $(this).val();
                if(catalog_id_1 != ''){
                    ajaxSelectSimple('/admin/catalog/getCatalogByParent/'+catalog_id_1 ,'catalog_id_2','id','name','');
                    if($("#catalog_id_2 option").size()>1){
                        $("#catalog_id_2").show();
                    }
                }
            });

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

            var catalog_id_1 = $("#catalog_id_1").val();
            var catalog_id_2 = $("#catalog_id_2").val();

            if(catalog_id_2 != ''){
                $("#catalog_id").val(catalog_id_2);
            }else{
                $("#catalog_id").val(catalog_id_1);
            }

            if($("#catalog_id").val()==''){
                WX.toastr({'type':'info','message':'请选择分类...'});
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
