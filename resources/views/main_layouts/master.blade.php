<?php
use Carbon\Carbon;
use App\Models\Category;
//múi giờ
$now = Carbon::now('Asia/Ho_Chi_Minh')->locale('vi');
$categoryFooter  = Category::where('name','!=','Chưa phân loại')->withCount('posts')->orderBy('created_at','DESC')->take(12)->get();

?>

<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>@yield('title')</title>
	<!-- mobile responsive meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="description" content="This is meta description">
	<meta name="author" content="Themefisher">
	<meta name="generator" content="Hugo 0.74.3" />
	<meta name="keywords" content="" />
	<meta name="_token" content="{{ csrf_token()}}" />

	
	<!-- theme meta -->
	<meta name="theme-name" content="reader" />
	
	@include('main_layouts.partials.css')

	
    @yield('custom_css')

</head>
<body class="boxed" data-bg-img="{{ asset('kcnew/frontend/img/bg_website.png') }}">
		
	<header class="header--section header--style-3">
		<!-- Header Topbar Start -->
		@include('main_layouts.partials.header')
		<!-- Header Navbar End -->
	</header>

	<!-- Header Section End -->
	<div id="page" class="wrapper">
	
		<!-- Posts Filter Bar Start -->
		<div class="posts--filter-bar style--3 hidden-xs">
			<div class="container">
				<ul class="nav">
					<li>
						<a href="{{ route('newPost') }}">
							<i class="fa fa-star-o"></i>
							<span>Tin tức mới nhất</span>
						</a>
					</li>
				
					<li>
						<a href="{{ route('hotPost') }}">
							<i class="fa fa-fire"></i>
							<span>Tin nóng</span>
						</a>
					</li>
					<li>
						<a href="{{ route('viewPost') }}">
							<i class="fa fa-eye"></i>
							<span>Xem nhiều nhất</span>
						</a>
					</li>
				</ul>
			</div>
		</div>

		<!-- News Ticker Start -->
		<div class="news--ticker">
			<div class="container">
				<div class="title">
					<h2>Tin mới cập nhật</h2>
				</div>

				<div class="news-updates--list" data-marquee="true">
					<ul class="nav">
						@foreach ($posts_new as $posts_new)
							<li>
								<h3 class="h3"><a href="{{ route('posts.show', $posts_new[0]) }}">{{ $posts_new[0]->title }}</a></h3>
							</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>

		@yield('content')

	</div>
	

	<footer id="colorlib-footer">
		@include('main_layouts.partials.footer')
	</footer>


	<div class="gototop js-top">
		<a href="#" class="js-gotop"><i class="icon-arrow-up2"></i></a>
	</div>
	
	

	@include('main_layouts.partials.js')

	@yield('custom_js')

</body>
</html>

