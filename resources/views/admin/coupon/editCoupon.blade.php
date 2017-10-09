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
                    <a href="#">优惠券设置</a>
                </li>
            </ul>
        </div>

        <div class="row" style="margin-top:20px;margin-left:0;margin-right:0">
            <div class="col-md-12">

                <div class="portlet light bordered">

                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <span class="caption-subject bold uppercase"> 编辑优惠券</span>
                        </div>
                    </div>

                    <div class="portlet-body form">
                        <form role="form" class="form-horizontal" method="post" id="AddForm" action="">
                            <div class="form-body" style="padding-top:30px;">

                                <div class="form-group">
                                    <label class="col-md-2 control-label">优惠券名称<span class="required" >*</span></label>
                                    <div class="col-md-4">
                                        <input type="hidden" id="coupon_id" name="coupon_id" value="{{$item->coupon_id}}" placeholder="" class="form-control">
                                        <input type="text" id="coupon_name" name="coupon_name" value="{{$item->coupon_name}}" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">开始时间<span class="required" >*</span></label>
                                    <div class="col-md-4">
                                        <input class="form-control date-picker" id="coupon_start_date" name="coupon_start_date" value="{{$item->coupon_start_date}}" type="text" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">结束时间<span class="required" >*</span></label>
                                    <div class="col-md-4">
                                        <input class="form-control date-picker" id="coupon_end_date" name="coupon_end_date" value="{{$item->coupon_end_date}}" type="text" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">参与范围<span class="required" >*</span></label>
                                    <div  class="col-md-10" >
                                        <div class="radio-list ">
                                            <label class="radio-inline">
                                                <input type="radio" disabled="disabled" name="coupon_scope" value="all" />A类券（所有商品）
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" disabled="disabled" name="coupon_scope" value="category" />C类券（分类优惠）
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" disabled="disabled" name="coupon_scope" value="brand" />B类券（品牌优惠）
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" disabled="disabled" name="coupon_scope" value="goods" />S类券（指定商品）
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                @if($item->coupon_scope == 'category')
                                    <div class="form-group" >
                                        <label class="col-md-2 control-label">参与分类<span class="required" ></span></label>
                                        <div class="col-md-10">
                                            <select disabled class="form-control input-medium">
                                                <option value="{{ $category->cat_id }}">{{ $category->cat_title }}</option>
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                @if($item->coupon_scope == 'brand')
                                    <div class="form-group" >
                                        <label class="col-md-2 control-label">参与品牌<span class="required" ></span></label>
                                        <div class="col-md-10">
                                            <select disabled class="form-control input-medium">
                                                <option value="{{ $brand->brand_id }}">{{ $brand->brand_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label class="col-md-2 control-label">是否可叠加<span class="required" >*</span></label>
                                    <div class="col-md-10">
                                        <div class="checkbox-list">
                                            <label class="checkbox-inline" >
                                                <input type="checkbox" name="coupon_is_spec" id="coupon_is_spec" value="1" > 优惠券是否可以叠加使用 </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">发放总量<span class="required" >*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" id="coupon_send_num" name="coupon_send_num" value="{{$item->coupon_send_num}}" placeholder="" class="form-control input-inline input-small">
                                        <span class="help-inline">张 优惠券的发放总量，超出后将无法发送，0表示不限</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">限领数量<span class="required" >*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" id="coupon_receive_num" name="coupon_receive_num" value="{{$item->coupon_receive_num}}" placeholder="" class="form-control input-inline input-small">
                                        <span class="help-inline">张  限制单个用户可以领取多少张该类用户券，默认为1</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">优惠形式<span class="required" >*</span></label>
                                    <div class="col-md-10">
                                        <div class="radio-list">
                                            <label>
                                                <input disabled="disabled" name="coupon_type" value="1" type="radio">
                                                指定金额
                                                @if($item->coupon_type==1)
                                                <input disabled="disabled" type="text" id="coupon_face_value" name="coupon_face_value" value="{{$item->coupon_face_value}}" class="form-control input-inline input-small">
                                                    @if($item->coupon_face_value_random == 1)
                                                    至 <input disabled="disabled" type="text" id="coupon_face_value_to" name="coupon_face_value_to" value="{{$item->coupon_face_value_to}}" class="form-control input-inline input-small"> 元
                                                    @endif
                                                    <input disabled="disabled" type="checkbox" name="coupon_face_value_random" id="coupon_face_value_random" value="1" >随机
                                                @endif
                                            </label>
                                            <label>
                                                <input disabled="disabled" name="coupon_type" value="2" type="radio">
                                                折扣
                                                @if($item->coupon_type==2)
                                                <div style="display: inline-block">
                                                    <input disabled="disabled" type="text" id="coupon_discount" name="coupon_discount" value="{{$rule->discount}}" class="form-control input-inline input-small">折
                                                </div>
                                                @endif
                                            </label>
                                            <label>
                                                <input disabled="disabled" name="coupon_type" value="3" type="radio">
                                                包邮
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">使用门槛<span class="required" >*</span></label>
                                    <div class="col-md-10">
                                        <div class="radio-list">
                                            <label>
                                                <input disabled="disabled" name="buy_cond" value="1" type="radio">
                                                满 <input disabled="disabled" type="text" id="min_price" name="min_price" value="{{$rule->min_price}}" class="form-control input-inline input-small"> 元可使用
                                            </label>
                                            <label>
                                                <input disabled="disabled" name="buy_cond" value="2" type="radio">
                                                不限制
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">优惠券最高抵扣<span class="required" >*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" id="coupon_max_value" name="coupon_max_value" value="{{$item->coupon_max_value}}" class="form-control input-inline input-small"> 元
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">优惠券备注<span class="required" ></span></label>
                                    <div class="col-md-6">
                                        <textarea id="coupon_desc" name="coupon_desc" placeholder="" class="form-control">{{$item->coupon_desc}}</textarea>
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

        $(document).ready(function(){

            $('#coupon_start_date').datepicker({
                rtl: App.isRTL(),
                format: 'yyyy-mm-dd',
                language: "zh-CN",
                autoclose: true,
                clearBtn:true,
            }).on('changeDate', function(ev){
                if(ev.date){
                    $('#coupon_end_date').datepicker('setStartDate', new Date(ev.date.valueOf()))
                }else{
                    $('#coupon_end_date').datepicker('setStartDate',null);
                }
            });

            $('#coupon_end_date').datepicker({
                rtl: App.isRTL(),
                format: 'yyyy-mm-dd',
                language: "zh-CN",
                autoclose: true,
                clearBtn:true,
            }).on('changeDate', function(ev){
                if(ev.date){
                    $('#coupon_start_date').datepicker('setEndDate', new Date(ev.date.valueOf()))
                }else{
                    $('#coupon_start_date').datepicker('setEndDate',new Date());
                }
            });

            //设置是否可叠加
            SetChecked('coupon_is_spec','{{$item->coupon_is_spec}}');
            //设置是否金额随机
            SetChecked('coupon_face_value_random','{{$item->coupon_face_value_random}}');
            //设置优惠券类型
            SetRadioSelected('coupon_type','{{$item->coupon_type}}');
            //设置优惠券使用门槛
            SetRadioSelected('buy_cond','{{$rule->buy_cond}}');
            //设置优惠券范围
            SetRadioSelected('coupon_scope','{{$item->coupon_scope}}');
            App.updateUniform();

            var setting = {
                rules: {
                    coupon_name: {
                        required: true
                    },
                    coupon_start_date: {
                        required: true
                    },
                    coupon_end_date: {
                        required: true
                    },
                    coupon_send_num: {
                        required: true,
                        number: true
                    },
                    coupon_receive_num: {
                        required: true,
                        number: true
                    },
                    coupon_max_value: {
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
                        location.href = "/admin/coupon";
                    }});
                }else{
                    WX.toastr({'type':'error','message':'保存失败!'});
                }
            }
        }

        function Function_Save(){

            var category_id_1 = $("#category_id_1").val();
            var category_id_2 = $("#category_id_2").val();

            if(category_id_2 != ''){
                $("#category_id").val(category_id_2);
            }else{
                $("#category_id").val(category_id_1);
            }

            $("#AddForm").attr('action','/admin/coupon/update');
            $("#AddForm").submit();
        }

        function Function_Back(){
            location.href = '/admin/coupon';
        }

    </script>

@endsection


