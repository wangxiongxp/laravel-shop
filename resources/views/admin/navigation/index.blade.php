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
                <a href="#">导航管理</a>
            </li>
        </ul>
    </div>

    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12" >
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">

                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> 导航管理</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided" >
                            <label onclick="GridClickFunction_Add()" class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                <i class="fa fa-plus"></i> 新增导航</label>
                        </div>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="table-scrollable" >
                        <table style="min-width:360px" class="table table-striped table-bordered table-advance table-hover">
                            <thead>
                            <tr role="row">
                                <th width="5%" style="text-align: center">#</th>
                                <th width="42%">导航名称</th>
                                <th width="20%">导航链接</th>
                                <th width="20%">导航类型</th>
                                <th width="15%">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($navs as $nav)
                                <tr>
                                    <td style="vertical-align:middle; text-align: center;">
                                        @if($nav->nav_leaf == 0)
                                            <a href="javascript:void(0)" data-id='{{ $nav->nav_id }}' class="" onclick="CateToggle(this)"><i class="fa fa-plus"></i></a>
                                        @endif
                                    </td>
                                    <td style="padding-left:20px;">
                                        {{ $nav->nav_title}}
                                    </td>
                                    <td>
                                        {{ $nav->nav_path}}
                                    </td>
                                    <td>
                                        @if($nav->nav_type == 1)
                                            顶部导航
                                        @elseif($nav->nav_type == 2)
                                            底部导航
                                        @elseif($nav->nav_type == 3)
                                            顶部+底部导航
                                        @endif
                                    </td>
                                    <td>
                                        <a href="javascript:;" onclick="GridClickFunction_Edit({{ $nav->nav_id}})" >编辑</a>&nbsp;&nbsp;
                                        <a href="javascript:;" onclick="GridClickFunction_Delete({{ $nav->nav_id}})" >删除</a>
                                    </td>
                                </tr>
                                @foreach($nav->sub as $sub)
                                    <tr style="display:none" class="sub_cat_{{ $nav->nav_id}}">
                                        <td>
                                        </td>
                                        <td style="padding-left:50px;">
                                            {{ $sub->nav_title}}
                                        </td>
                                        <td>
                                            {{ $sub->nav_path}}
                                        </td>
                                        <td>
                                            @if($nav->nav_type == 1)
                                                顶部导航
                                            @elseif($nav->nav_type == 2)
                                                底部导航
                                            @elseif($nav->nav_type == 3)
                                                顶部+底部导航
                                            @endif
                                        </td>
                                        <td>
                                            <a href="javascript:;" onclick="GridClickFunction_Edit({{ $sub->nav_id}})">编辑</a>&nbsp;&nbsp;
                                            <a href="javascript:;" onclick="GridClickFunction_Delete({{ $sub->nav_id}})">删除</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach

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

    <script type="text/javascript" >

        function GridClickFunction_Add(){
            var url = '/admin/navigation?act=add';
            location.href = url ;
        }

        function GridClickFunction_Edit (nav_id){
            var url = '/admin/navigation?act=edit&id='+nav_id ;
            location.href = url ;
        }

        function GridClickFunction_Delete(nav_id){
            WX.Confirm('确定要删除么？',function(){
                var url = '/admin/navigation/delete/'+nav_id;
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
    </script>
@endsection
