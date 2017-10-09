@extends('admin.layouts.default')

@section('head_css')
@endsection

@section('content')
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="/">首页</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">广告管理</a>
                </li>
            </ul>
        </div>

        <div class="row" style="margin-top:20px;margin-left:0;margin-right:0">
            <div class="col-md-12" >
                <div class="portlet light bordered">
                    <!-- Begin: life time stats -->
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <span class="caption-subject bold uppercase"> 新增广告</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="AddForm" method="post" role="form" class="form-horizontal">
                                    <div class="form-body">

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">广告名称<span class="required" >*</span></label>
                                            <div class="col-md-4">
                                                <input type="hidden" id="ad_id" name="ad_id" value="{{$item->ad_id}}">
                                                <input type="hidden" id="ad_item_id" name="ad_item_id" value="{{$item->ad_item_id}}">
                                                <input type="text" id="ad_item_title" name="ad_item_title" value="{{$item->ad_item_title}}" placeholder="" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">广告链接<span class="required" ></span></label>
                                            <div class="col-md-4">
                                                <input type="text" id="ad_item_href" name="ad_item_href" value="{{$item->ad_item_href}}" placeholder="" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">广告图片<span class="required" ></span></label>
                                            <div class="col-md-8">
                                                <input type="hidden" id="ad_item_path" name="ad_item_path" value="{{$item->ad_item_path}}">
                                                <a class="btn btn-default" id="select_image">选择图片</a>
                                                @if(!empty($item->ad_item_path))
                                                    <img src="{{$item->ad_item_path}}" style="width:32px;"/>
                                                @else
                                                    <img src="" style="display:none;width:32px;"/>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">备注<span class="required" >&nbsp;</span></label>
                                            <div class="col-md-4">
                                                <textarea id="ad_item_desc" name="ad_item_desc" placeholder="" class="form-control">{{$item->ad_item_desc}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">排序<span class="required" >*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" id="ad_item_sort" name="ad_item_sort" value="{{$item->ad_item_sort}}" placeholder="" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label"></label>
                                            <div class="col-md-10">
                                                <button type="button" class="btn blue" onclick="Function_SaveForm();">保存</button>
                                                <button type="button" onclick="location.href='/admin/ad'" class="btn" class="btn btn-default">返回</button>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>

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
                    ad_item_title: {
                        required: true
                    },
                    ad_item_sort: {
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
                    WX.toastr({'type':'success','message':'修改成功.','onHidden':function(){
                        location.href = "/admin/adItem?id={{$item->ad_id}}";
                    }});
                }else{
                    WX.toastr({'type':'error','message':'修改失败!'});
                }
            }
        }

        function Function_SaveForm(){
            $("#AddForm").attr('action','/admin/adItem/update');
            $("#AddForm").submit();
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
            $("#ad_item_path").val(response.path);
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
