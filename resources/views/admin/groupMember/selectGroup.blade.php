<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
        群组授权
    </h4>
</div>

<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light" style="padding-left:5px">
                <div class="portlet-body">
                    <div id="groupTree" class="tree-demo"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn blue" onclick="saveTree();">保存</button>
    <button type="button" data-dismiss="modal" class="btn btn-default">关闭</button>
</div>

<script type="text/javascript">

    var currAccountId = '';

    $(document).ready(function(){
        currAccountId = '{{ $account_id}}';

        showGroupTree();
    });

    function showGroupTree() {

        $.ajax({
            type : "GET",
            dataType : 'json',
            url : "/admin/groupMember/getSelectedGroupTree/"+currAccountId,
            error : function(data) {
                WX.toastr({'type':'error','message':'数据初始化失败!'});
            },
            success : function(data) {
                createGroupTree(data);
            }
        });

    }

    function createGroupTree(datastr) {
        $('#groupTree').jstree({
            'plugins' : [ "wholerow", "checkbox", "types" ],
            'core' : {
                "themes" : {
                    "responsive" : false
                },
                'data' : datastr
            },
            "types" : {
                "default" : {
                    "icon" : "fa fa-folder icon-state-warning icon-lg"
                },
                "file" : {
                    "icon" : "fa fa-file icon-state-warning icon-lg"
                }
            }
        });
    }

    function saveTree() {
        var outList = $('#groupTree').jstree('get_selected');

        $.ajax({
            data : {'account_id' : currAccountId, 'selectedNodes' : outList.join('@@')},
            type : "POST",
            dataType : 'json',
            url : "/admin/groupMember/saveGroupGrant",
            error : function(data) {
                WX.toastr({'type':'error','message':'保存失败!'});
            },
            success : function(data) {
                WX.toastr({'type':'success','message':'保存成功!'});
                $('#popupModel').modal('hide');
            }
        });
    }

</script>
