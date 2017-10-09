<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<title>搜索页面</title>

	<link href="/assets/front/amazeUI-2.4.2/css/amazeui.css" rel="stylesheet" type="text/css" />
	<link href="/assets/front/amazeUI-2.4.2/css/admin.css" rel="stylesheet" type="text/css" />

	<link href="/assets/front/basic/css/demo.css" rel="stylesheet" type="text/css" />

	<link href="/assets/front/css/seastyle.css" rel="stylesheet" type="text/css" />

	<script type="text/javascript" src="/assets/front/basic/js/jquery-1.7.min.js"></script>
	<script type="text/javascript" src="/assets/front/js/script.js"></script>
</head>

<body>

<!--顶部导航条 -->
<div class="am-container header">
	<ul class="message-l">
		<div class="topMessage">
			<div class="menu-hd">
				<a href="#" target="_top" class="h">亲，请登录</a>
				<a href="#" target="_top">免费注册</a>
			</div>
		</div>
	</ul>
	<ul class="message-r">
		<div class="topMessage home">
			<div class="menu-hd"><a href="#" target="_top" class="h">商城首页</a></div>
		</div>
		<div class="topMessage my-shangcheng">
			<div class="menu-hd MyShangcheng"><a href="#" target="_top"><i class="am-icon-user am-icon-fw"></i>个人中心</a></div>
		</div>
		<div class="topMessage mini-cart">
			<div class="menu-hd"><a id="mc-menu-hd" href="#" target="_top"><i class="am-icon-shopping-cart  am-icon-fw"></i><span>购物车</span><strong id="J_MiniCartNum" class="h">0</strong></a></div>
		</div>
		<div class="topMessage favorite">
			<div class="menu-hd"><a href="#" target="_top"><i class="am-icon-heart am-icon-fw"></i><span>收藏夹</span></a></div>
		</div>
	</ul>
</div>


{{--start--}}
<div style="height: 47px;" >
	<div class="m-hd" style="position: fixed;left:0;top:0;width:100%;z-index:5">
		<div class="m-topBar" style="position: relative">
			<div class="bd" style="height: 47px;background-color: #fafafa;position:relative">
				<div class="row" style="padding:0 15px;height:47px;align-items: center;display: flex;overflow: hidden;justify-content: space-between;position: relative;">
					<div class="m-hamburger toggle" ><i class="am-icon-md am-icon-bars"></i></div>
					<a href="/" style="font-size:18px;padding-left:20px;"><i class="logo u-icon u-icon-logo" ></i>网易严选</a>
					<div class="right" >
						<a class="search" href="/search" style="margin-right: 8px;"><i class="am-icon-sm am-icon-search" ></i></a>
						<a class="cart" href="/cart" ><i class="am-icon-sm am-icon-shopping-cart" ></i></a>
					</div>
				</div>
				<div class="menu menu-isHidden" >
					<ul class="list" >
						<li class="item" ><a href="/" ><i class="am-icon-sm am-icon-home" ></i><span class="txt" >首页</span></a></li>
						<li class="item" ><a href="/topic/list" ><i class="am-icon-sm am-icon-coffee" ></i><span class="txt" >专题</span></a></li>
						<li class="item" ><a href="/item/cateList" ><i class="am-icon-sm am-icon-cubes" ></i><span class="txt" >分类</span></a></li>
						<li class="item" ><a href="/ucenter" ><i class="am-icon-sm am-icon-user" ></i><span class="txt" >个人</span></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div >
	<div style="position: fixed; left: 0px; height: 36px;width: 100%; top: 47px; z-index: 4;background-color:#fff;border-top:1px solid #e8e8e8;border-bottom:1px solid #e8e8e8" >
		<div class="m-tabs scroll" >
			<div class="inner" style="position:relative;height:100%;width:100%;overflow:hidden;" >
				{{--<div class="list" style="transition-timing-function: cubic-bezier(0.1, 0.57, 0.1, 1); transition-duration: 0ms; transform: translate(0px, 0px) translateZ(0px);">--}}
				<div class="list" style="overflow-x: scroll;display: flex;flex-flow: row nowrap;padding: 0 10px;">
					<div class="tab active" ><span class="txt" >夏凉</span></div>
					<div class="tab" ><span class="txt" >被枕</span></div>
					<div class="tab" ><span class="txt" >床品件套</span></div>
					<div class="tab" ><span class="txt" >布艺软装</span></div>
					<div class="tab" ><span class="txt" >家具</span></div>
					<div class="tab" ><span class="txt" >灯具</span></div>
					<div class="tab" ><span class="txt" >家饰</span></div>
					<div class="tab" ><span class="txt" >宠物</span></div>
				</div>
			</div>
		</div>
	</div>
