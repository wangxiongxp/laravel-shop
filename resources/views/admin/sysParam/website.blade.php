@extends('admin.layouts.default')

@section('head_css')
    <link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/datatables.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css"/>
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
                <a href="#">网站设置</a>
            </li>
        </ul>
    </div>

    <div class="row" style="margin-top:20px;">
        <div class="col-md-12" >
            <div class="portlet light bordered">

                <div class="portlet-body form">

                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_website" data-toggle="tab"> 网站信息 </a>
                        </li>
                        <li>
                            <a href="#tab_email" data-toggle="tab"> 邮箱设置 </a>
                        </li>
                        <li>
                            <a href="#tab_sms" data-toggle="tab"> 短信设置 </a>
                        </li>
                        <li>
                            <a href="#tab_pay" data-toggle="tab"> 支付设置 </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="tab_website">
                            <form role="form" class="form-horizontal" method="post" id="WebsiteForm" action="/admin/sysParam/save">
                                <div class="form-body">

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">站点标题<span class="required" ></span></label>
                                        <div class="col-md-8">
                                            <input type="text" id="site_title" name="site_title" value="{{$site_title}}" placeholder="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">站点关键字<span class="required" ></span></label>
                                        <div class="col-md-8">
                                            <textarea rows="3" id="site_keyword" name="site_keyword"  class="form-control">{{$site_keyword}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">站点描述<span class="required" ></span></label>
                                        <div class="col-md-8">
                                            <textarea rows="3" id="site_desc" name="site_desc" class="form-control">{{$site_desc}}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">版权信息<span class="required" ></span></label>
                                        <div class="col-md-8">
                                            <input type="text" id="site_copyright" name="site_copyright" value="{{$site_copyright}}" placeholder="" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-2 col-md-9">
                                            <button class="btn green" type="button" onclick="javascript:$('#WebsiteForm').submit();">提交</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade " id="tab_email">
                            <form role="form" class="form-horizontal" method="post" id="EmailForm" action="/admin/sysParam/save">
                                <div class="form-body">

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">发件人的昵称<span class="required" >*</span></label>
                                        <div class="col-md-10">
                                            <input type="text" id="mail_from_name" name="mail_from_name" value="{{$mail_from_name}}" placeholder="" class="form-control input-medium">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">发送邮件地址<span class="required" >*</span></label>
                                        <div class="col-md-10">
                                            <input type="text" id="mail_from_address" name="mail_from_address" value="{{$mail_from_address}}" placeholder="" class="form-control input-medium input-inline">
                                            <span class="help-inline"> PS：service@163.com</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">后台收取邮箱<span class="required" >*</span></label>
                                        <div class="col-md-10">
                                            <input type="text" id="mail_admin_email" name="mail_admin_email" value="{{$mail_admin_email}}" placeholder="" class="form-control input-medium">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">回复邮箱<span class="required" >*</span></label>
                                        <div class="col-md-10">
                                            <input type="text" id="mail_replay_email" name="mail_replay_email" value="{{$mail_replay_email}}" placeholder="" class="form-control input-medium">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">SMTP地址<span class="required" >*</span></label>
                                        <div class="col-md-10">
                                            <input type="text" id="mail_host" name="mail_host" value="{{$mail_host}}" placeholder="" class="form-control input-medium input-inline">
                                            <span class="help-inline"> PS：smtp.163.com</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">用户名<span class="required" >*</span></label>
                                        <div class="col-md-10">
                                            <input type="text" id="mail_username" name="mail_username" value="{{$mail_username}}" placeholder="" class="form-control input-medium input-inline">
                                            <span class="help-inline"> PS：邮局用户名(请填写完整的email地址)</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">密码<span class="required" >*</span></label>
                                        <div class="col-md-10">
                                            <input type="password" id="mail_password" name="mail_password" value="{{$mail_password}}" placeholder="" class="form-control input-medium">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">端口<span class="required" ></span></label>
                                        <div class="col-md-10">
                                            <input type="text" id="mail_port" name="mail_port" value="{{$mail_port}}" placeholder="" class="form-control input-medium input-inline">
                                            <span class="help-inline"> SMTP端口号(默认：25)</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">加密方式<span class="required" >*</span></label>
                                        <div  class="col-md-10" >
                                            <div class="radio-list ">
                                                <label class="radio-inline">
                                                    <input type="radio" name="mail_ssl" id="mail_ssl_0" value="0" />不加密
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="mail_ssl" id="mail_ssl_1" value="1" />SSL
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="mail_ssl" id="mail_ssl_2" value="2" />TLS
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">邮件检测<span class="required" ></span></label>
                                        <div class="col-md-10">
                                            <p class="form-control-static">
                                                <a href="javascript:void(0)" onclick="sendEmail();">点击发送测试邮件</a> (请先提交邮局信息后再点击测试，点击后请到对应邮箱查看测试信息）
                                            </p>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-2 col-md-9">
                                            <button class="btn green" type="button" onclick="javascript:$('#EmailForm').submit();">提交</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade " id="tab_sms">
                            <form role="form" class="form-horizontal" method="post" id="SmsForm" action="/admin/sysParam/save">
                                <div class="form-body">

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">开关<span class="required" >*</span></label>
                                        <div  class="col-md-10" >
                                            <div class="radio-list ">
                                                <label class="radio-inline">
                                                    <input type="radio" name="alidayu_enabled" id="alidayu_enabled_1" value="1" />打开
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="alidayu_enabled" id="alidayu_enabled_2" value="0" />关闭
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">App Key<span class="required" >*</span></label>
                                        <div class="col-md-6">
                                            <input type="text" id="alidayu_app_key" name="alidayu_app_key" value="{{$alidayu_app_key}}" placeholder="" class="form-control ">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">App Secret<span class="required" >*</span></label>
                                        <div class="col-md-6">
                                            <input type="text" id="alidayu_app_secret" name="alidayu_app_secret" value="{{$alidayu_app_secret}}" placeholder="" class="form-control ">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">短信签名<span class="required" >*</span></label>
                                        <div class="col-md-6">
                                            <input type="text" id="alidayu_sign_name" name="alidayu_sign_name" value="{{$alidayu_sign_name}}" placeholder="" class="form-control ">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">短信模板<span class="required" >*</span></label>
                                        <div class="col-md-6">
                                            <input type="text" id="alidayu_template_code" name="alidayu_template_code" value="{{$alidayu_template_code}}" placeholder="" class="form-control ">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">短信检测<span class="required" ></span></label>
                                        <div class="col-md-10">
                                            <input type="text" id="alidayu_test_phone" name="alidayu_test_phone" placeholder="请填写手机号码" class="form-control input-medium">
                                            <span class="help-inline"> <a href="javascript:void(0)" onclick="sendMessage();">点击发送测试短信</a> (请先提交相关信息再点击测试，点击后请到对应手机查看测试信息）</span>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-2 col-md-9">
                                            <button class="btn green" type="button" onclick="javascript:$('#SmsForm').submit();">提交</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade " id="tab_pay">
                            <form role="form" class="form-horizontal" method="post" id="PayForm" action="/admin/sysParam/save">
                                <div class="form-body">

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">发件人的昵称<span class="required" >*</span></label>
                                        <div class="col-md-10">
                                            <input type="text" id="mail_sender_name" name="mail_sender_name" value="" placeholder="" class="form-control input-medium">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">发送邮件地址<span class="required" >*</span></label>
                                        <div class="col-md-10">
                                            <input type="text" id="mail_sender_email" name="mail_sender_email" value="}" placeholder="" class="form-control input-medium input-inline">
                                            <span class="help-inline"> PS：service@163.com</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">后台收取邮箱<span class="required" >*</span></label>
                                        <div class="col-md-10">
                                            <input type="text" id="mail_admin_email" name="mail_admin_email" value="}" placeholder="" class="form-control input-medium">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">回复邮箱<span class="required" >*</span></label>
                                        <div class="col-md-10">
                                            <input type="text" id="mail_replay_email" name="mail_replay_email" value="" placeholder="" class="form-control input-medium">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">端口<span class="required" ></span></label>
                                        <div class="col-md-10">
                                            <input type="text" id="site_title" name="site_title" value="" placeholder="" class="form-control input-medium input-inline">
                                            <span class="help-inline"> SMTP端口号(默认：25)</span>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-2 col-md-9">
                                            <button class="btn green" type="button" onclick="javascript:$('#PayForm').submit();">提交</button>
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
    <script type="text/javascript" src="/assets/global/plugins/plupload/js/plupload.full.min.js"></script>

    <script type="text/javascript">

        $(function(){

            SetRadioSelected('mail_ssl','{{ $mail_ssl}}');
            SetRadioSelected('alidayu_enabled','{{ $alidayu_enabled}}');
            App.initUniform();

            var setting_website = {
                rules: {
//                    site_title: {
//                        required: true,
//                    },
//                    site_keyword: {
//                        required: true,
//                    },
//                    site_copyright: {
//                        required: true,
//                    },
                },
            }
            WX.Validate('WebsiteForm',setting_website);

            var setting_email = {
                rules: {
                    mail_sender_name: {
                        required: true,
                    },
                    mail_sender_email: {
                        required: true,
                        email: true
                    },
                    mail_admin_email: {
                        required: true,
                        email: true
                    },
                    mail_replay_email: {
                        required: true,
                        email: true
                    },
                    mail_host: {
                        required: true,
                    },
                    mail_username: {
                        required: true,
                    },
                    mail_password: {
                        required: true,
                    },
                },
            }
            WX.Validate('EmailForm',setting_email);

            var setting_sms = {
                rules: {
                    alidayu_enabled: {
                        required: true,
                    },
                    alidayu_app_key: {
                        required: true,
                    },
                    alidayu_app_secret: {
                        required: true,
                    },
                    alidayu_sign_name: {
                        required: true,
                    },
                    alidayu_template_code: {
                        required: true,
                    },
                },
            }
            WX.Validate('SmsForm',setting_sms);

            var setting_pay = {
                rules: {
                    site_title: {
                        required: true,
                    },
                },
            }
            WX.Validate('PayForm',setting_pay);

            var options = {
                dataType:  'json',
                //beforeSubmit: ShowRequest ,
                success: ShowResponse ,
            };
            $('#WebsiteForm').ajaxForm(options);
            $('#EmailForm').ajaxForm(options);
            $('#SmsForm').ajaxForm(options);
            $('#PayForm').ajaxForm(options);
        });

        function ShowResponse(responseText, statusText) {
            data = responseText;
            if(data){
                if(data.code == 1)
                {
                    WX.toastr({'type':'success','message':'Success.','onHidden':function(){
                        location.href = location.href;
                    }});
                }else{
                    WX.toastr({'type':'error','message':'Error.'});
                }
            }
        }

        function sendEmail(){
            var url = "/admin/sysParam/sendEmail" ;
            AjaxAction({'url':url,'method':"POST", 'success':function(data){
                if(data.code == 1) {
                    WX.toastr({'type':'success','message':'发送成功.'});
                } else {
                    WX.toastr({'type':'error','message':'发送失败.'});
                }
            }});
        }

        function sendMessage(){
            var alidayu_test_phone = $("#alidayu_test_phone").val();
            if(alidayu_test_phone == ''){
                return false;
            }
            var url = "/admin/sysParam/sendMessage/"+alidayu_test_phone ;
            AjaxAction({'url':url,'method':"POST", 'success':function(data){
                if(data.code == 1) {
                    WX.toastr({'type':'success','message':'发送成功.'});
                } else {
                    WX.toastr({'type':'error','message':'发送失败.'});
                }
            }});
        }

    </script>

@endsection
