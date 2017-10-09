<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
        菜单设定
    </h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <form id="AddForm" method="post">
                <input type="hidden" id="s_role_id" name="s_role_id" value="{{ $s_role_id}}">
                <!-- BEGIN BORDERED TABLE PORTLET-->
                <div class="portlet box ">
                    <div class="portlet-body">
                        <div class="table-scrollable">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        菜单
                                    </th>
                                    <th>
                                        URL
                                    </th>
                                    <th>
                                        操作
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($menus as $key=>$menu)
                                <tr>
                                    <td>
                                        {{ $key+1 }}
                                    </td>
                                    <td>
                                        {{ $menu->menu_text}}
                                    </td>
                                    <td>
                                        {{ $menu->menu_url}}
                                    </td>
                                    <td>
                                        <div class="checkbox-list">
                                            <input @if( $menu->s_role_id ) checked="checked"@endif value="{{ $menu->menu_id}}" name="menu_id[]" type="checkbox"></span>
                                        </div>
                                    </td>
                                </tr>
                                @foreach ( $menu->sub as $index=>$sub )
                                <tr>
                                    <td>
                                        {{ $key+1 }}---{{ $index+1 }}
                                    </td>
                                    <td>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $sub->menu_text}}
                                    </td>
                                    <td>
                                        {{ $sub->menu_url}}
                                    </td>
                                    <td>
                                        <input @if ( $sub->s_role_id ) checked="checked" @endif value="{{ $sub->menu_id}}" name="menu_id[]" type="checkbox"></span>
                                    </td>
                                </tr>
                                @endforeach
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END BORDERED TABLE PORTLET-->
            </form>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn blue" onclick="Function_SaveForm();">保存</button>
    <button type="button" data-dismiss="modal" class="btn btn-default">关闭</button>
</div>

<script type="text/javascript">

    $(document).ready(function(){

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
                    location.href="/admin/role";
                }});
            }else{
                WX.toastr({'type':'error','message':'保存失败!'});
            }
        }
    }

    function Function_SaveForm(){

        $("#AddForm").attr('action','/admin/role/saveMenus');
        $("#AddForm").submit();
    }
</script>


