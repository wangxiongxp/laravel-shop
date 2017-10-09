@extends('web.layouts.person')

@section('assets_head')
	<title>实名认证</title>
	<link href="/assets/front/css/personal.css" rel="stylesheet" type="text/css">
	<link href="/assets/front/css/stepstyle.css" rel="stylesheet" type="text/css">
@endsection

@section('content')

	<div class="center">
		<div class="col-main">
			<div class="main-wrap">

				<div class="am-cf am-padding">
					<div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">实名认证</strong> / <small>Real&nbsp;authentication</small></div>
				</div>
				<hr/>
				<!--进度条-->
				<div class="m-progress">
					<div class="m-progress-list">
							<span class="step-1 step">
                                <em class="u-progress-stage-bg"></em>
                                <i class="u-stage-icon-inner">1<em class="bg"></em></i>
                                <p class="stage-name">实名认证</p>
                            </span>
						<span class="step-2 step">
                                <em class="u-progress-stage-bg"></em>
                                <i class="u-stage-icon-inner">2<em class="bg"></em></i>
                                <p class="stage-name">完成</p>
                            </span>
						<span class="u-progress-placeholder"></span>
					</div>
					<div class="u-progress-bar total-steps-2">
						<div class="u-progress-bar-inner"></div>
					</div>
				</div>
				<form class="am-form am-form-horizontal">
					<div class="am-form-group bind">
						<label for="user-info" class="am-form-label">账户名</label>
						<div class="am-form-content">
							<span id="user-info">186XXXX0531</span>
						</div>
					</div>
					<div class="am-form-group">
						<label for="user-name" class="am-form-label">真实姓名</label>
						<div class="am-form-content">
							<input type="text" id="user-name" placeholder="请输入您的真实姓名">
						</div>
					</div>
					<div class="am-form-group">
						<label for="user-IDcard" class="am-form-label">身份证号</label>
						<div class="am-form-content">
							<input type="tel" id="user-IDcard" placeholder="请输入您的身份证信息">
						</div>
					</div>
					<div class="info-btn">
						<div class="am-btn am-btn-danger">保存修改</div>
					</div>

				</form>

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

            $(".menu .safety").addClass("active");
 
        })
	</script>

@endsection
