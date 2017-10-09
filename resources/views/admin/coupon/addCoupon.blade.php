@extends('admin.layouts.default')

@section('head_css')
    <link href="/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="page-content" id="app">
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
                            <span class="caption-subject bold uppercase"> 新增优惠券</span>
                        </div>
                    </div>

                    <div class="portlet-body form">
                        <form role="form" class="form-horizontal" method="post" id="AddForm" action="">
                            <div class="form-body" style="padding-top:30px;">

                                <div class="form-group">
                                    <label class="col-md-2 control-label">优惠券名称<span class="required" >*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" id="coupon_name" name="coupon_name" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">开始时间<span class="required" >*</span></label>
                                    <div class="col-md-4">
                                        <input class="form-control date-picker" id="coupon_start_date" name="coupon_start_date" type="text" value="" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">结束时间<span class="required" >*</span></label>
                                    <div class="col-md-4">
                                        <input class="form-control date-picker" id="coupon_end_date" name="coupon_end_date" type="text" value="" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">参与范围<span class="required" >*</span></label>
                                    <div  class="col-md-10" >
                                        <div class="radio-list ">
                                            <label class="radio-inline">
                                                <input type="radio" name="coupon_scope" id="coupon_scope_1" value="all" />A类券（所有商品）
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="coupon_scope" id="coupon_scope_2" value="category" />C类券（分类优惠）
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="coupon_scope" id="coupon_scope_3" value="brand" />B类券（品牌优惠）
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="coupon_scope" id="coupon_scope_4" value="goods" />S类券（指定商品）
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" id="is_category" style="display: none">
                                    <label class="col-md-2 control-label">参与分类<span class="required" ></span></label>
                                    <div class="col-md-10">
                                        <input type="hidden" name="category_id" id="category_id" value="" />
                                        <select id="category_id_1" class="form-control input-inline input-small">
                                            <option value="">请选择分类</option>
                                        </select>
                                        <select style="display: none" id="category_id_2" class="form-control input-inline input-small">
                                            <option value="">请选择分类</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group" id="is_brand" style="display: none">
                                    <label class="col-md-2 control-label">参与品牌<span class="required" ></span></label>
                                    <div class="col-md-10">
                                        <select id="brand_id" name="brand_id" class="form-control input-medium">
                                            <option value="">请选择品牌</option>
                                        </select>
                                    </div>
                                </div>

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
                                        <input type="text" id="coupon_send_num" name="coupon_send_num" placeholder="" class="form-control input-inline input-small">
                                        <span class="help-inline">张 优惠券的发放总量，超出后将无法发送，0表示不限</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">限领数量<span class="required" >*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" id="coupon_receive_num" name="coupon_receive_num" placeholder="" class="form-control input-inline input-small">
                                        <span class="help-inline">张  限制单个用户可以领取多少张该类用户券，默认为1</span>
                                    </div>
                                </div>

                                <coupon-rule :rule="rule"></coupon-rule>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">优惠券最高抵扣<span class="required" >*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" id="coupon_max_value" name="coupon_max_value" class="form-control input-inline input-small"> 元
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">优惠券备注<span class="required" ></span></label>
                                    <div class="col-md-6">
                                        <textarea id="coupon_desc" name="coupon_desc" placeholder="" class="form-control"></textarea>
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

    <script src="/assets/front/js/vue.min.js"></script>

    <script type="text/x-template" id="coupon_rule">
        <div>
            <div class="form-group">
                <label class="col-md-2 control-label">优惠形式<span class="required" >*</span></label>
                <div class="col-md-8">
                    <div class="radio-list">
                        <label>
                            <input name="coupon_type" value="1" type="radio">
                            指定金额
                            <div id="face_value_show" style="display: inline-block;">
                                <input type="text" id="coupon_face_value" name="coupon_face_value" class="form-control input-inline input-small">
                                <div id="face_value_to_show" style="display: none;">
                                    至 <input type="text" id="coupon_face_value_to" name="coupon_face_value_to" class="form-control input-inline input-small"> 元
                                </div>
                                <input name="coupon_face_value_random" id="coupon_face_value_random" value="1" type="checkbox">随机
                            </div>
                        </label>
                        <label>
                            <input name="coupon_type" value="2" type="radio">
                            折扣
                            <div id="discount_show" style="display:none">
                                <input type="text" id="coupon_discount" name="coupon_discount" class="form-control input-inline input-small">折
                            </div>
                        </label>
                        <label>
                            <input name="coupon_type" value="3" type="radio">
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
                            <input name="buy_cond" value="1" checked="checked" type="radio">
                            满 <input type="text" id="min_price" name="min_price" class="form-control input-inline input-small"> 元可使用
                        </label>
                        <label>
                            <input name="buy_cond" value="2" type="radio">
                            不限制
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script>

        //全局组件
        Vue.component('coupon-rule', {
            template: '#coupon_rule',
            props: ['rule'],
        })

        var vm = new Vue({
            //局部组件
            components: {
            },
            el: "#app",
            data:function(){
                return {
                    rule:[],
                }
            },
            created: function () {
                console.log('created start...')
            },
            mounted: function () {
                console.log('mounted start...')

            },
            updated: function () {
                console.log('updated start...')
            },
            computed: {

            },
            methods:{

            },
            watch: {

            }
        });

    </script>

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

            SetRadioSelected('coupon_scope','all');
            SetRadioSelected('coupon_type','1');
            SetChecked('coupon_is_spec','0');
            App.initUniform();

            ajaxSelectSimple('/admin/brand/getAllBrand','brand_id','brand_id','brand_name');
            ajaxSelectSimple('/admin/productCat/getCatalogByParent/0','category_id_1','cat_id','cat_title');

            $("#category_id_1").change(function(){
                $("#category_id").val('');

                $("#category_id_2").val('');
                $("#category_id_2 option:gt(0)").remove();

                var category_id_1 = $(this).val();
                if(category_id_1 != ''){
                    ajaxSelectSimple('/admin/productCat/getCatalogByParent/'+category_id_1 ,'category_id_2','cat_id','cat_title','');
                    if($("#category_id_2 option").size()>1){
                        $("#category_id_2").show();
                    }else{
                        $("#category_id_2").hide();
                    }
                }else{
                    $("#category_id_2").hide();
                }
            });

            $("input[name='coupon_scope']").change(function(){
                if($(this).val()=='category'){
                    $("#is_brand").hide();
                    $("#is_category").show();
                }else if($(this).val()=='brand'){
                    $("#is_brand").show();
                    $("#is_category").hide();
                }else{
                    $("#is_brand").hide();
                    $("#is_category").hide();
                }
            });

            $("input[name='coupon_type']").change(function(){
                if($(this).val()=='1'){
                    $("#discount_show").hide();
                    $("#face_value_show").css('display','inline-block');
                }else if($(this).val()=='2'){
                    $("#discount_show").css('display','inline-block');
                    $("#face_value_show").hide();
                }else if($(this).val()=='3'){
                    $("#discount_show").hide();
                    $("#face_value_show").hide();
                }
            });

            $("#coupon_face_value_random").change(function(){
                if($(this).is(":checked")){
                    $("#face_value_to_show").css('display','inline-block');
                }else{
                    $("#face_value_to_show").hide();
                }
            });

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

            var coupon_scope = $("input[name='coupon_scope']:checked").val();
            if(coupon_scope=='category'){
                $("#brand_id").val('0');
            }else if(coupon_scope=='brand'){
                $("#category_id").val('0');
            }

            $("#AddForm").attr('action','/admin/coupon/save');
            $("#AddForm").submit();
        }

        function Function_Back(){
            location.href = '/admin/coupon';
        }

    </script>

@endsection


