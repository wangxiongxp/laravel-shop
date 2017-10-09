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
                    <a href="#">促销活动</a>
                </li>
            </ul>
        </div>

        <div class="row" style="margin-top:20px;margin-left:0;margin-right:0">
            <div class="col-md-12">

                <div class="portlet light bordered">

                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <span class="caption-subject bold uppercase"> 编辑促销活动</span>
                        </div>
                    </div>

                    <div class="portlet-body form">
                        <form role="form" class="form-horizontal" method="post" id="AddForm" action="">
                            <div class="form-body" style="padding-top:30px;">

                                <div class="form-group">
                                    <label class="col-md-2 control-label">活动名称<span class="required" >*</span></label>
                                    <div class="col-md-4">
                                        <input type="hidden" id="prom_id" name="prom_id" value="{{$item->prom_id}}" placeholder="" class="form-control">
                                        <input type="text" id="prom_name" name="prom_name" value="{{$item->prom_name}}" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">开始时间<span class="required" >*</span></label>
                                    <div class="col-md-4">
                                        <input class="form-control date-picker" id="start_time" name="start_time" value="{{$item->start_time}}" type="text" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">结束时间<span class="required" >*</span></label>
                                    <div class="col-md-4">
                                        <input class="form-control date-picker" id="end_time" name="end_time" value="{{$item->end_time}}" type="text" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">参与范围<span class="required" >*</span></label>
                                    <div  class="col-md-10" >
                                        <div class="radio-list ">
                                            <label class="radio-inline">
                                                <input type="radio" disabled="disabled" name="prom_scope" value="all" />A类券（所有商品）
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" disabled="disabled" name="prom_scope" value="category" />C类券（分类优惠）
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" disabled="disabled" name="prom_scope" value="brand" />B类券（品牌优惠）
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" disabled="disabled" name="prom_scope" value="goods" />S类券（指定商品）
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                @if($item->prom_scope == 'category')
                                    <div class="form-group" >
                                        <label class="col-md-2 control-label">参与分类<span class="required" ></span></label>
                                        <div class="col-md-10">
                                            <select disabled class="form-control input-medium">
                                                <option value="{{ $category->cat_id }}">{{ $category->cat_title }}</option>
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                @if($item->prom_scope == 'brand')
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
                                    <label class="col-md-2 control-label">活动规则<span class="required" >*</span></label>
                                    <div class="col-md-8">
                                        <table class="table table-bordered" >
                                            <tr role="row" >
                                                <td style="border-bottom: none">
                                                    <div class="radio-list">
                                                        <label >
                                                            <input disabled="disabled" name="buy_cond" value="1" type="radio"> 满
                                                            <input disabled="disabled" type="text" id="min_price" name="min_price" class="form-control input-inline input-small"> 元
                                                        </label>
                                                    </div>
                                                </td>
                                                <td style="border-bottom: none">
                                                    <div class="radio-list">
                                                        <label >
                                                            <input disabled="disabled" name="prom_type" value="1" type="radio"> 减金额
                                                            <input disabled="disabled" type="text" id="minus" name="minus" class="form-control input-inline input-small"> 元
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr role="row" >
                                                <td style="border-top: none;border-bottom: none">
                                                    <div class="radio-list">
                                                        <label >
                                                            <input disabled="disabled" name="buy_cond" value="2" type="radio"> 满
                                                            <input disabled="disabled" type="text" id="min_num" name="min_num" class="form-control input-inline input-small"> 件
                                                        </label>
                                                    </div>
                                                </td>
                                                <td style="border-top: none;border-bottom: none">
                                                    <div class="radio-list">
                                                        <label >
                                                            <input disabled="disabled" name="prom_type" value="2" type="radio"> 打折
                                                            <input disabled="disabled" type="text" id="discount" name="discount" class="form-control input-inline input-small"> 折
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr role="row" >
                                                <td style="border-top: none">
                                                    <div class="radio-list">
                                                        <label >
                                                            <input disabled="disabled" name="buy_cond" value="3" type="radio"> 无需条件
                                                        </label>
                                                    </div>
                                                </td>
                                                <td style="border-top: none">
                                                    <div class="radio-list">
                                                        <label >
                                                            <input disabled="disabled" name="prom_type" value="3" type="radio"> 包邮
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">活动备注<span class="required" ></span></label>
                                    <div class="col-md-6">
                                        <textarea id="prom_desc" name="prom_desc" placeholder="" class="form-control">{{$item->prom_desc}}</textarea>
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

            //设置优惠券类型
            SetRadioSelected('prom_type','{{$item->prom_type}}');
            //设置优惠券使用门槛
            SetRadioSelected('buy_cond','{{$rule->buy_cond}}');
            //设置优惠券范围
            SetRadioSelected('prom_scope','{{$item->prom_scope}}');
            App.updateUniform();

            if('{{$item->prom_type}}'==1){
                $("#minus").val('{{$rule->minus}}');
            }else if('{{$item->prom_type}}'==2){
                $("#discount").val('{{$rule->discount}}');
            }

            if('{{$rule->buy_cond}}'==1){
                $("#min_price").val('{{$rule->min_price}}');
            }else if('{{$rule->buy_cond}}'==2){
                $("#min_num").val('{{$rule->min_num}}');
            }

            var setting = {
                rules: {
                    prom_name: {
                        required: true
                    },
                    start_time: {
                        required: true
                    },
                    end_time: {
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
                    WX.toastr({'type':'success','message':'保存成功.','onHidden':function(){
                        location.href = "/admin/promotion";
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

            $("#AddForm").attr('action','/admin/promotion/update');
            $("#AddForm").submit();
        }

        function Function_Back(){
            location.href = '/admin/promotion';
        }

    </script>

@endsection


