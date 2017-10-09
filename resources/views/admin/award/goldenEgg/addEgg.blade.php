@extends('admin.layouts.default')

@section('head_css')
    <link href="/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
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
                    <a href="#">互动营销</a>
                </li>
            </ul>
        </div>

        <div class="row" style="margin-top:20px;margin-left:0;margin-right:0">
            <div class="col-md-12">

                <div class="portlet light bordered" id="form_wizard_1">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject bold uppercase"> 幸运砸蛋</span>
                        </div>
                        <div class="actions">
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form class="form-horizontal" id="submit_form" method="POST">
                            <div class="form-wizard">
                                <div class="form-body">
                                    <ul class="nav nav-pills nav-justified steps">
                                        <li>
                                            <a href="#tab1" data-toggle="tab" class="step">
                                                <span class="number"> 1 </span>
                                                <span class="desc"> <i class="fa fa-check"></i> 创建活动 </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#tab2" data-toggle="tab" class="step">
                                                <span class="number"> 2 </span>
                                                <span class="desc"> <i class="fa fa-check"></i> 用户参与设置 </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#tab3" data-toggle="tab" class="step">
                                                <span class="number"> 3 </span>
                                                <span class="desc"> <i class="fa fa-check"></i> 中奖设置 </span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div id="bar" class="progress progress-striped" role="progressbar">
                                        <div class="progress-bar progress-bar-success"> </div>
                                    </div>
                                    <div class="tab-content">

                                        <div class="tab-pane active" id="tab1">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">活动名称<span class="required" >*</span></label>
                                                <div class="col-md-4">
                                                    <input type="hidden" id="award_type" name="award_type" value="3" />
                                                    <input type="text" id="award_name" name="award_name" placeholder="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">开始时间<span class="required" >*</span></label>
                                                <div class="col-md-4">
                                                    <div class="input-group date form_datetime">
                                                        <input type="text" id="start_time" name="start_time" readonly class="form-control">
                                                        <span class="input-group-btn">
                                                            <button class="btn default date-set" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">结束时间<span class="required" >*</span></label>
                                                <div class="col-md-4">
                                                    <div class="input-group date form_datetime">
                                                        <input type="text" id="end_time" name="end_time" readonly class="form-control">
                                                        <span class="input-group-btn">
                                                            <button class="btn default date-set" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">活动说明<span class="required" >&nbsp;</span></label>
                                                <div class="col-md-6">
                                                    <textarea id="award_desc" name="award_desc" placeholder="" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab2">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">消耗积分<span class="required" >*</span></label>
                                                <div class="col-md-6">
                                                    <input type="text" id="cost_point" name="cost_point" placeholder="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">参与送积分<span class="required" >*</span></label>
                                                <div class="col-md-6">
                                                    <input type="text" id="give_point" name="give_point" placeholder="" class="form-control">
                                                    <p class="form-control-static">
                                                        <input name="give_point_to_loser" value="1" type="checkbox"> 仅送给未中奖用户
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">参与次数<span class="required" >*</span></label>
                                                <div class="col-md-8">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input name="time_limit" value="1" type="radio" checked="checked">
                                                            一人一次
                                                        </label>
                                                        <label>
                                                            <input name="time_limit" value="2" type="radio">
                                                            一天一次
                                                        </label>
                                                        <label>
                                                            <input name="time_limit" value="3" type="radio">
                                                            不限次数
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab3">

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">中奖概率<span class="required" >*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" id="probability" name="probability" placeholder="" class="form-control">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-offset-2 col-md-8">
                                                    <div class="portlet-body tabbable-custom ">
                                                        <ul class="nav nav-tabs">
                                                            <li class="active">
                                                                <a href="#tab_1" data-toggle="tab"> 一等奖 </a>
                                                            </li>
                                                            <li>
                                                                <a href="#tab_2" data-toggle="tab"> 二等奖 </a>
                                                            </li>
                                                            <li >
                                                                <a href="#tab_3" data-toggle="tab"> 三等奖</a>
                                                            </li>
                                                            <li >
                                                                <a href="#tab_4" data-toggle="tab"> 普通奖</a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content">
                                                            <div class="tab-pane fade active in" id="tab_1">
                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">选择奖品<span class="required" >*</span></label>
                                                                    <div  class="col-md-10" >
                                                                        <div class="radio-list ">
                                                                            <label class="radio-inline">
                                                                                <input type="radio" name="coupon_scope" id="coupon_scope_1" value="all" />赠送积分
                                                                            </label>
                                                                            <label class="radio-inline">
                                                                                <input type="radio" name="coupon_scope" id="coupon_scope_2" value="category" />送优惠
                                                                            </label>
                                                                            <label class="radio-inline">
                                                                                <input type="radio" name="coupon_scope" id="coupon_scope_3" value="brand" />赠品
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">赠送积分<span class="required" >*</span></label>
                                                                    <div class="col-md-4">
                                                                        <input class="form-control" id="coupon_end_date" name="coupon_end_date" type="text" value="" />
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">送优惠<span class="required" >*</span></label>
                                                                    <div class="col-md-4">
                                                                        <input class="form-control" id="coupon_end_date" name="coupon_end_date" type="text" value="" />
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">赠品<span class="required" >*</span></label>
                                                                    <div class="col-md-4">
                                                                        <input class="form-control" id="coupon_end_date" name="coupon_end_date" type="text" value="" />
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">奖品数量<span class="required" >*</span></label>
                                                                    <div class="col-md-4">
                                                                        <input class="form-control" id="coupon_end_date" name="coupon_end_date" type="text" value="" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade in" id="tab_2">
                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">选择奖品<span class="required" >*</span></label>
                                                                    <div  class="col-md-10" >
                                                                        <div class="radio-list ">
                                                                            <label class="radio-inline">
                                                                                <input type="radio" name="coupon_scope" id="coupon_scope_1" value="all" />赠送积分
                                                                            </label>
                                                                            <label class="radio-inline">
                                                                                <input type="radio" name="coupon_scope" id="coupon_scope_2" value="category" />送优惠
                                                                            </label>
                                                                            <label class="radio-inline">
                                                                                <input type="radio" name="coupon_scope" id="coupon_scope_3" value="brand" />赠品
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">赠送积分<span class="required" >*</span></label>
                                                                    <div class="col-md-4">
                                                                        <input class="form-control" id="coupon_end_date" name="coupon_end_date" type="text" value="" />
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">送优惠<span class="required" >*</span></label>
                                                                    <div class="col-md-4">
                                                                        <input class="form-control" id="coupon_end_date" name="coupon_end_date" type="text" value="" />
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">赠品<span class="required" >*</span></label>
                                                                    <div class="col-md-4">
                                                                        <input class="form-control" id="coupon_end_date" name="coupon_end_date" type="text" value="" />
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">奖品数量<span class="required" >*</span></label>
                                                                    <div class="col-md-4">
                                                                        <input class="form-control" id="coupon_end_date" name="coupon_end_date" type="text" value="" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade in" id="tab_3">
                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">选择奖品<span class="required" >*</span></label>
                                                                    <div  class="col-md-10" >
                                                                        <div class="radio-list ">
                                                                            <label class="radio-inline">
                                                                                <input type="radio" name="coupon_scope" id="coupon_scope_1" value="all" />赠送积分
                                                                            </label>
                                                                            <label class="radio-inline">
                                                                                <input type="radio" name="coupon_scope" id="coupon_scope_2" value="category" />送优惠
                                                                            </label>
                                                                            <label class="radio-inline">
                                                                                <input type="radio" name="coupon_scope" id="coupon_scope_3" value="brand" />赠品
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">赠送积分<span class="required" >*</span></label>
                                                                    <div class="col-md-4">
                                                                        <input class="form-control" id="coupon_end_date" name="coupon_end_date" type="text" value="" />
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">送优惠<span class="required" >*</span></label>
                                                                    <div class="col-md-4">
                                                                        <input class="form-control" id="coupon_end_date" name="coupon_end_date" type="text" value="" />
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">赠品<span class="required" >*</span></label>
                                                                    <div class="col-md-4">
                                                                        <input class="form-control" id="coupon_end_date" name="coupon_end_date" type="text" value="" />
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">奖品数量<span class="required" >*</span></label>
                                                                    <div class="col-md-4">
                                                                        <input class="form-control" id="coupon_end_date" name="coupon_end_date" type="text" value="" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade in" id="tab_4">
                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">选择奖品<span class="required" >*</span></label>
                                                                    <div  class="col-md-10" >
                                                                        <div class="radio-list ">
                                                                            <label class="radio-inline">
                                                                                <input type="radio" name="coupon_scope" id="coupon_scope_1" value="all" />赠送积分
                                                                            </label>
                                                                            <label class="radio-inline">
                                                                                <input type="radio" name="coupon_scope" id="coupon_scope_2" value="category" />送优惠
                                                                            </label>
                                                                            <label class="radio-inline">
                                                                                <input type="radio" name="coupon_scope" id="coupon_scope_3" value="brand" />赠品
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">赠送积分<span class="required" >*</span></label>
                                                                    <div class="col-md-4">
                                                                        <input class="form-control" id="coupon_end_date" name="coupon_end_date" type="text" value="" />
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">送优惠<span class="required" >*</span></label>
                                                                    <div class="col-md-4">
                                                                        <input class="form-control" id="coupon_end_date" name="coupon_end_date" type="text" value="" />
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">赠品<span class="required" >*</span></label>
                                                                    <div class="col-md-4">
                                                                        <input class="form-control" id="coupon_end_date" name="coupon_end_date" type="text" value="" />
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">奖品数量<span class="required" >*</span></label>
                                                                    <div class="col-md-4">
                                                                        <input class="form-control" id="coupon_end_date" name="coupon_end_date" type="text" value="" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">未中奖说明<span class="required" ></span></label>
                                                <div class="col-md-8">
                                                    <textarea id="failed_desc" name="failed_desc" placeholder="" class="form-control"></textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <a href="javascript:;" class="btn default button-previous">
                                                <i class="fa fa-angle-left"></i> 上一步 </a>
                                            <a href="javascript:;" class="btn btn-outline green button-next"> 下一步
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                            <a href="javascript:;" class="btn green button-submit"> 提交
                                                <i class="fa fa-check"></i>
                                            </a>
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
    <script src="/assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>

    <script>
        $(function(){

            App.initUniform();

            $(".form_datetime").datetimepicker({
                isRTL: App.isRTL(),
                autoclose: true,
                todayBtn: true,
                format: "yyyy-mm-dd  hh:ii",
                pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left")
            });

            if (!jQuery().bootstrapWizard) {
                return;
            }

            var form = $('#submit_form');

            form.validate({
                doNotHideMessage: true,
                errorElement: 'span',
                errorClass: 'help-block help-block-error',
                focusInvalid: false,
                rules: {
                    //创建活动
                    award_name: {
                        required: true
                    },
                    start_time: {
                        required: true
                    },
                    end_time: {
                        required: true
                    },
                    //用户参与设置
                    cost_point: {
                        required: true
                    },
                    give_point: {
                        required: true,
                    },
                    time_limit: {
                        required: true
                    },
                    //中奖设置
                    probability: {
                        required: true
                    },
                },

                messages: {
                    'payment[]': {
                        required: "Please select at least one option",
                        minlength: jQuery.validator.format("Please select at least one option")
                    }
                },

                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                },

                invalidHandler: function (event, validator) {
                    //App.scrollTo(error, -200);
                },

                highlight: function (element) {
                    $(element)
                        .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) {
                    $(element)
                        .closest('.form-group').removeClass('has-error');
                },

                success: function (label) {
                    if (label.attr("for") == "gender" || label.attr("for") == "payment[]") {
                        label.closest('.form-group').removeClass('has-error').addClass('has-success');
                        label.remove();
                    } else {
                        label
                            .addClass('valid')
                            .closest('.form-group').removeClass('has-error').addClass('has-success');
                    }
                },

//                submitHandler: function (form) {
//                    //add here some ajax code to submit your form or just call form.submit() if you want to submit the form without ajax
//                }

            });

            var handleTitle = function(tab, navigation, index) {
                var total = navigation.find('li').length;
                var current = index + 1;
                // set done steps
                jQuery('li', $('#form_wizard_1')).removeClass("done");
                var li_list = navigation.find('li');
                for (var i = 0; i < index; i++) {
                    jQuery(li_list[i]).addClass("done");
                }

                if (current == 1) {
                    $('#form_wizard_1').find('.button-previous').hide();
                } else {
                    $('#form_wizard_1').find('.button-previous').show();
                }

                if (current >= total) {
                    $('#form_wizard_1').find('.button-next').hide();
                    $('#form_wizard_1').find('.button-submit').show();
                } else {
                    $('#form_wizard_1').find('.button-next').show();
                    $('#form_wizard_1').find('.button-submit').hide();
                }
                App.scrollTo($('.page-title'));
            }

            // default form wizard
            $('#form_wizard_1').bootstrapWizard({
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                onTabClick: function (tab, navigation, index, clickedIndex) {
                    return false;

                    if (form.valid() == false) {
                        return false;
                    }

                    handleTitle(tab, navigation, clickedIndex);
                },
                onNext: function (tab, navigation, index) {
                    if (form.valid() == false) {
                        return false;
                    }
                    handleTitle(tab, navigation, index);
                },
                onPrevious: function (tab, navigation, index) {
                    handleTitle(tab, navigation, index);
                },
                onTabShow: function (tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    var $percent = (current / total) * 100;
                    $('#form_wizard_1').find('.progress-bar').css({
                        width: $percent + '%'
                    });
                }
            });

            var options = {
                dataType:  'json',
                success: function(responseText){
                    if(responseText){
                        if(responseText.code == 1) {
                            WX.toastr({'type':'success','message':'新增成功！', 'onHidden':function(){
                                location.href = "/admin/award/cards";
                            }});
                        }else{
                            WX.toastr({'type':'error','message': '新增失败'});
                        }
                    }
                }
            };
            $('#submit_form').ajaxForm(options);

            $('#form_wizard_1').find('.button-previous').hide();
            $('#form_wizard_1 .button-submit').click(function () {
                $("#submit_form").attr('action','/admin/award/save');
                $("#submit_form").submit();
            }).hide();

        });
    </script>

@endsection
