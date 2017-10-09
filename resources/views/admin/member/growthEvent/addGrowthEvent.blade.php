@extends('admin.layouts.default')

@section('head_css')
    <link href="/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
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
                    <a href="#">积分规则</a>
                </li>
            </ul>
        </div>

        <div class="row" style="margin-top:20px;margin-left:0;margin-right:0">
            <div class="col-md-12">
                <div class="portlet light bordered">

                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase"> 新增积分规则</span>
                        </div>
                    </div>

                    <div class="portlet-body form">
                        <form role="form" class="form-horizontal" method="post" id="EditForm" action="/admin/growthEvent/save">
                            <div class="form-body" style="padding-top:30px;">

                                <div class="form-group">
                                    <label class="col-md-2 control-label">规则名称<span class="required" >*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" id="name" name="name" value="" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">唯一编码<span class="required" >*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" id="code" name="code" value="" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">成长值<span class="required" >*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" id="growth" name="growth" value="" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">开始时间<span class="required" >*</span></label>
                                    <div class="col-md-10">
                                        <input class="form-control form-control-inline input-medium date-picker" id="start_time" name="start_time" type="text" value="" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">结束时间<span class="required" >*</span></label>
                                    <div class="col-md-10">
                                        <input class="form-control form-control-inline input-medium date-picker" id="end_time" name="end_time" type="text" value="" />
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
    <script type="text/javascript" src="/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.zh-CN.min.js"></script>

    <script>

        $(function(){

            $('#start_time').datepicker({
                rtl: App.isRTL(),
                format: 'yyyy-mm-dd',
                language: "zh-CN",
                autoclose: true,
                clearBtn:true,
            }).on('changeDate', function(ev){
                if(ev.date){
                    $('#end_time').datepicker('setStartDate', new Date(ev.date.valueOf()))
                }else{
                    $('#end_time').datepicker('setStartDate',null);
                }
            });

            $('#end_time').datepicker({
                rtl: App.isRTL(),
                format: 'yyyy-mm-dd',
                language: "zh-CN",
                autoclose: true,
                clearBtn:true,
            }).on('changeDate', function(ev){
                if(ev.date){
                    $('#start_time').datepicker('setEndDate', new Date(ev.date.valueOf()))
                }else{
                    $('#start_time').datepicker('setEndDate',new Date());
                }
            });

            var setting = {
                rules: {
                    name:{
                        required: true
                    },
                    code:{
                        required: true
                    },
                    growth:{
                        required: true
                    },
                    start_time:{
                        required: true
                    },
                    end_time:{
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
                        location.href = '/admin/growthEvent';
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
            location.href = '/admin/growthEvent';
        }

    </script>

@endsection


