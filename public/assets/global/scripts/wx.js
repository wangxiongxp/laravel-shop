window.WX || (window.WX = {});

WX.toastr = function(options){
	var settings = {
		closeButton:true,
		debug:false,
		type: 'success',//info warning error
		positionClass: 'toast-top-center',//toast-top-left/right toast-bottom-left/right/center toast-top/bottom-full-width
		title : 'Information',
		message: 'Hello World!',
		showDuration: '1000',
		hideDuration: '1000',
		timeOut: '1000',
		extendedTimeOut: '1000',
		showEasing: 'swing',//swing linear
        hideEasing: 'swing',
        showMethod: 'fadeIn',//show fadeIn slideDown
    	hideMethod: 'fadeOut',//hide, fadeOut, slideUp
    	onclick: null,
    	onShown:null,
    	onHidden:null,
	}
	if(typeof options !== "undefined") {
		settings = $.extend(settings, options);
	}
	toastr.options = settings;
	
	var $toast = toastr[settings.type](settings.message, settings.title)
	//$toast.remove(); $toast.clear($toast);$toast.clear();
}

WX.Confirm = function(content, func_callback){
	var d = dialog({
	    title: '提示信息！',
	    content: content,
	    okValue: '确定',
	    ok: function () {
	    	if(func_callback && $.isFunction(func_callback)){
	            func_callback();
			} 
	    },
	    cancelValue: '取消',
	    cancel: function () {},
	});
	d.show();
}

WX.Info = function(content, func_callback)
{
	var d = dialog({
	    title: '提示信息！',
	    content: content,
	    okValue: '确定',
	    ok: function () {
	    	if(func_callback && $.isFunction(func_callback)){
	            func_callback();
			} 
	    }
	});
	d.show();
}

WX.Validate = function(form_id, options)
{
	var form    = $('#'+form_id);

	var settings = {
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            messages:{},
            rules:{},
            invalidHandler: function (event, validator) {
                WX.toastr({'type':'error','message':'检查输入字段...'});
            },
            highlight: function (element) { // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
            },
            success: function (label) {
                label.closest('.form-group').removeClass('has-error'); // set success class to the control group
            },
		}
	if(typeof options !== "undefined") {
		settings = $.extend(true,settings, options);
	}
	form.validate(settings);
}

function AjaxAction(option)
{
	var opts = { url:'', method : 'POST',showLoading : true, success: null, async: true};
	opts = $.extend(opts,option);

	$.ajax({
		   type: opts.method,
		   url: opts.url,
           data: opts.data,
		   async:opts.async,
		   dataType: "json",
		   showLoading : opts.showLoading,
		   error: function() {
			   WX.toastr({'type':'error','message':'Error!'});
		   },
		   success: function(data){
			   if(opts.success && $.isFunction(opts.success))
			   {
				   opts.success(data);
			   }else{
					if(data.code == 1){
						WX.toastr({'type':'success','message':'Success!'});
					}else{
						WX.toastr({'type':'error','message':'Error!'});
					}
			   }
		   }
	});
}

function ajaxJSON(url, fn_callback, async) 
{
    var async_val = (typeof(async)=="undefined" || async) ? true : false;
    $.ajax({ type: "GET", url: url, dataType: "json", async: async_val, success :
        function(response) {
            if($.isFunction(fn_callback)) {
                fn_callback(response);
            }
        }
    });
}

function ajaxSelect(url,ctl_id,d)
{
    var args = arguments;
    $.ajax({
       type: "GET",
       url: url,
       dataType: "json",
       success: function(data){
            if(data.code == 1){
                var $s1=$("#"+ctl_id);
                $.each(data.data,function(k,v){
                    var $opt=$("<option>").text(v).val(k);
                    if(k==d){
                    	$opt.attr("selected", "selected");
                    }
                    $opt.appendTo($s1);
                });
                if(args[3]){
                    var $s2 = $("#"+args[3]);
                    $s2.change();
                }
            }else{
                alert(data.msg);
            }
       }
    });
}

