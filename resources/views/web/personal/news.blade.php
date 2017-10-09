@extends('web.layouts.person')

@section('assets_head')
	<title>我的消息</title>
	<link href="/assets/front/css/personal.css" rel="stylesheet" type="text/css">
	<link href="/assets/front/css/newstyle.css" rel="stylesheet" type="text/css">
@endsection

@section('content')

	<div class="center">
		<div class="col-main">
			<div class="main-wrap">

				<div class="user-news">

					<!--标题 -->
					<div class="am-cf am-padding">
						<div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">我的消息</strong> / <small>News</small></div>
					</div>
					<hr/>

					<div class="am-tabs am-tabs-d2" data-am-tabs>
						<ul class="am-avg-sm-3 am-tabs-nav am-nav am-nav-tabs">
							<li class="am-active"><a href="#tab1">商城活动</a></li>
							<li><a href="#tab2">物流助手</a></li>
							<li><a href="#tab3">交易信息</a></li>

						</ul>

						<div class="am-tabs-bd">
							<div class="am-tab-panel am-fade am-in am-active" id="tab1">

								<div class="news-day">
									<div class="goods-date" data-date="2015-12-21">
										<span><i class="month-lite">12</i>.<i class="day-lite">21</i>	<i class="date-desc">今天</i></span>
									</div>

									<!--消息 -->
									<div class="s-msg-item s-msg-temp i-msg-downup">
										<h6 class="s-msg-bar"><span class="s-name">每日新鲜事</span></h6>
										<div class="s-msg-content i-msg-downup-wrap">
											<div class="i-msg-downup-con">
												<a class="i-markRead" target="_blank" href="/blog">
													<img src="/assets/front/images/TB102.jpg">
													<p class="s-main-content">
														最特色的湖北年货都在这儿 ~快来囤年货啦！
													</p>
													<p class="s-row s-main-content">
														<a href="/blog">
															阅读全文 <i class="am-icon-angle-right"></i>
														</a>
													</p>
												</a>
											</div>
										</div>
										<a class="i-btn-forkout" href="#"><i class="am-icon-close am-icon-fw"></i></a>
									</div>
								</div>
							</div>

							<div class="am-tab-panel am-fade" id="tab2">
								<!--消息 -->
								<div class="s-msg-item s-msg-temp i-msg-downup">
									<h6 class="s-msg-bar"><span class="s-name">订单已签收</span></h6>
									<div class="s-msg-content i-msg-downup-wrap">
										<div class="i-msg-downup-con">
											<a class="i-markRead" target="_blank" href="/logistics">
												<div class="m-item">
													<div class="item-pic">
														<img src="/assets/front/images/kouhong.jpg_80x80.jpg" class="itempic J_ItemImg">
													</div>
													<div class="item-info">
														您购买的美康粉黛醉美唇膏已签收，
														快递单号:373269427868
													</div>

												</div>

												<p class="s-row s-main-content">
													查看详情 <i class="am-icon-angle-right"></i>
												</p>
											</a>
										</div>
									</div>
									<a class="i-btn-forkout" href="#"><i class="am-icon-close am-icon-fw"></i></a>
								</div>
							</div>

							<div class="am-tab-panel am-fade" id="tab3">
								<!--消息 -->
								<div class="s-msg-item s-msg-temp i-msg-downup">
									<h6 class="s-msg-bar"><span class="s-name">卖家已退款&nbsp;¥12.90元</span></h6>
									<div class="s-msg-content i-msg-downup-wrap">
										<div class="i-msg-downup-con">
											<a class="i-markRead" target="_blank" href="/record">
												<div class="m-item">
													<div class="item-pic">
														<img src="/assets/front/images/kouhong.jpg_80x80.jpg" class="itempic J_ItemImg">
													</div>
													<div class="item-info">
														<p class="item-comment">您购买的美康粉黛醉美唇膏卖家已退款</p>
														<p class="item-time">2015-12-21&nbsp;17:38:29</p>
													</div>

												</div>

												<p class="s-row s-main-content">
													<a href="/record">钱款去向</a> <i class="am-icon-angle-right"></i>
												</p>
											</a>
										</div>
									</div>
									<a class="i-btn-forkout" href="#"><i class="am-icon-close am-icon-fw"></i></a>
								</div>
							</div>
						</div>
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

            $(".menu .news").addClass("active");

        })
	</script>

@endsection
