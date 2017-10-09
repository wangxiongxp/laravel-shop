@extends('admin.layouts.default')

@section('head_css')

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
                    <a href="#">运费模板</a>
                </li>
            </ul>
        </div>

        <div class="row" style="margin-top:20px;margin-left:0;margin-right:0">
            <div class="col-md-12">
                <div class="portlet light bordered">

                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <span class="caption-subject bold uppercase"> 新增运费模板</span>
                        </div>
                    </div>

                    <div class="portlet-body form">

                        <form id="AddForm" method="post" role="form" class="form-horizontal">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">模板名称<span class="required" >*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" id="shipping_name" name="shipping_name" placeholder="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">发货时间<span class="required" ></span></label>
                                    <div class="col-md-4">
                                        <select id="delivery_time" name="delivery_time" class="form-control">
                                            <option value="">==请选择==</option>
                                            <option value="1">1天内</option>
                                            <option value="2">2天内</option>
                                            <option value="3">3天内</option>
                                            <option value="5">5天内</option>
                                            <option value="7">7天内</option>
                                            <option value="15">15天内</option>
                                            <option value="30">30天内</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">是否包邮<span class="required" >*</span></label>
                                    <div  class="col-md-10" >
                                        <div class="radio-list ">
                                            <label class="radio-inline">
                                                <input type="radio" name="is_free" id="is_free_1" value="1" checked="checked" />卖家承担运费
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="is_free" id="is_free_2" value="0" />自定义运费
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">配送物流<span class="required" >*</span></label>
                                    <div class="col-md-4">
                                        <select id="company_id" name="company_id" class="form-control">
                                            <option value="">==请选择==</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group valuation" style="display: none;">
                                    <label class="col-md-2 control-label">计价方式<span class="required" >*</span></label>
                                    <div  class="col-md-10" >
                                        <div class="radio-list ">
                                            <label class="radio-inline">
                                                <input type="radio" name="valuation" id="valuation_1" value="1" checked="checked" />按件数
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="valuation" id="valuation_2" value="2" />按重量
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group valuation" style="display: none;">
                                    <label class="col-md-2 control-label"></label>
                                    <div class="col-md-6">
                                        <table class="table table-bordered" id="valuation_pcs">
                                            <tr role="row" class="heading">
                                                <th width="25%"> 首件数(件) </th>
                                                <th width="25%"> 首费(元) </th>
                                                <th width="25%"> 续件数(件) </th>
                                                <th width="25%"> 续费(元) </th>
                                            </tr>
                                            <tr role="row" >
                                                <td >
                                                    <input class="form-control input-sm" name="first_pcs" type="text">
                                                </td>
                                                <td >
                                                    <input class="form-control input-sm" name="first_pcs_price" type="text">
                                                </td>
                                                <td >
                                                    <input class="form-control input-sm" name="last_pcs" type="text">
                                                </td>
                                                <td >
                                                    <input class="form-control input-sm" name="last_pcs_price" type="text">
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="table table-bordered" style="display: none;" id="valuation_weight">
                                            <tr role="row" class="heading">
                                                <th width="25%"> 首重量(kg) </th>
                                                <th width="25%"> 首费(元) </th>
                                                <th width="25%"> 续重量(kg) </th>
                                                <th width="25%"> 续费(元) </th>
                                            </tr>
                                            <tr role="row" >
                                                <td >
                                                    <input class="form-control input-sm" name="first_weight" type="text">
                                                </td>
                                                <td >
                                                    <input class="form-control input-sm" name="first_weight_price" type="text">
                                                </td>
                                                <td >
                                                    <input class="form-control input-sm" name="last_weight" type="text">
                                                </td>
                                                <td >
                                                    <input class="form-control input-sm" name="last_weight_price" type="text">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">描述<span class="required" >&nbsp;</span></label>
                                    <div class="col-md-6">
                                        <textarea id="shipping_desc" name="shipping_desc" placeholder="" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">排序<span class="required" >*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" id="shipping_sort" name="shipping_sort" placeholder="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-2 col-md-10">
                                            <button class="btn green" type="button" onclick="Function_SaveForm()">保存</button>
                                            <button class="btn default" type="button" onclick="Function_Back()">返回</button>
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

    <script>

        $(document).ready(function(){

            ajaxSelectSimple('/admin/shippingCompany/getShippingCompany','company_id','company_id','company_name');

            $("input[name='is_free']").change(function(){
                if($(this).val()==1){
                    $(".valuation").hide();
                }else{
                    $(".valuation").show();
                }
            });

            $("input[name='valuation']").change(function(){
                if($(this).val()==1){
                    $("#valuation_weight").hide();
                    $("#valuation_pcs").show();
                }else{
                    $("#valuation_pcs").hide();
                    $("#valuation_weight").show();
                }
            });

            var setting = {
                rules: {
                    shipping_name: {
                        required: true
                    },
                    is_free: {
                        required: true
                    },
                    company_id: {
                        required: true
                    },
                    shipping_sort: {
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
            var data = responseText;
            if(data){
                if(data.code == 1)
                {
                    WX.toastr({'type':'success','message':'保存成功.','onHidden':function(){
                        location.href = "/admin/shipping";
                    }});
                }else{
                    WX.toastr({'type':'error','message':'保存失败!'});
                }
            }
        }

        function Function_SaveForm(){
            $("#AddForm").attr('action','/admin/shipping/save');
            $("#AddForm").submit();
        }

        function Function_Back(){
            location.href = "/admin/shipping";
        }

    </script>
@endsection