function ajaxSelectSimple(url,ctl_id,field_val,field_text,item_selected)
{
    var args = arguments;
    $.ajax({
       type: "GET",
       url: url,
       dataType: "json",
       async:false,
       success: function(data){
            if(data.code == 1){
                var $s1=$("#"+ctl_id);
                $.each(data.data,function(k,v){
                    var $opt=$("<option>").text(v[field_text]).val(v[field_val]);
                    if(v[field_val]==item_selected)
                    {
                        $opt.prop("selected", "selected")
                    }
                    $opt.appendTo($s1);
                });
                if(args[5]){
                    var $s2 = $("#"+args[5]);
                    $s2.change();
                }
            }else{
            	alert(data.msg);
            }
       }
    });
}

function InitSelect(ctl_id,data,d)
{
    var $s1=$("#"+ctl_id);
    $.each(data,function(k,v){
        var $opt=$("<option>").text(v).val(k);
        if(k==d){$opt.attr("selected", "selected")}
        $opt.appendTo($s1);
    });
}

function SetSelect(ctl_id,d)
{ 
    $("select[id='" + ctl_id + "'] option").each(function() {
        if( $(this).val().toLowerCase() == d.toLowerCase()) {
            $(this).attr("selected", "selected");
        }
    });
}

function SetChecked(ctl_name,d)
{
    $("input[type=checkbox][name^=" + ctl_name + "]").each(function() {
        if($(this).val() == d){
            $(this).prop("checked", "true");
        }
    });
}

function SetRadioSelected(ctlName, defaultValue){
    $("input[name=" + ctlName + "]").each(function(){
        if(this.value == defaultValue){
            $(this).prop("checked","checked").change();
        }
    })
}

function NumberFormat(obj){
    obj.value = obj.value.replace(/[^\d]/g,"");
}

function PriceFormat(obj){
    obj.value = obj.value.replace(/[^\d.]/g,"");
    obj.value = obj.value.replace(/^\./g,"");
    obj.value = obj.value.replace(/\.{2,}/g,".");
    obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
    obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3');
}

function makePager(ctrlName, nTotal, nSize) {
    if(nTotal == 0) { $("#"+ctrlName).html(''); return; }
    var p = 'page';
    var strUrl = location.search;
    var tpl = '<div class="pagenavi">{index}{prev}{first}{links}{last}{next}</div><nav class="navigation">{nav-next}{nav-previous}</nav>';
    var links = '';
    nSize = nSize ? nSize : 10;
    var nPage = Math.ceil(nTotal / nSize);
    var nIndex = (!arguments[3]) ? ESL.Url.get(strUrl, p) : arguments[3];
    nIndex = parseInt(nIndex);
    nIndex = nIndex > nPage ? nPage : (nIndex > 0 ? nIndex : 1);

    if(nIndex > 0){
        var u = ESL.Url.set(strUrl, p,nIndex - 1);
        tpl = tpl.replace('{index}',ESL.sprintf('<span class="page-numbers">%d / %d </span>', nIndex, nPage ));
    }

    if(nIndex > 1) {
        var u = ESL.Url.set(strUrl, p,nIndex - 1);
        tpl = tpl.replace('{prev}',ESL.sprintf('<a class="page-numbers" href="%s" title="上一页">上一页</a>', u ));
        tpl = tpl.replace('{nav-previous}',ESL.sprintf('<div class="nav-previous"><a href="%s">上一页</a></div>',u ));
    }else{
        tpl = tpl.replace('{nav-previous}','');
    }

    if(nIndex < nPage) {
        var u = ESL.Url.set(strUrl, p,nIndex + 1);
        tpl = tpl.replace('{next}',ESL.sprintf('<a class="page-numbers" href="%s" title="下一页">下一页</a>', u ));
        tpl = tpl.replace('{nav-next}',ESL.sprintf('<div class="nav-previous"><a href="%s">下一页</a></div>',u ));
    }else{
        tpl = tpl.replace('{nav-next}','');
    }

    u = ESL.Url.set(strUrl, p, 1);
    tpl = tpl.replace('{first}',ESL.sprintf('<a class="page-numbers" href="%s" title="首页">首页</a>', u ));
    u = ESL.Url.set(strUrl, p, nPage);
    tpl = tpl.replace('{last}',ESL.sprintf('<a class="page-numbers" href="%s" title="末页">末页</a>', u ));
    // 计算分页边界，前面几个后面几个
    sn = 5;
    s = (nPage < sn) ? nPage : sn;
    if ( nIndex >= s ) {
        e = Math.floor(s/2); b = s - e - 1;
        b = nIndex - b; e = nIndex + e;
        e = e > nPage ? nPage : e;
        b = e < sn ? 1 : b;
    }else{
        b = 1; e = s;
    }
    // 修正不足sn的情况
    t = Math.floor(s/2);
    b = ((e - nIndex) < t) && ((e - s +1) > 0 )? (e - s +1) : b;
    for(var i = b; i < e + 1; i++ ) {
        var u = ESL.Url.set(strUrl, p,i);
        var t = ESL.sprintf('<a class="page-numbers" href="%s" title="第 %d 页">%d</a>', u, i, i );
        if(i == nIndex) {
            t = ESL.sprintf('<span class="page-numbers current">%d</span>',i );
        }
        links += t;
    }
    tpl = tpl.replace('{links}',links);
    tpl = tpl.replace(/\{\w+\}/g, '');
    $("#"+ctrlName).html(tpl);
}