</div>
{{--end--}}

<style>
	.m-topBar .menu{
		position: absolute;
		z-index: 0;
		left: 0;
		width: 100%;
		padding: 8px 0;
		background-color: #fafafa;
		border-top: 1px solid #e8e8e8;
		border-bottom: 1px solid #e8e8e8;
		text-align: center;
	}
	.m-topBar .menu .list {
		display: inline-block;
		vertical-align: middle;
		overflow: hidden;
		width:80%;
	}
	.m-topBar .menu .list .item {
		float: left;
		text-align: center;
		width:25%;
	}
	.m-topBar .menu .list .item a {
		width:100%;
	}
	.m-topBar .menu .list .item .txt {
		display: block;
		font-size: 12px;
		padding-top:2px;
		color: #666;
		line-height: 1;
		background: none;
		width:auto
	}
	.m-tabs .tab {
		flex-shrink: 0;
		display: flex;
		flex-flow: row nowrap;
		align-items: center;
		flex-flow: row nowrap;
		justify-content: center;
		padding:0 10px;
	}
	.m-tabs .tab .txt {
		display: inline-block;
		padding: 0 5px;
		line-height: 36px;
		font-size: 15px;
		color: #333;
		text-align: center;
	}
</style>










<!--悬浮搜索框-->
{{--<div class="nav white">--}}
{{--<div class="logo"><img src="/assets/front/images/logo.png" /></div>--}}
{{--<div class="logoBig">--}}
{{--<li><img src="/assets/front/images/logobig.png" /></li>--}}
{{--</div>--}}

{{--<div class="search-bar pr">--}}
{{--<a name="index_none_header_sysc" href="#"></a>--}}
{{--<form>--}}
{{--<input id="searchInput" name="index_none_header_sysc" type="text" placeholder="搜索" autocomplete="off">--}}
{{--<input id="ai-topsearch" class="submit am-btn"  value="搜索" index="1" type="submit">--}}
{{--</form>--}}
{{--</div>--}}
{{--</div>--}}

