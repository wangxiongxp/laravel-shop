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
                                                <input type="text" id="name" name="name" value="" placeholder="" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">关键字<span class="required" >*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" id="code" name="code" value="" placeholder="" class="form-control" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">状态<span class="required" >*</span></label>
                                            <div  class="col-md-10" >
                                                <div class="radio-list ">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="status" id="status_1" value="1" checked="checked" />开启
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="status" id="status_2" value="0" />关闭
                                                    </label>
                                                </div>
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

        $(function(){

            App.initUniform();

            var setting = {
                rules: {
                    name: {
                        required: true
                    },
                    code: {
                        required: true
                    },
                    status: {
                        required: true,
                    }
                },
            }

            WX.Validate('AddForm',setting);

            var options = {
                dataType:  'json',
                beforeSubmit:  function() {
                    App.blockUI({ animate: true});
                    return true;
                },
                success: function(responseText){
                    App.unblockUI();
                    if(responseText){
                        if(responseText.code == 1) {
                            WX.toastr({'type':'success','message':'新增成功！', 'onHidden':function(){
                                location.href = "/admin/ad";
                            }});
                        }else{
                            WX.toastr({'type':'error','message': '新增失败'});
                        }
                    }
                }
            };
            $('#AddForm').ajaxForm(options);

        })

        function Function_SaveForm(){
            $("#AddForm").attr('action','/admin/ad/save');
            $("#AddForm").submit();
        }

    </script>
@endsection
