@extends('web.layouts.person')

@section('assets_head')
	<title>我的足迹</title>
	<link href="/assets/front/css/personal.css" rel="stylesheet" type="text/css">
	<link href="/assets/front/css/footstyle.css" rel="stylesheet" type="text/css">
@endsection

@section('content')

	<div class="center">
		<div class="col-main">
			<div class="main-wrap">

				<div class="user-foot">
					<!--标题 -->
					<div class="am-cf am-padding">
						<div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">我的足迹</strong> / <small>Browser&nbsp;History</small></div>
					</div>
					<hr/>

					<!--足迹列表 -->

					<foot-item v-for="item in items" :collection="item" ></foot-item>

					<div class="goods">
						<div class="goods-date" data-date="2015-12-21">
							<s class="line"></s>
						</div>

						<div class="goods-box">
							<div class="goods-pic">
								<div class="goods-pic-box">
									<a class="goods-pic-link" target="_blank" href="#" title="意大利费列罗进口食品巧克力零食24粒  进口巧克力食品">
										<img src="/assets/front/images/TB1_pic.jpg_200x200.jpg" class="goods-img"></a>
								</div>
								<a class="goods-delete" href="javascript:void(0);"><i class="am-icon-trash"></i></a>
								<div class="goods-status goods-status-show"><span class="desc">宝贝已下架</span></div>
							</div>

							<div class="goods-attr">
								<div class="good-title">
									<a class="title" href="#" target="_blank">意大利费列罗进口食品巧克力零食24粒  进口巧克力食品</a>
								</div>
								<div class="goods-price">
										<span class="g_price">
                                        <span>¥</span><strong>71</strong>
										</span>
									<span class="g_price g_price-original">
                                        <span>¥</span><strong>142</strong>
										</span>
								</div>
								<div class="clear"></div>
								<div class="goods-num">
									<div class="match-recom">
										<a href="#" class="match-recom-item">找相似</a>
										<a href="#" class="match-recom-item">找搭配</a>
										<i><em></em><span></span></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="clear"></div>
					<div class="goods">
						<div class="goods-date" data-date="2015-12-17">
							<span><i class="month-lite"></i><i class="day-lite"></i>	<i class="date-desc">一周内</i></span>
							<del class="am-icon-trash"></del>
							<s class="line"></s>
						</div>
						<div class="goods-box">
							<div class="goods-pic">
								<div class="goods-pic-box">
									<a class="goods-pic-link" target="_blank" href="#" title="意大利费列罗进口食品巧克力零食24粒  进口巧克力食品">
										<img src="/assets/front/images/TB1_pic.jpg_200x200.jpg" class="goods-img"></a>
								</div>
								<a class="goods-delete" href="javascript:void(0);"><i class="am-icon-trash"></i></a>
								<div class="goods-status goods-status-show"><span class="desc">宝贝已下架</span></div>
							</div>

							<div class="goods-attr">
								<div class="good-title">
									<a class="title" href="#" target="_blank">意大利费列罗进口食品巧克力零食24粒  进口巧克力食品</a>
								</div>
								<div class="goods-price">
										<span class="g_price">
                                        <span>¥</span><strong>71</strong>
										</span>
									<span class="g_price g_price-original">
                                        <span>¥</span><strong>142</strong>
										</span>
								</div>
								<div class="clear"></div>
								<div class="goods-num">
									<div class="match-recom">
										<a href="#" class="match-recom-item">找相似</a>
										<a href="#" class="match-recom-item">找搭配</a>
										<i><em></em><span></span></i>
									</div>
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

            $(".menu .foot").addClass("active");

        })
	</script>

	<script src="/assets/front/js/vue.min.js"></script>

	<script type="text/x-template" id="foot_item">
		<div class="goods">
			<div class="goods-date" data-date="2015-12-21">
				<s class="line"></s>
			</div>

			<div class="goods-box">
				<div class="goods-pic">
					<div class="goods-pic-box">
						<a class="goods-pic-link" target="_blank" href="#" title="意大利费列罗进口食品巧克力零食24粒  进口巧克力食品">
							<img src="/assets/front/images/TB1_pic.jpg_200x200.jpg" class="goods-img"></a>
					</div>
					<a class="goods-delete" href="javascript:void(0);"><i class="am-icon-trash"></i></a>
					<div class="goods-status goods-status-show"><span class="desc">宝贝已下架</span></div>
				</div>

				<div class="goods-attr">
					<div class="good-title">
						<a class="title" href="#" target="_blank">意大利费列罗进口食品巧克力零食24粒  进口巧克力食品</a>
					</div>
					<div class="goods-price">
										<span class="g_price">
                                        <span>¥</span><strong>71</strong>
										</span>
						<span class="g_price g_price-original">
                                        <span>¥</span><strong>142</strong>
										</span>
					</div>
					<div class="clear"></div>
					<div class="goods-num">
						<div class="match-recom">
							<a href="#" class="match-recom-item">找相似</a>
							<a href="#" class="match-recom-item">找搭配</a>
							<i><em></em><span></span></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</script>

	<script>

        //全局组件
        Vue.component('foot-item', {
            template: '#foot_item',
            props: ['item'],
        })

        var vm = new Vue({
            //局部组件
            components: {
            },
            el: "#app",
            data: {
                page: 1,
                limit: 10,
                items: []
            },
            created: function () {
                console.log('created start...')
            },
            mounted: function () {
                console.log('mounted start...')
                var _this = this;
                $.ajax({
                    type: 'GET',
                    url:"/foot/queryFoot",
                    data:{'page': this.page,'limit': this.limit},
                    dataType: "json",
                    success:function(item){
                        console.log(item);
                        if(item.code == 1){
                            if(item.data && item.data.items){
                                _this.items = item.data.items;
                            }
                        }
                    }
                });
            },
            computed: {

            },
            methods:{

            },
            watch: {

            }
        });


	</script>

@endsection
