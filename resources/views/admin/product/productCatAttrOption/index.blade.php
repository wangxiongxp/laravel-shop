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
                        <span class="caption-subject bold uppercase"> 属性值管理</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided" >
                            <label onclick="GridClickFunction_Add({{ $attr->attr_id }})" class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                <i class="fa fa-plus"></i> 新增属性值</label>

                            <label onclick="location.href='/admin/productCatAttr?cat_id={{$attr->cat_id}}'" class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                <i class="fa fa-plus"></i> 返回</label>
                        </div>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="table-scrollable" >
                        <table style="min-width:360px" class="table table-striped table-bordered table-advance table-hover">
                            <thead>
                            <tr role="row">
                                <th width="3%" style="text-align: center">#</th>
                                <th width="42%">属性值</th>
                                <th width="15%">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ( $options as $index=>$option )
                            <tr>
                                <td style="vertical-align:middle; text-align: center;">
                                    {{ $index }}
                                </td>
                                <td style="padding-left:20px;">
                                    {{ $option->option_name}}
                                </td>
                                <td>
                                    <a href="javascript:;" onclick="GridClickFunction_Edit({{ $option->option_id}})" >编辑</a>&nbsp;&nbsp;
                                    <a href="javascript:;" onclick="GridClickFunction_Delete({{ $option->option_id}})" >删除</a>
                                </td>
                            </tr>
                            @endforeach

                            @if(count($options)<=0)
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

        function GridClickFunction_Add(attr_id){
            var url = '/admin/productCatAttrOption?act=add&attr_id='+attr_id;
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

        function GridClickFunction_Edit (option_id){
            var url = '/admin/productCatAttrOption?act=edit&option_id='+option_id ;
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

        function GridClickFunction_Delete(option_id){
            WX.Confirm('确定要删除么？',function(){
                var url = '/admin/productCatAttrOption/delete/'+option_id;
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

        function GridClickFunction_Option(attr_id){
            location.href = "/admin/productCatAttrOption?attr_id="+attr_id;
        }
    </script>
@endsection
