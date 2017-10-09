@extends('web.layouts.person')

@section('assets_head')
	<title>我的收藏</title>
	<link href="/assets/front/css/personal.css" rel="stylesheet" type="text/css">
	<link href="/assets/front/css/colstyle.css" rel="stylesheet" type="text/css">
@endsection

@section('content')

	<div class="center">
		<div class="col-main">
			<div class="main-wrap">

				<div class="user-collection">
					<!--标题 -->
					<div class="am-cf am-padding">
						<div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">我的收藏</strong> / <small>My&nbsp;Collection</small></div>
					</div>
					<hr/>

					<div class="you-like" id="app">
						<div class="s-bar">
							我的收藏
							<a class="am-badge am-badge-danger am-round">降价</a>
							<a class="am-badge am-badge-danger am-round">下架</a>
						</div>
						<div class="s-content" >
							<my-component v-for="item in collections" :collection="item" ></my-component>
						</div>

						<div class="s-more-btn i-load-more-item" data-screen="0"><i class="am-icon-refresh am-icon-fw"></i>更多</div>

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

            $(".menu .collection").addClass("active");

        })
	</script>

	<script src="/assets/front/js/vue.min.js"></script>

	<script type="text/x-template" id="collection-item">
		<div class="s-item-wrap">
			<div class="s-item">
				<div class="s-pic">
					<a href="#" class="s-pic-link">
						<img src="/assets/front/images/0-item_pic.jpg_220x220.jpg" :alt="collection.product_title" :title="collection.product_title" class="s-pic-img s-guess-item-img">
					</a>
				</div>
				<div class="s-info">
					<div class="s-title"><a href="#" :title="collection.product_title">@{{collection.product_title}}</a></div>
					<div class="s-price-box">
						<span class="s-price"><em class="s-price-sign">¥</em><em class="s-value">@{{collection.product_price}}</em></span>
						<span class="s-history-price"><em class="s-price-sign">¥</em><em class="s-value">@{{collection.product_ori_price}}</em></span>
					</div>
					<div class="s-extra-box">
						<span class="s-comment">好评: 98.03%</span>
						<span class="s-sales">月销: 219</span>
					</div>
				</div>
				<div class="s-tp">
					<span class="ui-btn-loading-before">找相似</span>
					<i class="am-icon-shopping-cart"></i>
					<span class="ui-btn-loading-before buy">加入购物车</span>
					<p>
						<a href="javascript:;" class="c-nodo J_delFav_btn">取消收藏</a>
					</p>
				</div>
			</div>
		</div>
    </script>

	<script>

		//全局组件
		Vue.component('my-component', {
			template: '#collection-item',
			props: ['collection'],
		})

		var vm = new Vue({
		    //局部组件
            components: {
            },
			el: "#app",
			data: {
				page: 1,
				limit: 10,
				collections: []
			},
            created: function () {
                console.log('created start...')
            },
            mounted: function () {
                console.log('mounted start...')
                var _this = this;
                $.ajax({
                    type: 'GET',
                    url:"/collection/queryCollection",
					data:{'page': this.page,'limit': this.limit},
                    dataType: "json",
                    success:function(item){
                        console.log(item);
                        if(item.code == 1){
                            if(item.data && item.data.items){
                                _this.collections = item.data.items;
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
