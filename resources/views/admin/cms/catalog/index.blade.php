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
                <a href="#">内容管理</a>
            </li>
        </ul>
    </div>

    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12" >
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">

                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> 栏目管理</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided" >
                            <label onclick="GridClickFunction_Add()" class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                <i class="fa fa-plus"></i> 新增栏目</label>
                        </div>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="table-scrollable" >
                        <table style="min-width:360px" class="table table-striped table-bordered table-advance table-hover">
                            <thead>
                            <tr role="row">
                                <th width="5%" style="text-align: center">#</th>
                                <th width="42%">栏目名称</th>
                                <th width="20%">别名</th>
                                <th width="20%">状态</th>
                                <th width="15%">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ( $catalogs as $catalog )
                            <tr>
                                <td style="vertical-align:middle; text-align: center;">
                                    @if ( $catalog->is_leaf == 0 )
                                    <a href="javascript:void(0)" data-id='{{ $catalog->id}}' class="" onclick="CateToggle(this)"><i class="fa fa-plus"></i></a>
                                    @endif
                                </td>
                                <td style="padding-left:20px;">
                                    {{ $catalog->name}}
                                </td>
                                <td>
                                    {{ $catalog->code}}
                                </td>
                                <td>
                                    @if($catalog->status == 1)
                                        开启
                                    @else
                                        关闭
                                    @endif
                                </td>
                                <td>
                                    <a href="javascript:;" onclick="GridClickFunction_Edit({{ $catalog->id}})" >编辑</a>&nbsp;&nbsp;
                                    <a href="javascript:;" onclick="GridClickFunction_Delete({{ $catalog->id}})" >删除</a>
                                </td>
                            </tr>
                            @foreach ( $catalog->sub as $sub )
                            <tr style="display:none" class="sub_cat_{{ $catalog->id}}">
                                <td>
                                </td>
                                <td style="padding-left:50px;">
                                    {{ $sub->name}}
                                </td>
                                <td>
                                    {{ $sub->code}}
                                </td>
                                <td>
                                    @if($catalog->status == 1)
                                        开启
                                    @else
                                        关闭
                                    @endif
                                </td>
                                <td>
                                    <a href="javascript:;" onclick="GridClickFunction_Edit({{ $sub->id}})">编辑</a>&nbsp;&nbsp;
                                    <a href="javascript:;" onclick="GridClickFunction_Delete({{ $sub->id}})">删除</a>
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

    <script>

        function GridClickFunction_Add(){
            var url = '/admin/catalog?act=add';
            location.href = url ;
        }

        function GridClickFunction_Edit (menuId){
            var url = '/admin/catalog?act=edit&id='+menuId ;
            location.href = url ;
        }

        function GridClickFunction_Delete(menuId){
            WX.Confirm('确定要删除么？',function(){
                var url = '/admin/catalog/delete/'+menuId;
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