function makePagerSys(ctrlName, nTotal, nSize) {
    if(nTotal == 0) { $("#"+ctrlName).html(''); return; }
    var p = 'page';
    var strUrl = location.search;
    var tpl = '{first}{prev}{links}{next}{last}';
    var links = '';
    nSize = nSize ? nSize : 10;
    var nPage = Math.ceil(nTotal / nSize);
    var nIndex = (!arguments[3]) ? ESL.Url.get(strUrl, p) : arguments[3];
    nIndex = parseInt(nIndex);
    nIndex = nIndex > nPage ? nPage : (nIndex > 0 ? nIndex : 1);
    if(nIndex > 1) {
        var u = ESL.Url.set(strUrl, p,nIndex - 1);
        tpl = tpl.replace('{prev}',ESL.sprintf('<li><a href="%s" title="上一页">%s</a></li>', u, '«' ));
    }
    if(nIndex < nPage) {
        var u = ESL.Url.set(strUrl, p,nIndex + 1);
        tpl = tpl.replace('{next}',ESL.sprintf('<li><a href="%s" title="下一页">%s</a></li>', u, '»' ));
    }
    u = ESL.Url.set(strUrl, p, 1);
    tpl = tpl.replace('{first}',ESL.sprintf('<li><a href="%s">%s</a></li>', u, '首页' ));
    u = ESL.Url.set(strUrl, p, nPage);
    tpl = tpl.replace('{last}',ESL.sprintf('<li><a href="%s">%s</a></li>', u, '末页' ));
    // 计算分页边界，前面几个后面几个
    sn = 5;
    s = (nPage < sn) ? nPage : sn;
    if ( nIndex >= s ) {
        e = Math.floor(s/2); b = s - e - 1;
        b = nIndex - b; e = nIndex + e;
        e = e > nPage ? nPage : e;
        b = e < sn ? 1 : b;
    }else{
        b = 1; e = s;
    }
    // 修正不足sn的情况
    t = Math.floor(s/2);
    b = ((e - nIndex) < t) && ((e - s +1) > 0 )? (e - s +1) : b;
    for(var i = b; i < e + 1; i++ ) {
        var u = ESL.Url.set(strUrl, p,i);
        var t = ESL.sprintf('<li><a href="%s">%d</a></li>', u, i );
        if(i == nIndex) {
            t = ESL.sprintf('<li class="active"><a href="#">%d <span class="sr-only">(current)</span></a></li>',i );
        }
        links += t;
    }
    tpl = tpl.replace('{links}',links);
    tpl = tpl.replace(/\{\w+\}/g, '');
    $("#"+ctrlName).html(tpl);
}
