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
                    <a href="#">分类频道</a>
                </li>
            </ul>
        </div>

        <div class="row" style="margin-top:20px;margin-left:0;margin-right:0">
            <div class="col-md-12">

                <div class="portlet light bordered">

                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <span class="caption-subject bold uppercase"> 新增频道</span>
                        </div>
                    </div>

                    <div class="portlet-body form">
                        <form role="form" class="form-horizontal" method="post" id="AddForm" action="">
                            <div class="form-body" style="padding-top:30px;">

                                <div class="form-group">
                                    <label class="col-md-2 control-label">频道名称<span class="required" >*</span></label>
                                    <div class="col-md-6">
                                        <input type="text" id="channel_title" name="channel_title" placeholder="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">频道摘要<span class="required" >&nbsp;</span></label>
                                    <div class="col-md-6">
                                        <textarea id="channel_summary" name="channel_summary" placeholder="" class="form-control"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">关联分类<span class="required" >*</span></label>
                                    <div class="col-md-3">
                                        <select class="form-control" id="category_id" name="category_id">
                                            <option value="">==请选择==</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">状态<span class="required" >*</span></label>
                                    <div  class="col-md-10" >
                                        <div class="radio-list ">
                                            <label class="radio-inline">
                                                <input type="radio" name="channel_status" id="channel_status_1" value="1" checked="checked" />开启
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="channel_status" id="channel_status_2" value="0" />关闭
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">排序<span class="required" >*</span></label>
                                    <div class="col-md-6">
                                        <input type="text" id="channel_sort" name="channel_sort" placeholder="" class="form-control">
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

    <script>

        $(document).ready(function(){

            ajaxSelectSimple('/admin/productCat/getCatalogByParent/0','category_id','cat_id','cat_title');

            var setting = {
                rules: {
                    channel_title: {
                        required: true
                    },
                    channel_status: {
                        required: true
                    },
                    channel_sort: {
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
                        location.href = "/admin/channel";
                    }});
                }else{
                    WX.toastr({'type':'error','message':'保存失败!'});
                }
            }
        }

        function Function_Save(){
            $("#AddForm").attr('action','/admin/channel/save');
            $("#AddForm").submit();
        }

        function Function_Back(){
            location.href = "/admin/channel"
        }

        </script>
@endsection
