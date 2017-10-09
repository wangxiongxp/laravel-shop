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
                            <span class="caption-subject bold uppercase"> 编辑栏目</span>
                        </div>
                    </div>

                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="AddForm" method="post" role="form" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">父级栏目<span class="required" >*</span></label>
                                            <div class="col-md-4">
                                                <select class="form-control" id="parent_id" disabled="disabled" name="parent_id">
                                                    <option value='0'>一级栏目</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">栏目名称<span class="required" >*</span></label>
                                            <div class="col-md-4">
                                                <input type="hidden" id="id" name="id" value="{{ $catalog->id}}" >
                                                <input type="text" id="name" name="name" value="{{ $catalog->name}}" placeholder="" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">别名<span class="required" >*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" id="code" name="code" value="{{ $catalog->code}}" placeholder="" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">栏目描述<span class="required" ></span></label>
                                            <div class="col-md-6">
                                                <textarea type="text" id="description" name="description" class="form-control">{{ $catalog->description}}</textarea>
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
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">排序<span class="required" >*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" id="sort" name="sort" value="{{ $catalog->sort}}" placeholder="" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label"></label>
                                            <div class="col-md-6">
                                                <a class="btn btn-primary" onclick="Function_SaveForm()">保存</a>
                                                <a class="btn btn-primary" onclick="Function_Back()">返回</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
@endsection

@section('foot_script')
    <script type="text/javascript">

        $(document).ready(function(){

            SetRadioSelected('status','{{$catalog->status}}')
            App.initUniform();

            ajaxSelectSimple('/admin/cms/catalog/getCatalogByParent/0','parent_id','id','name','{{ $catalog->parent_id}}');
            var setting = {
                rules: {
                    name: {
                        required: true,
                    },
                    code: {
                        required: true,
                    },
                    status: {
                        required: true,
                    },
                    sort: {
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
                    WX.toastr({'type':'success','message':'修改成功.','onHidden':function(){
                        location.href = "/admin/cms/catalog";
                    }});
                }else{
                    WX.toastr({'type':'error','message':'修改失败!'});
                }
            }
        }

        function Function_SaveForm(){
            $("#AddForm").attr('action','/admin/cms/catalog/update');
            $("#AddForm").submit();
        }

        function Function_Back(){
            location.href = "/admin/cms/catalog";
        }

    </script>

@endsection
