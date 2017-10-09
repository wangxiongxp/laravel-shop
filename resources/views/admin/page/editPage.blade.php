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
                    <a href="#">文章管理</a>
                </li>
            </ul>
        </div>

        <div class="row" style="margin-top:20px;margin-left:0;margin-right:0">
            <div class="col-md-12">

                <div class="portlet light bordered">

                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <span class="caption-subject bold uppercase"> 编辑页面</span>
                        </div>
                    </div>

                    <div class="portlet-body form">
                        <form role="form" class="form-horizontal" method="post" id="EditForm" action="/admin/page/update">
                            <div class="form-body" style="padding-top:30px;">

                                <div class="form-group">
                                    <label class="col-md-2 control-label">自定义Url<span class="required" ></span></label>
                                    <div class="col-md-10">
                                        <input type="text" id="page_url" name="page_url" value="{{$item->page_url}}" placeholder="" class="form-control input-medium input-inline">
                                        <span class="help-inline"> PS：about-us</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">状态<span class="required" >*</span></label>
                                    <div  class="col-md-10" >
                                        <div class="radio-list ">
                                            <label class="radio-inline">
                                                <input type="radio" name="status" id="status_1" value="1" />开启
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="status" id="status_2" value="0" />关闭
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">页面名称<span class="required" >*</span></label>
                                    <div class="col-md-10">
                                        <input type="hidden" id="page_id" name="page_id" value="{{$item->page_id}}" >
                                        <input type="text" id="page_name" name="page_name" value="{{$item->page_name}}" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">页面摘要<span class="required" ></span></label>
                                    <div class="col-md-10">
                                        <textarea id="summary" name="page_summary" value="" placeholder="" class="form-control">{{$item->page_summary}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">页面内容<span class="required" >*</span></label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" id="page_content" name="page_content">{{$item->page_content}}</textarea>
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
    <script type="text/javascript" src="/assets/global/plugins/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/plupload/js/plupload.full.min.js"></script>

    <script>

        $(function(){

            SetRadioSelected('status','{{$item->status}}')
            App.initUniform();

            CKEDITOR.replace('page_content',{ toolbar : 'Basic'});

            var setting = {
                rules: {
                    page_name:{
                        required: true
                    },
                    status:{
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
                        location.href = '/admin/page';
                    }});
                }else{
                    WX.toastr({'type':'error','message':'发布失败'});
                }
            }
        }

        function Function_Save(){

            var pdata = CKEDITOR.instances.page_content.getData();
            $("#page_content").val(pdata);

            if( pdata.length == 0){
                WX.toastr({'type':'info','message':'请完善文章详情...'});
                return false;
            }

            $('#EditForm').submit();
        }

        function Function_Back(){
            location.href = '/admin/page';
        }

    </script>

@endsection
