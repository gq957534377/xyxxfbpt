@extends('home.layouts.index')
@section('content')
    <section id="portfolio">
        <div class="container">
            <div class="center">
                <h2>创业项目分类列表</h2>
                <p class="lead">面对生活的挑战，我将大步向前，安逸的生活怎值得留恋，乌托邦似的安宁只能使我昏昏欲睡，我更向往成功
                向往振奋和激动。舒适的生活，怎能让我出卖自由，怜悯的施舍更买不走人的尊严，我已学会，独立思考，自由的行动，面对世界
                    我要大声的宣布，这是我的杰作！
                </p>
            </div>


            <ul class="portfolio-filter text-center">
                <li><a class="btn btn-default active" href="javascript:;" data-filter="test1">热门推荐</a></li>
                <li><a class="btn btn-default" href="javascript:;" data-filter=".bootstrap">新品上架</a></li>
                <li><a class="btn btn-default" href="javascript:;" data-filter=".html">未来科技</a></li>
                <li><a class="btn btn-default" href="javascript:;" data-filter=".wordpress">健康出行</a></li>
                <li><a class="btn btn-default" href="javascript:;" data-filter=".wordpress">生活美学</a></li>
                <li><a class="btn btn-default" href="javascript:;" data-filter=".wordpress">美食生活</a></li>
                <li><a class="btn btn-default" href="javascript:;" data-filter=".wordpress">流行文化</a></li>
                <li><a class="btn btn-default" href="javascript:;" data-filter=".pro_type1">爱心公益</a></li>
            </ul><!--/#portfolio-filter-->

            <div class="row">
                <div class="portfolio-items">
                    <div class="portfolio-item apps col-xs-12 col-sm-4 col-md-3 pro_type1">
                        <div class="recent-work-wrap">
                            <img class="img-responsive" src="{{url('test.jpg')}}" alt="">
                            <div class="overlay">
                                <div class="recent-work-inner">
                                    <h3><a href="#">这里是标题</a></h3>
                                        <span>性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;质：分红</span><br>
                                    <span>起步资金：10万</span><br>
                                    <span>项目周期：1年</span><br>
                                    <span>介&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;绍：性质分红起步资金10万项目周期1年简介性质分红起步年简介</span>
                                    <a class="preview" href={{url('project/1')}} rel="prettyPhoto"><i class="fa fa-eye"></i> 查看详情</a>
                                </div>
                            </div>
                        </div>
                    </div><!--/.portfolio-item-->

                </div>
            </div>
        </div>
    </section><!--/#portfolio-item-->

@endsection
