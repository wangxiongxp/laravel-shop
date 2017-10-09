<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">			
		<title>全部分类</title>
		<link href="/assets/front/amazeUI-2.4.2/css/amazeui.css" rel="stylesheet" type="text/css" />
		<link href="/assets/front/basic/css/demo.css" rel="stylesheet" type="text/css" />
		<link href="/assets/front/css/sortstyle.css" rel="stylesheet" type="text/css" />
		<script src="/assets/front/amazeUI-2.4.2/js/jquery.min.js"></script>
	</head>

	<body>

		<!--header-->
		@include('web.layouts.header')
		
		<!--主体-->
		<div id="nav" class="navfull">
			<div class="area clearfix">
				<div class="category-content" id="guide_2" >
					<div class="category">
						<ul class="category-list" id="js_climit_li">
							@foreach($cats as $key=>$cat)
							<li class="appliance js_toggle relative @if($key==0) selected @endif ">
								<div class="category-info">
									<h3 class="category-name b-category-name"><i>
										<img src="/assets/front/images/cake.png"></i>
										<a class="ml-22" title="{{$cat->cat_title}}">{{$cat->cat_title}}</a></h3>
								</div>
								<div class="menu-item menu-in top">
									<div class="area-in">
										<div class="area-bg">
											<div class="menu-srot">

												<div class="brand-side">
												  <dl class="dl-sort"><dt></dt>
													<img src="{{$cat->cat_image}}">
												  </dl>
												</div>

												<div class="sort-side">
													<div class="hd" style="height: 40px;line-height: 40px;text-align: center;">
														<span class="text" >——&nbsp;&nbsp;{{$cat->cat_title}}分类&nbsp;&nbsp;——</span>
													</div>
													<dl class="dl-sort">
														@foreach($cat->sub as $sub)
														<dd>
															<a href="" >
																<div class="cateImgWrapper" >
																	<img src="{{$sub->cat_image}}" alt="" class="cateImg"></div>
																<div class="name" >{{$sub->cat_title}}</div></a>
														</dd>
														@endforeach
													</dl>
												</div>

											</div>
										</div>
									</div>
								</div>
							<b class="arrow"></b>
							</li>
							@endforeach
						</ul>
					</div>
				</div>

			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function() {
				$("li").click(function() {
					$(this).addClass("selected").siblings().removeClass("selected");
			    })
			})
		</script>

		<script type="text/javascript">
            var documentHeight = 0;
            var topPadding = 15;
            $(function() {
                var leftHeight = $(".category-content .category").height();

                $(window).scroll(function() {
                    var contentHeight = $(".category-content .category").height();

                    if(leftHeight >= contentHeight){

					}
                    if ($(window).scrollTop() > offset.top) {
                        var newPosition = ($(window).scrollTop() - offset.top) + topPadding;
                        var maxPosition = documentHeight - (sideBarHeight + 368);
                        if (newPosition > maxPosition) {
                            newPosition = maxPosition;
                        }
                        $("#sidebar").stop().animate({
                            marginTop: newPosition
                        });
                    } else {
                        $("#sidebar").stop().animate({
                            marginTop: 0
                        });
                    };
                });
            });
		</script>

		{{--<script type="text/javascript">--}}
            {{--var documentHeight = 0;--}}
            {{--var topPadding = 15;--}}
            {{--$(function() {--}}
                {{--var offset = $("#sidebar").offset();--}}
                {{--documentHeight = $(document).height();--}}
                {{--$(window).scroll(function() {--}}
                    {{--var sideBarHeight = $("#sidebar").height();--}}
                    {{--if ($(window).scrollTop() > offset.top) {--}}
                        {{--var newPosition = ($(window).scrollTop() - offset.top) + topPadding;--}}
                        {{--var maxPosition = documentHeight - (sideBarHeight + 368);--}}
                        {{--if (newPosition > maxPosition) {--}}
                            {{--newPosition = maxPosition;--}}
                        {{--}--}}
                        {{--$("#sidebar").stop().animate({--}}
                            {{--marginTop: newPosition--}}
                        {{--});--}}
                    {{--} else {--}}
                        {{--$("#sidebar").stop().animate({--}}
                            {{--marginTop: 0--}}
                        {{--});--}}
                    {{--};--}}
                {{--});--}}
            {{--});--}}
		{{--</script>--}}

		<div class="clear"></div>
		<!--引导 -->
		<div class="navCir">
			<li><a href="/"><i class="am-icon-home "></i>首页</a></li>
			<li  class="active"><a href="/category"><i class="am-icon-list"></i>分类</a></li>
			<li><a href="/shopCart"><i class="am-icon-shopping-basket"></i>购物车</a></li>
			<li><a href="/profile"><i class="am-icon-user"></i>我的</a></li>
		</div>
	</body>

</html>