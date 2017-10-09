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
                <a href="#">广告管理</a>
            </li>
        </ul>
    </div>

    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12" >
            <div class="portlet light bordered">
                <!-- Begin: life time stats -->
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> 广告配置</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided" >
                            <label onclick="GridClickFunction_Add('{{$ad->id}}')" class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                <i class="fa fa-plus"></i> 新增广告</label>

                            <label onclick="location.href='/admin/ad'" class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                <i class="fa fa-arrow-left"></i> 返回</label>
                        </div>
                    </div>
                </div>

                <div class="portlet-body table-container">
                    <table id="data_tables" class="table table-striped table-bordered table-hover table-checkable order-column" >
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>广告名称</th>
                            <th>广告图片</th>
                            <th>广告链接</th>
                            <th width="120px">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ( $adItems as $index=>$item )
                            <tr>
                                <td style="vertical-align:middle; text-align: center;">
                                    {{ $item->ad_item_id}}
                                </td>
                                <td style="padding-left:20px;">
                                    {{ $item->ad_item_title}}
                                </td>
                                <td>
                                    @if(!empty($item->ad_item_path))
                                        <img width="35px" height="35px" src="{{ $item->ad_item_path}}"/>
                                    @endif
                                </td>
                                <td>
                                    {{ $item->ad_item_href}}
                                </td>
                                <td>
                                    <a href="javascript:;" onclick="GridClickFunction_Edit({{ $item->ad_item_id}})" >编辑</a>&nbsp;&nbsp;
                                    <a href="javascript:;" onclick="GridClickFunction_Delete({{ $item->ad_item_id}})" >删除</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    @if(count($adItems)<1)
                        <div style="text-align:center">暂无数据...</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('foot_script')
<script type="text/javascript" src="/assets/global/plugins/datatables/datatables.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"></script>
<script type="text/javascript" src="/assets/global/scripts/datatable.js" ></script>

    <script>

        function GridClickFunction_Add(id){
            var url = '/admin/adItem?act=add&id='+id;
            location.href = url ;
        }

        function GridClickFunction_Edit(ad_item_id){
            var url = "/admin/adItem?act=edit&id="+ad_item_id;
            location.href = url ;
        }

        function GridClickFunction_Delete(ad_item_id){
            WX.Confirm('确定要删除么？',function(){
                var url = "/admin/adItem/delete/"+ad_item_id;
                AjaxAction({'url':url,'method':"GET", 'success':function(data){
                    if(data.code == 1) {
                        WX.toastr({'type':'success','message':'删除成功.','onHidden':function(){
                            location.href="/admin/adItem?id={{$ad->id}}";
                        }});
                    } else {
                        WX.toastr({'type':'error','message':'删除失败.'});
                    }
                }});
            });
        }

    </script>

@endsection