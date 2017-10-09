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
                    <a href="#">限时特价</a>
                </li>
            </ul>
        </div>

        <div class="row" style="margin-top:20px;margin-left:0;margin-right:0">
            <div class="col-md-12">

                <div class="portlet light bordered">

                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <span class="caption-subject bold uppercase"> 新增限时特价</span>
                        </div>
                    </div>

                    <div class="portlet-body form">
                        <form role="form" class="form-horizontal" method="post" id="AddForm" action="">
                            <div class="form-body" style="padding-top:30px;">

                                <div class="form-group">
                                    <label class="col-md-2 control-label">活动名称<span class="required" >*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" id="name" name="name" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">活动标签<span class="required" >*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" id="label" name="label" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">开始时间<span class="required" >*</span></label>
                                    <div class="col-md-4">
                                        <input class="form-control date-picker" id="start_time" name="start_time" type="text" value="" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">结束时间<span class="required" >*</span></label>
                                    <div class="col-md-4">
                                        <input class="form-control date-picker" id="end_time" name="end_time" type="text" value="" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">限时特价<span class="required" >*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" id="discount" name="discount" placeholder="" class="form-control input-inline input-small">
                                        <span class="help-inline">折 注意: 如8.8折, 折后价 = 实际价格 * 0.88</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">参与范围<span class="required" >*</span></label>
                                    <div  class="col-md-10" >
                                        <div class="radio-list ">
                                            <label class="radio-inline">
                                                <input type="radio" name="scope" id="scope_1" value="is_category" />分类
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="scope" id="scope_2" value="is_brand" />品牌
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="scope" id="scope_3" value="is_goods" />指定商品
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
                                        <span class="help-inline"></span>
                                    </div>
                                    <label class="col-md-2 control-label"></label>
                                    <div class="col-md-10">
                                        <p class="form-control-static">一次性将目前商品列入到特价活动，添加成功后新增加的该分类的商品将不会参与活动，需要手动设置</p>
                                    </div>
                                </div>

                                <div class="form-group" id="is_brand" style="display: none">
                                    <label class="col-md-2 control-label">参与品牌<span class="required" ></span></label>
                                    <div class="col-md-10">
                                        <select id="brand_id" name="brand_id" class="form-control input-medium">
                                            <option value="">请选择品牌</option>
                                        </select>
                                        <span class="help-inline">一次性将目前商品列入到特价活动，添加成功后新增加的该品牌的商品将不会参与活动，需要手动设置</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">活动图片<span class="required" ></span></label>
                                    <div class="col-md-8">
                                        <input type="hidden" id="image" name="image" >
                                        <a class="btn btn-default" id="select_image">选择图片</a>
                                        <img src="" style="display: none;width:32px;"/>
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

            SetRadioSelected('scope','is_goods');
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

            $("input[name='scope']").change(function(){
                if($(this).val()=='is_category'){
                    $("#is_brand").hide();
                    $("#is_category").show();
                }else if($(this).val()=='is_brand'){
                    $("#is_brand").show();
                    $("#is_category").hide();
                }else{
                    $("#is_brand").hide();
                    $("#is_category").hide();
                }
            });

            var setting = {
                rules: {
                    name: {
                        required: true
                    },
                    label: {
                        required: true
                    },
                    start_time: {
                        required: true
                    },
                    end_time: {
                        required: true
                    },
                    discount: {
                        required: true
                    },
                    status: {
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
                        location.href = "/admin/special";
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

            $("#AddForm").attr('action','/admin/special/save');
            $("#AddForm").submit();
        }

        function Function_Back(){
            location.href = '/admin/special';
        }

    </script>
    <script>
        var uploader;

        var settings = {
            browse_button : 'select_image',
            url : '/admin/uploadImage',
            flash_swf_url : 'js/Moxie.swf',
            silverlight_xap_url : 'js/Moxie.xap',
            filters: {
                mime_types : [
                    { title : "Image files", extensions : "jpg,gif,png,jpeg" },
                ],
                max_file_size : '20mb',
                prevent_duplicates : false,
            },
            multipart_params: {
                '_token':'{{ csrf_token() }}'
            },
            /*resize: {//可以使用该参数对将要上传的图片进行压缩，
             width: 400,
             height: 130,
             crop: true,
             quality: 90,
             preserve_headers: false
             },*/
            multi_selection:false,
            unique_names:true,
            runtimes:'html5,flash,silverlight,html4',
            file_data_name:'file',
        };
        uploader = new plupload.Uploader(settings);
        uploader.init();
        uploader.bind('FilesAdded',function(uploader,files){
            uploader.start();
        });
        uploader.bind('UploadProgress',function(uploader,file){
            //上传进度
        });
        uploader.bind('FileUploaded',function(uploader,file,responseObject){
            var response = eval('('+responseObject.response+')');
            $("#select_image").next('img').attr('src', response.path).show() ;
            $("#image").val(response.path);
        });
        uploader.bind('UploadComplete',function(uploader,files){
            //console.log(files);
        });
        uploader.bind('Error',function(uploader,errObject){
            console.log(errObject);
            WX.toastr({'type':'error','timeOut':3000,'message':errObject.message});
        });

    </script>

@endsection


