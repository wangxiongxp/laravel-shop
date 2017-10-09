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
                    <a href="#">导航页面</a>
                </li>
            </ul>
        </div>

        <div class="row" style="margin-top:20px;margin-left:0;margin-right:0">
            <div class="col-md-12">

                <div class="portlet light bordered">

                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <span class="caption-subject bold uppercase"> 新增导航</span>
                        </div>
                    </div>

                    <div class="portlet-body form">
                        <form role="form" class="form-horizontal" method="post" id="AddForm" action="">
                            <div class="form-body" style="padding-top:30px;">

                                <div class="form-group">
                                    <label class="col-md-2 control-label">父级导航<span class="required" >*</span></label>
                                    <div class="col-md-4">
                                        <select class="form-control" id="parent_id" name="parent_id">
                                            <option value='0'>首级导航</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">导航名称<span class="required" >*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" id="nav_title" name="nav_title" placeholder="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">导航链接<span class="required" >&nbsp;</span></label>
                                    <div class="col-md-4">
                                        <input id="nav_path" name="nav_path" placeholder="" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">导航类型<span class="required" >*</span></label>
                                    <div class="col-md-4">
                                        <select class="form-control" id="nav_type" name="nav_type">
                                            <option value="">==请选择==</option>
                                            <option value="1">顶部导航</option>
                                            <option value="2">底部导航</option>
                                            <option value="3">顶部+底部导航</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">状态<span class="required" >*</span></label>
                                    <div  class="col-md-10" >
                                        <div class="radio-list ">
                                            <label class="radio-inline">
                                                <input type="radio" name="nav_status" id="nav_status_1" value="1" checked="checked" />开启
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="nav_status" id="nav_status_2" value="0" />关闭
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">排序<span class="required" >*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" id="nav_sort" name="nav_sort" placeholder="" class="form-control">
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

            ajaxSelectSimple('/admin/navigation/getFirstNav','parent_id','nav_id','nav_title');

            var setting = {
                rules: {
                    nav_title: {
                        required: true
                    },
                    nav_type: {
                        required: true
                    },
                    nav_status: {
                        required: true
                    },
                    nav_sort: {
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
                        location.href = "/admin/navigation";
                    }});
                }else{
                    WX.toastr({'type':'error','message':'保存失败!'});
                }
            }
        }

        function Function_Save(){
            $("#AddForm").attr('action','/admin/navigation/save');
            $("#AddForm").submit();
        }

        function Function_Back(){
            location.href = '/admin/navigation';
        }

    </script>

@endsection