<div class="clear"></div>
<b class="line"></b>
<div class="search">
	<div class="search-list">
		<div class="nav-table">
			<div class="long-title"><span class="all-goods">全部分类</span></div>
			<div class="nav-cont">
				<ul>
					<li class="index"><a href="#">首页</a></li>
					<li class="qc"><a href="#">闪购</a></li>
					<li class="qc"><a href="#">限时抢</a></li>
					<li class="qc"><a href="#">团购</a></li>
					<li class="qc last"><a href="#">大包装</a></li>
				</ul>
				<div class="nav-extra">
					<i class="am-icon-user-secret am-icon-md nav-user"></i><b></b>我的福利
					<i class="am-icon-angle-right" style="padding-left: 10px;"></i>
				</div>
			</div>
		</div>


		<div class="am-g am-g-fixed">
			<div class="am-u-sm-12 am-u-md-12">
				<div class="theme-popover">
					<div class="searchAbout">
						<span class="font-pale">相关搜索：</span>
						<a title="坚果" href="#">坚果</a>
						<a title="瓜子" href="#">瓜子</a>
						<a title="鸡腿" href="#">豆干</a>

					</div>
					<ul class="select">
						<p class="title font-normal">
							<span class="fl">松子</span>
							<span class="total fl">搜索到<strong class="num">997</strong>件相关商品</span>
						</p>
						<div class="clear"></div>
						<li class="select-result">
							<dl>
								<dt>已选</dt>
								<dd class="select-no"></dd>
								<p class="eliminateCriteria">清除</p>
							</dl>
						</li>
						<div class="clear"></div>
						<li class="select-list">
							<dl id="select1">
								<dt class="am-badge am-round">品牌</dt>

								<div class="dd-conent">
									<dd class="select-all selected"><a href="#">全部</a></dd>
									<dd><a href="#">百草味</a></dd>
									<dd><a href="#">良品铺子</a></dd>
									<dd><a href="#">新农哥</a></dd>
									<dd><a href="#">楼兰蜜语</a></dd>
									<dd><a href="#">口水娃</a></dd>
									<dd><a href="#">考拉兄弟</a></dd>
								</div>

							</dl>
						</li>
						<li class="select-list">
							<dl id="select2">
								<dt class="am-badge am-round">种类</dt>
								<div class="dd-conent">
									<dd class="select-all selected"><a href="#">全部</a></dd>
									<dd><a href="#">东北松子</a></dd>
									<dd><a href="#">巴西松子</a></dd>
									<dd><a href="#">夏威夷果</a></dd>
									<dd><a href="#">松子</a></dd>
								</div>
							</dl>
						</li>
						<li class="select-list">
							<dl id="select3">
								<dt class="am-badge am-round">选购热点</dt>
								<div class="dd-conent">
									<dd class="select-all selected"><a href="#">全部</a></dd>
									<dd><a href="#">手剥松子</a></dd>
									<dd><a href="#">薄壳松子</a></dd>
									<dd><a href="#">进口零食</a></dd>
									<dd><a href="#">有机零食</a></dd>
								</div>
							</dl>
						</li>

					</ul>
					<div class="clear"></div>
				</div>
				<div class="search-content">
					<div class="sort">
						<li class="first"><a title="综合">综合排序</a></li>
						<li><a title="销量">销量排序</a></li>
						<li><a title="价格">价格优先</a></li>
						<li class="big"><a title="评价" href="#">评价为主</a></li>
					</div>
					<div class="clear"></div>

					<ul class="am-avg-sm-2 am-avg-md-3 am-avg-lg-4 boxes">
						@for ($i = 0; $i < 12; $i++)
							<li>
								<div class="i-pic limit">
									<img src="/assets/front/images/imgsearch1.jpg" />
									<p class="title fl">【良品铺子旗舰店】手剥松子218g 坚果炒货零食新货巴西松子包邮</p>
									<p class="price fl">
										<b>¥</b>
										<strong>56.90</strong>
									</p>
									<p class="number fl">
										销量<span>1110</span>
									</p>
								</div>
							</li>
						@endfor
					</ul>
				</div>
				<div class="search-side">

					<div class="side-title">
						经典搭配
					</div>

					<li>
						<div class="i-pic check">
							<img src="/assets/front/images/cp.jpg" />
							<p class="check-title">萨拉米 1+1小鸡腿</p>
							<p class="price fl">
								<b>¥</b>
								<strong>29.90</strong>
							</p>
							<p class="number fl">
								销量<span>1110</span>
							</p>
						</div>
					</li>
					<li>
						<div class="i-pic check">
							<img src="/assets/front/images/cp2.jpg" />
							<p class="check-title">ZEK 原味海苔</p>
							<p class="price fl">
								<b>¥</b>
								<strong>8.90</strong>
							</p>
							<p class="number fl">
								销量<span>1110</span>
							</p>
						</div>
					</li>
					<li>
						<div class="i-pic check">
							<img src="/assets/front/images/cp.jpg" />
							<p class="check-title">萨拉米 1+1小鸡腿</p>
							<p class="price fl">
								<b>¥</b>
								<strong>29.90</strong>
							</p>
							<p class="number fl">
								销量<span>1110</span>
							</p>
						</div>
					</li>

				</div>
				<div class="clear"></div>
				<!--分页 -->
				<ul class="am-pagination am-pagination-right">
					<li class="am-disabled"><a href="#">&laquo;</a></li>
					<li class="am-active"><a href="#">1</a></li>
					<li><a href="#">2</a></li>
					<li><a href="#">3</a></li>
					<li><a href="#">4</a></li>
					<li><a href="#">5</a></li>
					<li><a href="#">&raquo;</a></li>
				</ul>

			</div>
		</div>
		<!--footer-->
		@include('web.layouts.footer')

	</div>

</div>

<!--引导 -->
<div class="navCir">
	<li><a href="/"><i class="am-icon-home "></i>首页</a></li>
	<li><a href="/category"><i class="am-icon-list"></i>分类</a></li>
	<li><a href="/shopCart"><i class="am-icon-shopping-basket"></i>购物车</a></li>
	<li><a href="/profile"><i class="am-icon-user"></i>我的</a></li>
</div>

<!--菜单 -->
@include('web.layouts.sidebar')

<script>
    window.jQuery || document.write('<script src="/assets/front/basic/js/jquery-1.9.min.js"><\/script>');
</script>
<script type="text/javascript" src="/assets/front/basic/js/quick_links.js"></script>

<div class="theme-popover-mask"></div>

</body>

</html>