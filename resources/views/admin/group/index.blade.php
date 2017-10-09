@extends('admin.layouts.default')

@section('head_css')
    <link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/datatables.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/global/plugins/jstree/dist/themes/default/style.min.css"/>
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
                <a href="#">组织管理</a>
            </li>
        </ul>
    </div>

    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12">
            <div class="portlet light bordered">

                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase"> 组织管理</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided" >
                            <label onclick="GridClickFunction_Add()" class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                <i class="fa fa-plus"></i> 新增组织</label>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="portlet light" style="padding-left:5px">
                                <div class="portlet-body">
                                    <div id="tree_group" class="tree-demo"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9" >
                            <!-- Begin: life time stats -->
                            <div class="row" >
                                <div class="col-md-12">

                                    <div class="portlet light">
                                        <div class="portlet-title tabbable-line">
                                            <div class="caption">
                                                <i class="icon-pin font-yellow-crusta"></i>
                                                <span class="caption-subject "> 当前组织： </span>
                                                <span class="caption-helper" id="curr_group_name"> 未选择...</span>
                                            </div>
                                            <div class="tools">
                                                <a href="javaScript:void(0)" onclick="GridClickFunction_Edit()"> 编辑 </a>
                                                <a href="javaScript:void(0)" onclick="GridClickFunction_Delete()"> 删除 </a>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <form id="AddForm" method="post" role="form" class="form-horizontal">
                                                <div class="form-body">

                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">所属部门： </label>
                                                        <div class="col-md-10">
                                                            <p class="form-control-static" id="s_group_parent">

                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">组织名称： </label>
                                                        <div class="col-md-10">
                                                            <p class="form-control-static" id="s_group_name">

                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">组织类型： </label>
                                                        <div class="col-md-10">
                                                            <p class="form-control-static" id="s_group_type">

                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">组织备注： </label>
                                                        <div class="col-md-10">
                                                            <p class="form-control-static" id="s_group_desc">

                                                            </p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
    <script type="text/javascript" src="/assets/global/plugins/jstree/dist/jstree.min.js"></script>

    <script>

        var table;
        var groupId;
        var groupName;

        $('#tree_group').jstree({
            "core" : {
                "themes" : {
                    "responsive": false
                },
                'data': {
                    'url' : function (node) {
                        return '/admin/group/getGroupTree';
                    },
                    'data' : function (node) {
                        return { };
                    }
                }
            },
            "types" : {
                "default" : {
                    "icon" : "fa fa-folder icon-state-warning icon-lg"
                },
                "file" : {
                    "icon" : "fa fa-file icon-state-warning icon-lg"
                }
            },
            "plugins": ["types"]
        });



        $(document).ready(function(){
            $('#tree_group').on('select_node.jstree', function(e,data) {
                groupName = data.node.text ;
                groupId = data.node.id ;
                $("#curr_group_name").text(groupName);

                getGroupInfo(groupId);
            });
        });

        function getGroupInfo(s_group_id){
            var url = '/admin/group/get/'+s_group_id ;
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'json',
                success: function(data){
                    var item = data.data;
                    if(item.s_group_parent==0){
                        $("#s_group_parent").text("顶级部门");
                    }else{
                        $("#s_group_parent").text(item.s_group_parent_name);
                    }
                    $("#s_group_name").text(item.s_group_name);
                    $("#s_group_type").text(item.s_group_type_name);
                    $("#s_group_desc").text(item.s_group_desc);
                }
            });
        }

        function GridClickFunction_Add(){
            if(undefined == groupId || null == groupId || groupId == ''){
                WX.toastr({'type':'info','message':'请选择群组.'});
                return ;
            }
            var url = '/admin/group/add?s_group_id='+groupId + '&s_group_name=' + groupName ;
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

        function GridClickFunction_Edit(){
            if(undefined == groupId || null == groupId || groupId == ''){
                WX.toastr({'type':'info','message':'请选择群组.'});
                return ;
            }
            var url = '/admin/group/edit/'+groupId ;
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

        function GridClickFunction_Delete(){
            if(undefined == groupId || null == groupId || groupId == ''){
                WX.toastr({'type':'info','message':'请选择群组.'});
                return ;
            }

            WX.Confirm('确定要删除么？',function(){
                var url = "/admin/group/delete/"+groupId ;
                AjaxAction({'url':url,'method':'GET', 'success':function(data){
                    if(data && data.code == 1) {
                        WX.toastr({'type':'success','message':'删除成功.','onHidden':function(){
                            location.href = location.href;
                        }});
                    } else {
                        WX.toastr({'type':'error','message':'删除失败.'});
                    }
                }});
            });
        }

    </script>
@endsection

