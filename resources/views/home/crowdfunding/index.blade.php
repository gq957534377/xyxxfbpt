<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>About Us</title>
	
	<!-- core CSS -->
    <link href="{{asset('home/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('home/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('home/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('home/css/animate.min.css')}}" rel="stylesheet">
	<link href="{{asset('home/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('home/css/responsive.css')}}" rel="stylesheet">
	
    <!--[if lt IE 9]>
    <script src="{{asset('home/js/html5shiv.js')}}"></script>
    <script src="{{asset('home/js/respond.min.js')}}"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="{{asset('home/images/ico/favicon.ico')}}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('home/images/ico/apple-touch-icon-144-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{asset('home/images/ico/apple-touch-icon-114-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{asset('home/images/ico/apple-touch-icon-72-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{asset('home/images/ico/apple-touch-icon-57-precomposed.png')}}">
</head><!--/head-->

<body>

    <header id="header">
        <div class="top-bar">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-xs-4">
                        <div class="top-number"><p><i class="fa fa-phone-square"></i>  +0123 456 70 90</p></div>
                    </div>
                    <div class="col-sm-6 col-xs-8">
                       <div class="social">
                            <ul class="social-share">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li> 
                                <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                                <li><a href="#"><i class="fa fa-skype"></i></a></li>
                            </ul>
                            <div class="search">
                                <form role="form">
                                    <input type="text" class="search-form" autocomplete="off" placeholder="Search">
                                    <i class="fa fa-search"></i>
                                </form>
                           </div>
                       </div>
                    </div>
                </div>
            </div><!--/.container-->
        </div><!--/.top-bar-->

        <nav class="navbar navbar-inverse" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{url("/")}}"><img src="images/logo.png" alt="logo"></a>
                </div>
				
                <div class="collapse navbar-collapse navbar-right">
                    <ul class="nav navbar-nav">
                        <li><a href="{{url("/")}}">Home</a></li>
                        <li class="active"><a href="crowd_funding">英雄众筹</a></li>
                        <li><a href="services.html">Services</a></li>
                        <li><a href="portfolio.html">Portfolio</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pages <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="blog-item.html">Blog Single</a></li>
                                <li><a href="pricing.html">Pricing</a></li>
                                <li><a href="404.html">404</a></li>
                                <li><a href="shortcodes.html">Shortcodes</a></li>
                            </ul>
                        </li>
                        <li><a href="blog.html">Blog</a></li> 
                        <li><a href="contact-us.html">Contact</a></li>                        
                    </ul>
                </div>
            </div><!--/.container-->
        </nav><!--/nav-->
	</header><!--/header-->

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
								<p><em>{{$totalAmount}}</em></p>
								<p>累计支持金额(￥)</p>
							</div>
						</div>
					</div>
					
					 <div class="col-sm-4">
						<div class="sinlge-skill wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
							<div style="width: 100%;height: 100%;padding: 70px 0;text-align: center;background: #6AA42F;">
								<p><em>{{$maxGold}}</em></p>
								<p>单项最高筹集金额(￥)</p>
							</div>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="sinlge-skill wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="900ms">
							<div style="width: 100%;height: 100%;padding: 70px 0;text-align: center;background: #FFBD20;">
								<p><em>{{$maxPeoples}}</em></p>
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
    <section id="bottom">
        <div class="container wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        <h3>Company</h3>
                        <ul>
                            <li><a href="#">About us</a></li>
                            <li><a href="#">We are hiring</a></li>
                            <li><a href="#">Meet the team</a></li>
                            <li><a href="#">Copyright</a></li>
                            <li><a href="#">Terms of use</a></li>
                            <li><a href="#">Privacy policy</a></li>
                            <li><a href="#">Contact us</a></li>
                        </ul>
                    </div>    
                </div><!--/.col-md-3-->

                <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        <h3>Support</h3>
                        <ul>
                            <li><a href="#">Faq</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Forum</a></li>
                            <li><a href="#">Documentation</a></li>
                            <li><a href="#">Refund policy</a></li>
                            <li><a href="#">Ticket system</a></li>
                            <li><a href="#">Billing system</a></li>
                        </ul>
                    </div>    
                </div><!--/.col-md-3-->

                <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        <h3>Developers</h3>
                        <ul>
                            <li><a href="#">Web Development</a></li>
                            <li><a href="#">SEO Marketing</a></li>
                            <li><a href="#">Theme</a></li>
                            <li><a href="#">Development</a></li>
                            <li><a href="#">Email Marketing</a></li>
                            <li><a href="#">Plugin Development</a></li>
                            <li><a href="#">Article Writing</a></li>
                        </ul>
                    </div>    
                </div><!--/.col-md-3-->

                <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        <h3>Our Partners</h3>
                        <ul>
                            <li><a href="#">Adipisicing Elit</a></li>
                            <li><a href="#">Eiusmod</a></li>
                            <li><a href="#">Tempor</a></li>
                            <li><a href="#">Veniam</a></li>
                            <li><a href="#">Exercitation</a></li>
                            <li><a href="#">Ullamco</a></li>
                            <li><a href="#">Laboris</a></li>
                        </ul>
                    </div>    
                </div><!--/.col-md-3-->
            </div>
        </div>
    </section><!--/#bottom-->

    <footer id="footer" class="midnight-blue">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    Copyright &copy; 2015.Company name All rights reserved.
                </div>
                <div class="col-sm-6">
                    <ul class="pull-right">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Faq</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer><!--/#footer-->
    

    <script src="http://apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="{{asset('home/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('home/js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('home/js/jquery.isotope.min.js')}}"></script>
    <script src="{{asset('home/js/main.js')}}"></script>
    <script src="{{asset('home/js/wow.min.js')}}"></script>
</body>
</html>