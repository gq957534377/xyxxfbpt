@extends('home.layouts.index')
@section('content')
    <section id="about-us">
        <div class="container">
			<div class="center wow fadeInDown">
				<h2>英雄会众筹</h2>
				<p class="lead">英雄会金融综合互联网理财服务,基金理财,金融服务,敬请享受!</p>
			</div>
			
			<!-- about us slider -->
			<div id="about-slider">
				<div id="carousel-slider" class="carousel slide" data-ride="carousel">
					<!-- Indicators -->
				  	<ol class="carousel-indicators visible-xs">
					    <li data-target="#carousel-slider" data-slide-to="0" class="active"></li>
					    <li data-target="#carousel-slider" data-slide-to="1"></li>
						<li data-target="#carousel-slider" data-slide-to="2"></li>
						<li data-target="#carousel-slider" data-slide-to="3"></li>
				  	</ol>

					<div class="carousel-inner">
						<div class="item active">
							<a href="#" style="position: absolute;display: block;height: 100%;width: 100%;">1</a>
							<img src="{{asset('home/images/slider_one.jpg')}}" class="img-responsive" alt="">
					   </div>
						<div class="item">
							<a href="#" style="position: absolute;display: block;height: 100%;width: 100%;">2</a>
							<img src="{{asset('home/images/slider_one.jpg')}}" class="img-responsive" alt="">
						</div>
						<div class="item">
							<a href="#" style="position: absolute;display: block;height: 100%;width: 100%;">3</a>
							<img src="{{asset('home/images/slider_one.jpg')}}" class="img-responsive" alt="">
						</div>
						<div class="item">
							<a href="#" style="position: absolute;display: block;height: 100%;width: 100%;">4</a>
							<img src="{{asset('home/images/slider_one.jpg')}}" class="img-responsive" alt="">
						</div>
					</div>
					<a class="left carousel-control hidden-xs" href="#carousel-slider" data-slide="prev">
						<i class="fa fa-angle-left"></i> 
					</a>
					
					<a class=" right carousel-control hidden-xs"href="#carousel-slider" data-slide="next">
						<i class="fa fa-angle-right"></i> 
					</a>
				</div> <!--/#carousel-slider-->
			</div><!--/#about-slider-->
			
			
			<!-- Our Skill -->
			<div class="skill-wrap clearfix">
			
				<div class="center wow fadeInDown">
					<h2>我们的业绩</h2>
					<p class="lead">自英雄会成立我们的成就如下</p>
				</div>
				
				<div class="row">
				<center>
					<div class="col-sm-4">
						<div class="sinlge-skill wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
							<div style="width: 100%;height: 100%;padding: 70px 0;text-align: center;background: red;">
								<p><em id="totalAmount"></em></p>
								<p>累计支持金额(￥)</p>
							</div>
						</div>
					</div>
					
					 <div class="col-sm-4">
						<div class="sinlge-skill wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
							<div style="width: 100%;height: 100%;padding: 70px 0;text-align: center;background: #6AA42F;">
								<p><em id="maxGold"></em></p>
								<p>单项最高筹集金额(￥)</p>
							</div>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="sinlge-skill wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="900ms">
							<div style="width: 100%;height: 100%;padding: 70px 0;text-align: center;background: #FFBD20;">
								<p><em id="maxPeoples"></em></p>
								<p>单项最高支持人数(人)</p>
							</div>
						</div>
					</div>
					</center>
				</div>

            </div><!--/.our-skill-->
			

			<!-- our-team -->
			<div class="team">
				<div class="center wow fadeInDown">
					<h2>众筹项目分类</h2>
					<p class="lead">这里有许多优秀的项目快来看看吧！O(∩_∩)O哈哈哈~</p>
				</div>
			</div><!--section-->

		</div><!--/.container-->

    </section><!--/about-us-->
	<section id="portfolio">
		<div class="container">
			<div class="row wow fadeInUpBig">
				<div class="portfolio-items">
					<div class="portfolio-item apps col-xs-12 col-sm-4 col-md-3">
						<div class="recent-work-wrap">
							<img class="img-responsive" src="{{asset('home/images/portfolio/full/item1.png')}}" alt="">
							<div class="overlay">
								<div class="recent-work-inner">
									<h3><a href="{{url('crowd_funding/0')}}">热门推荐</a></h3>
									<p>There are many variations of passages of Lorem Ipsum available, but the majority</p>
									<a class="preview" href="{{url('crowd_funding/0')}}"><i class="fa fa-eye"></i> 查看</a>
								</div>
							</div>
						</div>
					</div><!--/.portfolio-item-->

					<div class="portfolio-item joomla bootstrap col-xs-12 col-sm-4 col-md-3">
						<div class="recent-work-wrap">
							<img class="img-responsive" src="{{asset('home/images/portfolio/recent/item2.png')}}" alt="">
							<div class="overlay">
								<div class="recent-work-inner">
									<h3><a href="{{url('crowd_funding/1')}}">最新上架</a></h3>
									<p>There are many variations of passages of Lorem Ipsum available, but the majority</p>
									<a class="preview" href="{{url('crowd_funding/1')}}" ><i class="fa fa-eye"></i> 查看</a>
								</div>
							</div>
						</div>
					</div><!--/.portfolio-item-->

					<div class="portfolio-item bootstrap wordpress col-xs-12 col-sm-4 col-md-3">
						<div class="recent-work-wrap">
							<img class="img-responsive" src="{{asset('home/images/portfolio/recent/item3.png')}}" alt="">
							<div class="overlay">
								<div class="recent-work-inner">
									<h3><a href="{{url('crowd_funding/2')}}">未来科技</a></h3>
									<p>There are many variations of passages of Lorem Ipsum available, but the majority</p>
									<a class="preview" href="{{url('crowd_funding/2')}}" ><i class="fa fa-eye"></i> 查看</a>
								</div>
							</div>
						</div>
					</div><!--/.portfolio-item-->

					<div class="portfolio-item joomla wordpress apps col-xs-12 col-sm-4 col-md-3">
						<div class="recent-work-wrap">
							<img class="img-responsive" src="{{asset('home/images/portfolio/recent/item4.png')}}" alt="">
							<div class="overlay">
								<div class="recent-work-inner">
									<h3><a href="{{url('crowd_funding/3')}}">健康出行</a></h3>
									<p>There are many variations of passages of Lorem Ipsum available, but the majority</p>
									<a class="preview" href="{{url('crowd_funding/3')}}" ><i class="fa fa-eye"></i> 查看</a>
								</div>
							</div>
						</div>
					</div><!--/.portfolio-item-->

					<div class="portfolio-item joomla html bootstrap col-xs-12 col-sm-4 col-md-3">
						<div class="recent-work-wrap">
							<img class="img-responsive" src="{{asset('home/images/portfolio/recent/item5.png')}}" alt="">
							<div class="overlay">
								<div class="recent-work-inner">
									<h3><a href="{{url('crowd_funding/4')}}">生活美学</a></h3>
									<p>There are many variations of passages of Lorem Ipsum available, but the majority</p>
									<a class="preview" href="{{url('crowd_funding/4')}}" ><i class="fa fa-eye"></i> 查看</a>
								</div>
							</div>
						</div>
					</div><!--/.portfolio-item-->

					<div class="portfolio-item wordpress html apps col-xs-12 col-sm-4 col-md-3">
						<div class="recent-work-wrap">
							<img class="img-responsive" src="{{asset('home/images/portfolio/recent/item6.png')}}" alt="">
							<div class="overlay">
								<div class="recent-work-inner">
									<h3><a href="{{url('crowd_funding/5')}}">美食生活</a></h3>
									<p>There are many variations of passages of Lorem Ipsum available, but the majority</p>
									<a class="preview" href="{{url('crowd_funding/5')}}" ><i class="fa fa-eye"></i> 查看</a>
								</div>
							</div>
						</div>
					</div><!--/.portfolio-item-->

					<div class="portfolio-item wordpress html col-xs-12 col-sm-4 col-md-3">
						<div class="recent-work-wrap">
							<img class="img-responsive" src="{{asset('home/images/portfolio/recent/item7.png')}}" alt="">
							<div class="overlay">
								<div class="recent-work-inner">
									<h3><a href="{{url('crowd_funding/6')}}">流行文化</a></h3>
									<p>There are many variations of passages of Lorem Ipsum available, but the majority</p>
									<a class="preview" href="{{url('crowd_funding/6')}}" ><i class="fa fa-eye"></i> 查看</a>
								</div>
							</div>
						</div>
					</div><!--/.portfolio-item-->

					<div class="portfolio-item wordpress html bootstrap col-xs-12 col-sm-4 col-md-3">
						<div class="recent-work-wrap">
							<img class="img-responsive" src="{{asset('home/images/portfolio/recent/item8.png')}}" alt="">
							<div class="overlay">
								<div class="recent-work-inner">
									<h3><a href="{{url('crowd_funding/7')}}">爱心公益</a></h3>
									<p>There are many variations of passages of Lorem Ipsum available, but the majority</p>
									<a class="preview" href="{{url('crowd_funding/7')}}" ><i class="fa fa-eye"></i> 查看</a>
								</div>
							</div>
						</div>
					</div><!--/.portfolio-item-->
				</div>
			</div>
		</div>
	</section>

@endsection

@section('script')
	@include('home.crowdfunding.publicClass')
	@include('home.crowdfunding.indexScript')
@endsection