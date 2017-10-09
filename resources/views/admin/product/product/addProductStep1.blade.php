@extends('admin.layouts.default')

@section('head_css')
    <script type="text/javascript" src="/assets/global/plugins/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/plupload/js/plupload.full.min.js"></script>
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
                <a href="#">产品管理</a>
            </li>
        </ul>
    </div>

    <div class="row" style="margin-top:20px;margin-left:0;margin-right:0">
        <div class="col-md-12">
            <form method="post" class="form-horizontal" action="" id="EditForm" name="EditForm">
                <div class="portlet light bordered" >
                    <div class="portlet-body form" >
                        <div class="form-body" style="padding-top:20px;">
                            <div class="form-group" id="selected_category">
                                <label class="col-md-3 control-label">产品类别<span class="required" >*</span></label>
                                <div class="col-md-6">
                                    <input type="hidden" name="product_cat_id" id="product_cat_id" value="" />
                                    <input type="hidden" name="product_cat_title" id="product_cat_title" value="" />
                                    <p id="category_name" class="form-control-static"> 请选择要发布的产品类别 </p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label"></label>
                                <div class="col-md-10 category">
                                    <div class="form-group">
                                        <div class="col-md-3 col-sm-6 col-xs-12 item_list value1 margin-bottom-10" >
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12 item_list value2 margin-bottom-10" style="display:none">
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12 item_list value3 margin-bottom-10" style="display:none">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" style="margin-top:20px;text-align:center">
                                <a class="btn btn-primary" onclick="PageClickFunction_Next();">现在就去发布宝贝</a>
                            </div>

                        </div>
                    </div>
                </div>
                <span class="clearfix"></span>
            </form>
        </div>
    </div>

</div>
@endsection

@section('foot_script')

    <script type="text/javascript">

        $(function(){
            InitCategory();
        });

        function InitCategory(){
            var value  = 1 ;
            $.ajax({
                type:"GET",
                url:"/admin/productCat/getCatalogByParent/0",
                dataType:"json",
                success:function(item){
                    if(item.code==1){
                        var data = item.data;
                        var html = '<select class="form-control" size="8">';
                        for(var i=0;i<data.length;i++){
                            html += '<option value="'+data[i].cat_id+'" data-leaf='+data[i].cat_leaf+' name="'+data[i].cat_title+'" onClick="GetCategory(this, 1)">'+data[i].cat_title;
                            if(data[i].cat_leaf==0){
                                html+= '&nbsp;&gt;';
                            }
                            html+= '</option>';
                        }
                        html += '</select>';
                        $(".category .value1").append(html);
                    }
                }
            });
        }

        function GetCategory(obj,level){
            $("#product_cat_id").val('');
            level = parseInt(level);
            var cat_id = $(obj).val();
            var cat_name_1 = $(obj).html();

            if(level > 1 ) {
                cat_name_1 = $("#category_name").html();
                if($("span.cat_level_" + level).length) {
                    $("span.cat_level_" + level).html($(obj).html());
                } else {
                    cat_name_1 += ESL.sprintf('<span class="cat_level_%d">%s</span>', level, level, $(obj).html());
                }
            }

            $("#category_name").html(cat_name_1);

            if($("span.cat_level_" + level).length) {
                $("span.cat_level_" + level).html($(obj).html());
            }

            if($(obj).attr("data-leaf")==1){
                $(".category .value"+(level)).nextAll(".item_list").hide();
                $("span.cat_level_" + level).nextAll("span").remove();
                SetCategory(obj); return;
            }

            $.ajax({
                type:"GET",
                url:"/admin/productCat/getCatalogByParent/"+cat_id,
                dataType:"json",
                success:function(item){
                    if(item.code==1){
                        var data = item.data;
                        $(".category .value"+(level + 1)).nextAll(".item_list").hide();
                        $(".category .value"+(level + 1)).show();
                        $(".category .item_list:eq("+ level +")").empty();

                        var cat_id = data[0].cat_id;
                        var html = '<select class="form-control" size="8">';
                        for(var i=0;i<data.length;i++){
                            html += '<option value="'+data[i].cat_id+'" data-leaf='+data[i].cat_leaf+' name="'+data[i].cat_title+'" onClick="GetCategory(this, '+(level + 1)+')">'+data[i].cat_title;
                            if(data[i].cat_leaf==0){
                                html+= '&nbsp;&gt;';
                            }
                            html+= '</option>';
                        }
                        html += '</select>';
                        $(".category .item_list:eq(" + level + ") ").append(html);
                    }
                }
            });
        }

        function SetCategory(obj){
            var cat_id = $(obj).val();
            var cat_title = $(obj).html();
            $("#product_cat_id").val(cat_id);
            $("#product_cat_title").val(cat_title);
        }


        function PageClickFunction_Next(){
            var product_cat_id = $("#product_cat_id").val();
            if(product_cat_id==''||product_cat_id==null){
                WX.toastr({'type':'error','message':'请选择产品分类...'});
                return false;
            }
            location.href = '/admin/product?act=add&cat_id='+product_cat_id;
        }

    </script>

@endsection
