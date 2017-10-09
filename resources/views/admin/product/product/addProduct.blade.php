@extends('admin.layouts.default')

@section('head_css')
    <style>
        .image-item{
            float:left;margin-left:5px;position: relative;
        }
        .image-item a{
            display:block;height:142px;width:142px;border:1px solid #ddd
        }
        .image-item img{
            height:140px;width:140px
        }
        .image-item .process{
            display: block; position: absolute; bottom: 0; height:10px;background-color: #27A264;right:0
        }
    </style>
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
                <a href="#">产品管理</a>
            </li>
        </ul>
    </div>

    <div class="row" style="margin-top:20px;margin-left:0;margin-right:0">
        <div class="col-md-12">

            <div class="portlet light bordered">

                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase"> 新增产品</span>
                    </div>
                </div>

                <div class="portlet-body form">

                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_general" data-toggle="tab">
                                基本信息 </a>
                        </li>
                        <li>
                            <a href="#tab_description" data-toggle="tab">
                                商品描述 </a>
                        </li>
                        <li>
                            <a href="#tab_images" data-toggle="tab">
                                商品图片 </a>
                        </li>
                    </ul>

                    <form role="form" class="form-horizontal" method="post" id="EditForm" action="/admin/product/save">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_general">
                            <div class="form-body" style="padding-top:30px;">
                                <div class="form-group">
                                    <input type="hidden" id="product_cat_id" name="product_cat_id" value="{{$category->cat_id}}" >
                                    <label class="col-md-2 control-label">所属分类<span class="required" >*</span></label>
                                    <div class="col-md-4">
                                        <p class="form-control-static">{{ $category->cat_title }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">产品标题<span class="required" >*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" id="product_title" name="product_title" value="" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">副标题<span class="required" ></span></label>
                                    <div class="col-md-10">
                                        <input type="text" id="product_sub_title" name="product_sub_title" value="" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">产品价格<span class="required" ></span></label>
                                    <div class="col-md-10">
                                        <input type="text" id="product_price" name="product_price" value="" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">库存<span class="required" ></span></label>
                                    <div class="col-md-10">
                                        <input type="text" id="product_qty" name="product_qty" value="" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div style="display:none;">
                                    <textarea name="attr_data" id="attr_data"></textarea>
                                </div>

                                <attr-list v-for="attr in attrs" :attr="attr"></attr-list>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">上架状态<span class="required" >*</span></label>
                                    <div  class="col-md-10" >
                                        <div class="radio-list ">
                                            <label class="radio-inline">
                                                <input type="radio" name="product_status" value="1" checked="checked" />上架
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="product_status" value="0" />下架
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_description">
                            <div class="form-body">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <textarea class="form-control" id="product_desc" name="product_desc"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_images">
                            <div class="row" style="padding:30px;margin-bottom:60px">
                                <div style="margin-top:-15px;margin-bottom:15px;">
                                    * 至少上传一张图片，点击图片进行上传
                                </div>
                                <div class="image-list" id="filelist">
                                    <div class="image-item" >
                                        <a id="pickfiles" >
                                            <img src="/assets/global/img/nocover.gif"/>
                                        </a>
                                    </div>
                                </div>
                                <div style="padding-top: 10px;padding-left:10px;clear: both">
                                    <a class="btn btn-default" id="uploadfiles">点击上传</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>

                <div class="form-actions" style="padding-top:20px;border-top:1px solid #ddd">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-10">
                            <button class="btn green" type="button" onclick="Function_Save()">保存</button>
                            <button class="btn default" type="button" onclick="Function_Back()">返回</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('foot_script')
    <script type="text/javascript" src="/assets/global/plugins/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/plupload/js/plupload.full.min.js"></script>

    <script src="/assets/front/js/vue.min.js"></script>

    <script type="text/x-template" id="attr_list">
        <div class="form-group prop_item" :dataVal="attr.attr_id" :dataName="attr.attr_name" :dataType="attr.attr_type">
            <label class="col-md-2 control-label">@{{attr.attr_name}}<span class="required" ></span></label>
            <div class="col-md-10">
                <div v-if="attr.attr_type == 'UT_INPUT'">
                    <input type="text" id="product_qty" name="product_qty" value="" class="form-control">
                </div>
                <div v-else-if="attr.attr_type == 'UT_SELECT'">
                    <select class="form-control" id="parent_id" name="parent_id">
                        <option :value='option.option_id' v-for="option in attr.options">@{{option.option_name}}</option>
                    </select>
                </div>
                <div v-else-if="attr.attr_type == 'UT_CHECKBOX'">
                    <div class="checkbox-list">
                        <label class="checkbox-inline" v-for="option in attr.options">
                            <input type="checkbox" id="inlineCheckbox1" :value="option.option_id" :dataName="option.option_name"> @{{option.option_name}} </label>
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script>

        //全局组件
        Vue.component('attr-list', {
            template: '#attr_list',
            props: ['attr'],
        })

        var vm = new Vue({
            //局部组件
            components: {
            },
            el: "#app",
            data:function(){
                return {
                    attrs:[],
                }
            },
            created: function () {
                console.log('created start...')
            },
            mounted: function () {
                console.log('mounted start...')
                var _this=this;
                $.ajax({
                    type: 'GET',
                    url:"/admin/productCatAttr/getProductCatAttrByCatId?cat_id={{$cat_id}}",
                    dataType: "json",
                    success:function(item){
                        if(item.code==1){
                            if(item.data && item.data.attrs){
                                _this.attrs = item.data.attrs;
                            }
                        }
                    }
                });
            },
            updated: function () {
                console.log('updated start...')
                App.initUniform();
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
        window.sku || (window.sku = {});

        sku.getAttrJsonStr = function() {
            var propArr = new Array();
            $(".prop_item").each(function(){
                var attrName = $(this).attr("dataName");
                var attrType = $(this).attr("dataType");
                var attrId   = $(this).attr("dataVal");
                if(attrType == 'UT_CHECKBOX') {
                    $(this).find("input[type=checkbox]:checked").each(function(){
                        propArr.push({
                            "attr_id" : attrId,
                            "option_id" : this.value,
                            "option_value" : $(this).attr("dataName")
                        });
                    });
                }else if(attrType == 'UT_SELECT') {
                    $(this).find("select").each(function(){
                        if(this.value != ''){
                            propArr.push({
                                "attr_id" : attrId,
                                "option_id" : this.value,
                                "option_value" : $(this).find("option:selected").text()
                            });
                        }
                    });
                }else if(attrType == 'UT_INPUT') {
                    $(this).find("input[type=text]").each(function(){
                        if(this.value != ''){
                            propArr.push({
                                "attr_id" : attrId,
                                "attr_value" : this.value
                            });
                        }
                    });
                }
            });
            return JSON.stringify(propArr)
        }

    </script>

    <script>

        $(function(){

            CKEDITOR.replace('product_desc',{ toolbar : 'Basic'});

            var setting = {
                rules: {
                    product_title:{
                        required: true
                    },
                    product_qty:{
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
                    WX.toastr({'type':'success','message':'发布成功','onHidden':function(){
                        location.href = '/admin/product';
                    }});
                }else{
                    WX.toastr({'type':'error','message':'发布失败'});
                }
            }
        }

        function Function_Save(){

            var pdata = CKEDITOR.instances.product_desc.getData();
            $("#product_desc").val(pdata);

            if( pdata.length == 0){
                WX.toastr({'type':'info','message':'请完善产品详情...'});
                return false;
            }

            $("#attr_data").val(sku.getAttrJsonStr());

            $('#EditForm').submit();
        }

        function Function_Back(){
            location.href = '/admin/product';
        }

    </script>

    <script>
        var uploader;

        var settings = {
            browse_button : 'pickfiles',
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
        uploader.bind('PostInit', function(uploader, files) {
            //document.getElementById('#filelist').innerHTML = '';
            document.getElementById('uploadfiles').onclick = function() {
                uploader.start();
                return false;
            };
        });
        uploader.bind('FilesAdded',function(uploader,files){
            //uploader.start();
            plupload.each(files,function(file){
                var html = [];
                html.push('<div class="image-item" ><a id="file-'+file.id+'"><img id="img-'+file.id+'" src=""/>');
                html.push('<input type="hidden" name="image_url[]" value="">');
                html.push('<input type="hidden" name="image_name[]" value="">');
                html.push('<span class="process" style="width:0"></span></a></div>');
                $("#pickfiles").parent().before(html.join(''));

                previewImage(file,function(imgsrc) {
                    $('#img-' + file.id).attr('src', imgsrc );
                })

            })

        });
        uploader.bind('UploadProgress',function(uploader,file){
            //上传进度
            $('#file-' + file.id).find(".process").css({ "width": file.percent+"%"});
        });
        uploader.bind('FileUploaded',function(uploader,file,responseObject){
            var response = eval('('+responseObject.response+')');
            $('#file-' + file.id).find("input[name='image_url[]']").val(response.path);
            $('#file-' + file.id).find("input[name='image_name[]']").val(response.filename);
        });
        uploader.bind('UploadComplete',function(uploader,files){
            //console.log(files);
        });
        uploader.bind('Error',function(uploader,errObject){
            console.log(errObject);
            WX.toastr({'type':'error','timeOut':3000,'message':errObject.message});
        });

        //plupload(1.2)中为我们提供了mOxie对象
        function previewImage(file, callback) { //file为plupload事件监听函数参数中的file对象,callback为预览图片准备完成的回调函数
            if (!file || !/image\//.test(file.type)) return;
            if (file.type == 'image/gif') { //gif使用FileReader进行预览,因为mOxie.Image只支持jpg和png
                var fr = new mOxie.FileReader();
                fr.onload = function() {
                    callback(fr.result);
                    fr.destroy();
                    fr = null;
                }
                fr.readAsDataURL(file.getSource());
            } else {
                var preloader = new mOxie.Image();
                preloader.onload = function() {
                    preloader.downsize(300, 300); //先压缩一下要预览的图片,宽300，高300
                    var imgsrc = preloader.type == 'image/jpeg' ? preloader.getAsDataURL('image/jpeg', 80) : preloader.getAsDataURL(); //得到图片src,实质为一个base64编码的数据
                    callback && callback(imgsrc); //callback传入的参数为预览图片的url
                    preloader.destroy();
                    preloader = null;
                };
                preloader.load(file.getSource());
            }
        }

    </script>

@endsection
