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
                <a href="#">产品类别管理</a>
            </li>
        </ul>
    </div>

    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12" >
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">

                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> 类别管理</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided" >
                            <label onclick="GridClickFunction_Add()" class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                <i class="fa fa-plus"></i> 新增类别</label>
                        </div>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="table-scrollable" >
                        <table style="min-width:360px" class="table table-striped table-bordered table-advance table-hover">
                            <thead>
                            <tr role="row">
                                <th width="3%" style="text-align: center">#</th>
                                <th width="42%">类别名称</th>
                                <th width="15%">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ( $cats as $cat )
                            <tr>
                                <td style="vertical-align:middle; text-align: center;">
                                    @if ( $cat->cat_leaf == 0 )
                                    <a href="javascript:void(0)" data-id='{{ $cat->cat_id}}' class="" onclick="CateToggle(this)"><i class="fa fa-plus"></i></a>
                                    @endif
                                </td>
                                <td style="padding-left:20px;">
                                    {{ $cat->cat_title}}
                                </td>
                                <td>
                                    <a href="javascript:;" onclick="GridClickFunction_Edit({{ $cat->cat_id}})" >编辑</a>&nbsp;&nbsp;
                                    <a href="javascript:;" onclick="GridClickFunction_Delete({{ $cat->cat_id}})" >删除</a>&nbsp;&nbsp;
                                    @if ( $cat->cat_leaf == 1 )
                                        <a href="javascript:;" onclick="GridClickFunction_Attr({{ $cat->cat_id}})" >属性配置</a>
                                    @endif
                                </td>
                            </tr>
                            @foreach ( $cat->sub as $sub )
                            <tr style="display:none" class="sub_cat_{{ $cat->cat_id}}">
                                <td>
                                </td>
                                <td style="padding-left:50px;">
                                    {{ $sub->cat_title}}
                                </td>
                                <td>
                                    <a href="javascript:;" onclick="GridClickFunction_Edit({{ $sub->cat_id}})">编辑</a>&nbsp;&nbsp;
                                    <a href="javascript:;" onclick="GridClickFunction_Delete({{ $sub->cat_id}})">删除</a>&nbsp;&nbsp;
                                    @if ( $sub->cat_leaf == 1 )
                                        <a href="javascript:;" onclick="GridClickFunction_Attr({{ $sub->cat_id}})" >属性配置</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @endforeach

                            @if(count($cats)<=0)
                                <tr>
                                    <td colspan="3" style="text-align: center;padding:20px 0">
                                        暂无数据
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
</div>
@endsection

@section('foot_script')
    <script type="text/javascript" src="/assets/global/plugins/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"></script>
    <script type="text/javascript" src="/assets/global/scripts/datatable.js" ></script>

    <script>

        function GridClickFunction_Add(){
            var url = '/admin/productCat?act=add';
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'html',
                success: function(data){
                    $('#popupModel .modal-content').html(data);
                    App.initSlimScroll('.scroller');
                }
            });
            $('#popupModel').modal('show');
        }

        function GridClickFunction_Edit (cat_id){
            var url = '/admin/productCat?act=edit&cat_id='+cat_id ;
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'html',
                success: function(data){
                    $('#popupModel .modal-content').html(data);
                    App.initSlimScroll('.scroller');
                }
            });
            $('#popupModel').modal('show');
        }

        function GridClickFunction_Delete(cat_id){
            WX.Confirm('确定要删除么？',function(){
                var url = '/admin/productCat/delete/'+cat_id;
                AjaxAction({'url':url,'method':'GET', 'success':function(data){
                    if(data.code == 1) {
                        WX.toastr({'type':'success','message':'删除成功!','onHidden':function(){
                            location.href = location.href;
                        }});
                    } else {
                        WX.toastr({'type':'error','message':'删除失败!'});
                    }
                }});
            });
        }

        function CateToggle(obj){
            var id = $(obj).data('id');
            var open = $(obj).hasClass('open');
            if(open){
                $(".sub_cat_"+id).hide();
                $(obj).removeClass('open');
                $(obj).find('i').removeClass('fa-minus').addClass('fa-plus');
            }else{
                $(".sub_cat_"+id).show();
                $(obj).addClass('open');
                $(obj).find('i').removeClass('fa-plus').addClass('fa-minus');
            }
        }

        function GridClickFunction_Attr(cat_id){
            location.href = "/admin/productCatAttr?cat_id="+cat_id;
        }
    </script>
@endsection
