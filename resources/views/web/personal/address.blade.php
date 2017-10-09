@extends('web.layouts.person')

@section('assets_head')
	<title>地址管理</title>
	<link href="/assets/front/css/personal.css" rel="stylesheet" type="text/css">
	<link href="/assets/front/css/addstyle.css" rel="stylesheet" type="text/css">
@endsection

@section('content')

	<div class="center">
		<div class="col-main">
			<div class="main-wrap">

				<div class="user-address">
					<!--标题 -->
					<div class="am-cf am-padding">
						<div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">地址管理</strong> / <small>Address&nbsp;list</small></div>
					</div>
					<hr/>

					@if(count($addresses)<=0)
						<div style="padding-top:20px;text-align: center">暂无数据...</div>
					@endif
					<ul class="am-avg-sm-1 am-avg-md-3 am-thumbnails">

						@foreach($addresses as $address)
							<li class="user-addresslist @if($address->is_default) defaultAddr @endif">
								<span class="new-option-r" data-id="{{$address->address_id}}">
									<i class="am-icon-check-circle"></i>默认地址</span>
								<p class="new-tit new-p-re">
									<span class="new-txt">{{$address->receiver_name}}</span>
									<span class="new-txt-rd2">{{$address->receiver_phone}}</span>
								</p>
								<div class="new-mu_l2a new-p-re">
									<p class="new-mu_l2cw">
										<span class="title">地址：</span>
										<span class="street">{{$address->receiver_full_address}}</span>
									</p>
								</div>
								<div class="new-addr-btn">
									<a href="#"><i class="am-icon-edit"></i>编辑</a>
									<span class="new-addr-bar">|</span>
									<a href="javascript:void(0);" onclick="delClick(this);"><i class="am-icon-trash"></i>删除</a>
								</div>
							</li>
						@endforeach

					</ul>
					<div class="clear"></div>
					<a class="new-abtn-type" data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0}">添加新地址</a>
					<!--例子-->
					<div class="am-modal am-modal-no-btn" id="doc-modal-1">

						<div class="add-dress">

							<!--标题 -->
							<div class="am-cf am-padding">
								<div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">新增地址</strong> / <small>Add&nbsp;address</small></div>
							</div>
							<hr/>

							<div class="am-u-md-12 am-u-lg-8" style="margin-top: 20px;">
								<form class="am-form am-form-horizontal">

									<div class="am-form-group">
										<label for="user-name" class="am-form-label">收货人</label>
										<div class="am-form-content">
											<input type="text" id="user-name" placeholder="收货人">
										</div>
									</div>

									<div class="am-form-group">
										<label for="user-phone" class="am-form-label">手机号码</label>
										<div class="am-form-content">
											<input id="user-phone" placeholder="手机号必填" type="email">
										</div>
									</div>
									<div class="am-form-group">
										<label for="user-address" class="am-form-label">所在地</label>
										<div class="am-form-content address">
											<select data-am-selected>
												<option value="a">浙江省</option>
												<option value="b" selected>湖北省</option>
											</select>
											<select data-am-selected>
												<option value="a">温州市</option>
												<option value="b" selected>武汉市</option>
											</select>
											<select data-am-selected>
												<option value="a">瑞安区</option>
												<option value="b" selected>洪山区</option>
											</select>
										</div>
									</div>

									<div class="am-form-group">
										<label for="user-intro" class="am-form-label">详细地址</label>
										<div class="am-form-content">
											<textarea class="" rows="3" id="user-intro" placeholder="输入详细地址"></textarea>
											<small>100字以内写出你的详细地址...</small>
										</div>
									</div>

									<div class="am-form-group">
										<div class="am-u-sm-9 am-u-sm-push-3">
											<a class="am-btn am-btn-danger">保存</a>
											<a href="javascript: void(0)" class="am-close am-btn am-btn-danger" data-am-modal-close>取消</a>
										</div>
									</div>
								</form>
							</div>

						</div>

					</div>

				</div>

				<div class="clear"></div>

			</div>
			<!--底部-->
			@include('web.layouts.footer')
		</div>
		<!--左侧菜单-->
		@include('web.layouts.aside')
	</div>

@endsection

@section('assets_foot')
	<script type="text/javascript">
        $(document).ready(function() {

            $(".menu .address").addClass("active");

            $(".new-option-r").click(function() {

                var _that = this;
                var address_id = $(_that).data('id');

                $.ajax({
                    type: 'POST',
                    url: "/address/setDefault?address_id="+address_id,
                    dataType: "json",
                    error:function(){
                        alert('修改失败');
                    },
                    success: function(data){
                        $(_that).parent('.user-addresslist').addClass("defaultAddr").siblings().removeClass("defaultAddr");
                    }
                });

            });

            var $ww = $(window).width();
            if($ww>640) {
                $("#doc-modal-1").removeClass("am-modal am-modal-no-btn")
            }

        })
	</script>

@endsection
