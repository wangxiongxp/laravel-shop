var Profile = function() {

    return {

        //main function
        init: function() {
            Profile.initProfileForm();
            Profile.initModifyPasswordForm();
            Profile.initUpdateUserPhotoForm();
        },

        initProfileForm: function() {
            var $profileForm = $('#profileForm');
            $profileForm.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                    sys_account_email: {
                        email: true
                    }
                },

                messages: { // custom messages for radio buttons and checkboxes
                    sys_account_email: {
                        email: "邮箱格式不正确"
                    }
                },

                invalidHandler: function(event, validator) { //display error alert on form submit

                },

                highlight: function(element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                success: function(label) {
                    label.closest('.form-group').removeClass('has-error');
                    label.remove();
                },

                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                }
            });

            $profileForm.find('input').keypress(function(e) {
                if (e.which == 13) {
                    if ($profileForm.validate().form()) {
                        $profileForm.find('.has-error').removeClass('has-error');
                        $profileForm.submit();
                    }
                    return false;
                }
            });
            var options = {
                dataType:  'json',
                beforeSubmit:  function() {
                    Metronic.blockUI({ animate: true});
                    return true;
                },
                success: function(responseText){
                    Metronic.unblockUI();
                    if(responseText){
                        if(responseText.code == 1) {
                            EM.toastr({'type':'success','message':'修改个人资料成功'});
                        }else{
                            EM.toastr({'type':'error','message': responseText.msgs[0]});
                        }
                    }
                }
            };
            $profileForm.ajaxForm(options);
        },

        initUpdateUserPhotoForm: function() {
            var photoForm = $('#updateUserPhotoForm');
            var options = {
                dataType:  'json',
                beforeSubmit:  function() {
                    Metronic.blockUI({ animate: true});
                    return true;
                },
                success: function(responseText){
                    Metronic.unblockUI();
                    if(responseText){
                        if(responseText.code == 1) {
                            EM.toastr({'type':'success','message':'更改头像成功'});
                        }else{
                            EM.toastr({'type':'error','message': responseText.msgs[0]});
                        }
                    }
                }
            };
            photoForm.ajaxForm(options);
        },

        initModifyPasswordForm: function() {
            var $form = $('#modify_password_form');
            $form.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                    old_password: {
                        required: true
                    },
                    password: {
                        required: true
                    },
                    confirm_password: {
                        equalTo: "#register_password"
                    }
                },

                messages: { // custom messages for radio buttons and checkboxes
                    old_password: {
                        required: "请输入当前密码"
                    }
                },

                invalidHandler: function(event, validator) { //display error alert on form submit

                },

                highlight: function(element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                success: function(label) {
                    label.closest('.form-group').removeClass('has-error');
                    label.remove();
                },

                errorPlacement: function(error, element) {
                    error.insertAfter(element.closest('.input-icon'));
                }
            });

            $form.find('input').keypress(function(e) {
                if (e.which == 13) {
                    if ($form.validate().form()) {
                        $form.find('.has-error').removeClass('has-error');
                        $form.submit();
                    }
                    return false;
                }
            });
            var options = {
                dataType:  'json',
                beforeSubmit:  function() {
                    Metronic.blockUI({ animate: true});
                    return true;
                },
                success: function(responseText){
                    Metronic.unblockUI();
                    if(responseText){
                        if(responseText.code == 1) {
                            EM.toastr({'type':'success','message':'修改密码成功'});
                            $form.find("input[type=password]").val('');
                        }else{
                            EM.toastr({'type':'error','message': responseText.msgs[0]});
                        }
                    }
                }
            };
            $form.ajaxForm(options);
        }
    };

}();