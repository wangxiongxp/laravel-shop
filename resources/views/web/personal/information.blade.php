@extends('web.layouts.person')

@section('assets_head')
	<title>个人资料</title>
	<link href="/assets/front/css/personal.css" rel="stylesheet" type="text/css">
	<link href="/assets/front/css/infstyle.css" rel="stylesheet" type="text/css">
@endsection

@section('content')

	<div class="center">
		<div class="col-main">
			<div class="main-wrap">

				<div class="user-info">
					<!--标题 -->
					<div class="am-cf am-padding">
						<div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">个人资料</strong> / <small>Personal&nbsp;information</small></div>
					</div>
					<hr/>

					<!--头像 -->
					<div class="user-infoPic">

						<div class="filePic">
							<input type="file" class="inputPic" allowexts="gif,jpeg,jpg,png,bmp" accept="image/*">
							<img class="am-circle am-img-thumbnail" src="/assets/front/images/getAvatar.do.jpg" alt="" />
						</div>

						<p class="am-form-help">头像</p>

						<div class="info-m">
							<div><b>用户名：<i>小叮当</i></b></div>
							<div class="u-level">
									<span class="rank r2">
							             <s class="vip1"></s><a class="classes" href="#">铜牌会员</a>
						            </span>
							</div>
							<div class="u-safety">
								<a href="/safety">
									账户安全
									<span class="u-profile"><i class="bc_ee0000" style="width: 60px;" width="0">60分</i></span>
								</a>
							</div>
						</div>
					</div>

					<!--个人信息 -->
					<div class="info-main">
						<form id="information-form" method="POST" class="am-form am-form-horizontal">

							<div class="am-form-group">
								<label for="user-name2" class="am-form-label">昵称</label>
								<div class="am-form-content">
									<input type="text" id="account_nick_name" name="account_nick_name" value="{{$userInfo->account_nick_name}}" placeholder="nickname">
								</div>
							</div>

							<div class="am-form-group">
								<label for="user-name" class="am-form-label">姓名</label>
								<div class="am-form-content">
									<input type="text" id="account_real_name" name="account_real_name" value="{{$userInfo->account_real_name}}" placeholder="name">

								</div>
							</div>

							<div class="am-form-group">
								<label class="am-form-label">性别</label>
								<div class="am-form-content sex">
									<label class="am-radio-inline">
										<input type="radio" name="account_sex" value="1" data-am-ucheck> 男
									</label>
									<label class="am-radio-inline">
										<input type="radio" name="account_sex" value="2" data-am-ucheck> 女
									</label>
									<label class="am-radio-inline">
										<input type="radio" name="account_sex" value="0" data-am-ucheck> 保密
									</label>
								</div>
							</div>

							<div class="am-form-group">
								<label for="user-birth" class="am-form-label">生日</label>
								<div class="am-form-content birth">
									<div class="birth-select">
										<select data-am-selected>
											<option value="a">2015</option>
											<option value="b">1987</option>
										</select>
										<em>年</em>
									</div>
									<div class="birth-select2">
										<select data-am-selected>
											<option value="a">12</option>
											<option value="b">8</option>
										</select>
										<em>月</em></div>
									<div class="birth-select2">
										<select data-am-selected>
											<option value="a">21</option>
											<option value="b">23</option>
										</select>
										<em>日</em></div>
								</div>

							</div>
							<div class="am-form-group">
								<label for="user-phone" class="am-form-label">电话</label>
								<div class="am-form-content">
									<input id="account_tel" name="account_tel" value="{{$userInfo->account_tel}}" placeholder="telephone" type="tel">
								</div>
							</div>
							<div class="am-form-group">
								<label for="user-email" class="am-form-label">电子邮件</label>
								<div class="am-form-content">
									<input id="account_email" name="account_email" value="{{$userInfo->account_email}}" placeholder="Email" type="email">
								</div>
							</div>
							<div class="am-form-group address">
								<label for="user-address" class="am-form-label">收货地址</label>
								<div class="am-form-content address">
									<a href="/address">
										<p class="new-mu_l2cw">
											<span class="province">湖北</span>省
											<span class="city">武汉</span>市
											<span class="dist">洪山</span>区
											<span class="street">雄楚大道666号(中南财经政法大学)</span>
											<span class="am-icon-angle-right"></span>
										</p>
									</a>

								</div>
							</div>
							<div class="am-form-group safety">
								<label for="user-safety" class="am-form-label">账号安全</label>
								<div class="am-form-content safety">
									<a href="/safety">
										<span class="am-icon-angle-right"></span>
									</a>

								</div>
							</div>
							<div class="info-btn">
								<div class="am-btn am-btn-danger" onclick="saveInformation()">保存修改</div>
							</div>

						</form>
					</div>

				</div>

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

            $(".menu .information").addClass("active");

            SetRadioSelected("account_sex",'{{$userInfo->account_sex}}');

            var options = {
                dataType:  'json',
                beforeSubmit:  function() {
                    return true;
                },
                success: function(responseText){
                    if(responseText){
                        if(responseText.code == 1) {
                            location.href = location.href;
                        }else{
                            alert('保存失败');
                        }
                    }
                }
            };
            $('#information-form').ajaxForm(options);

        })

		function saveInformation(){
			$("#information-form").attr("action","/information/update");
            $("#information-form").submit();
		}

	</script>
@endsection
