<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>琦立英雄会--首页</title>
    <script type="text/javascript" src="{{ asset('heroHome/js/jquery-3.1.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('heroHome/js/index.js') }}"></script>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('heroHome/css/top.css') }}" rel="stylesheet">
    <link href="{{ asset('heroHome/css/footer.css') }}" rel="stylesheet">
    <link href="{{ asset('heroHome/css/common.css') }}" rel="stylesheet"/>
    <link href="{{ asset('heroHome/css/bottom.css') }}" rel="stylesheet">
    <link href="{{ asset('heroHome/css/index(pc).css') }}" rel="stylesheet" >
</head>
<body>
<header class="container-fluid navbar-fixed-top">
    <div class="container">
        <div class="row change-row-margin">
            <div class="top-left">
                <a href="#"><img class="img-responsive" src="{{ asset('heroHome/img/logo.jpg') }}"></a>
            </div>
            @if(!empty(session('user')))
                <div class="top-right">
                    <a href="#"><img class="img-circle" src="{{ session('user')->headpic }}"></a>
                    <a href="#">未登录</a>
                    <a href="#">英雄社区</a>
                </div>
            @else
                <div class="top-right">
                    <a href="#"><img class="img-circle" src="{{ asset('heroHome/img/icon_empty.png') }}"></a>
                    <a href="{{ url('/login') }}">未登录</a>
                    <a href="#">英雄社区</a>
                </div>
            @endif
        </div>
    </div>
</header>
<div class=" container-fluid" style="margin-top: 79.6px;">
    <div class="row">
        <nav id="NavigationBar" class="font-size">
            <ul>
                <li><a href="#">奇力首页</a></li>
                <li><a href="#">创新作品</a></li>
                <li><a href="#">项目投资</a></li>
                <li><a href="#">英雄学院</a></li>
                <li><a href="#">市场咨询</a></li>
                <li><a href="#">创业政策</a></li>
                <li><a href="#">路演活动</a></li>
            </ul>
            <div id="carousel-example-generic" class="carousel slide animated rotateInUpLeft" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <img src="{{ asset('heroHome/img/demoimg/index_nav_img.jpg') }}" alt="...">
                        <div class="carousel-caption">
                        </div>
                    </div>
                    <div class="item">
                        <img src="{{ asset('heroHome/img/demoimg/banner.png') }}" alt="...">
                        <div class="carousel-caption">
                        </div>
                    </div>
                    <div class="item">
                        <img src="{{ asset('heroHome/img/demoimg/index_nav_img.jpg') }}" alt="...">
                        <div class="carousel-caption">
                        </div>
                    </div>
                    <div class="item">
                        <img src="{{ asset('heroHome/img/demoimg/banner.png') }}" alt="...">
                        <div class="carousel-caption">
                        </div>
                    </div>
                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <ul>
                <li><a href="#">项目投资</a></li>
                <li><a href="#">找投资人</a></li>
            </ul>
        </nav>
    </div>
</div>
<div class=" container-fluid" style="background-color: #F7F7F7;">
    <div id="section1">
        <div class="container" style="max-width: 1200px;width:100%;">
            <div style="max-width: 1200px;width:100%; margin:0 auto;" class=" row">
                <div class="col-sm-7" style="padding-left:0;">
                    <h2 class="jx-tit">精选项目</h2>
                </div>
                <div class="col-sm-5" style="padding-right:0;">
                    <li style="float: right;padding: 5px 30px 0 29px;"><a class="ckgd" href="#">查看更多</a></li>
                    <li style="float: right;"><a class="wysjx" href="#">我要上精选！</a></li>
                </div>
            </div>
            <ul class="row">
                <li class="col-sm-4">
                    <a class="new_a" href="#">
                        <img src="{{ asset('heroHome/img/demoimg/test1.jpg') }}">
                        <div class="companyName">深圳前海探鹿科技有限公司</div>
                        <div class="classLabel">
                            <span>消费生活</span>
                            <span>Pre-A轮</span>
                        </div>
                        <p class="new_p">
                            深圳前海探鹿科技有限公司，于2014年在中国深圳创立。探鹿·探享智驾乐趣，作为智能车联网生态
                        </p>
                    </a>
                </li>
                <li class="col-sm-4">
                    <a class="new_a" href="#">
                        <img src="{{ asset('heroHome/img/demoimg/test1.jpg') }}">
                        <div class="companyName">深圳前海探鹿科技有限公司</div>
                        <div class="classLabel">
                            <span>消费生活</span>
                            <span>Pre-A轮</span>
                        </div>
                        <p class="new_p">
                            深圳前海探鹿科技有限公司，于2014年在中国深圳创立。探鹿·探享智驾乐趣，作为智能车联网生态
                        </p>
                    </a>
                </li>
                <li class="col-sm-4">
                    <a class="new_a" href="#">
                        <img src="{{ asset('heroHome/img/demoimg/test1.jpg') }}">
                        <div class="companyName">深圳前海探鹿科技有限公司</div>
                        <div class="classLabel">
                            <span>消费生活</span>
                            <span>Pre-A轮</span>
                        </div>
                        <p class="new_p">
                            深圳前海探鹿科技有限公司，于2014年在中国深圳创立。探鹿·探享智驾乐趣，作为智能车联网生态
                        </p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class=" container-fluid">
    <section id="section2" class="font-size">
        <div class="row">
            <h2>英雄榜</h2>
        </div>
        <ul>
            <li class="row">
                <a href="#">
                    <div class="section2_img col-sm-3">
                        <img src="{{ asset('heroHome/img/demoimg/xiaoyu.jpg') }}">
                        <img src="{{ asset('heroHome/img/demoimg/xiaoyu.jpg') }}">
                    </div>
                    <div class="section2_center col-sm-6">
                        <div class="section2_center_title">
                            <h3>小余老师说</h3>
                            <span>致力于让全国人更懂教育的互联网+教育公司</span>
                        </div>
                        <ul>
                            <li>
                                <div>1天</div>
                                <div class="section2_hover">成功天数</div>
                            </li>
                            <li>
                                <div>￥650万</div>
                                <div class="section2_hover">成功融资</div>
                            </li>
                            <li>
                                <div>傅盛</div>
                                <div class="section2_hover">领投人</div>
                            </li>
                        </ul>
                    </div>
                    <div class="section2_evaluate col-sm-3">
                        <p>
                            <span></span>
                            <span>跟投人评价：</span>
                            作为小余老师说的用户，我投小余老师说一方面支持自己喜欢的视频节目、一方面觉得好的项目一定有好的回报的。加上还有猎豹CEO傅盛领投，必须得支持。
                        </p>
                    </div>
                </a>
            </li>
            <li class="row">
                <a href="#">
                    <div class="section2_img col-sm-3">
                        <img src="{{ asset('heroHome/img/demoimg/xiaoyu.jpg') }}">
                        <img src="{{ asset('heroHome/img/demoimg/xiaoyu.jpg') }}">
                    </div>
                    <div class="section2_center col-sm-6">
                        <div class="section2_center_title">
                            <h3>小余老师说</h3>
                            <span>致力于让全国人更懂教育的互联网+教育公司</span>
                        </div>
                        <ul>
                            <li>
                                <div>1天</div>
                                <div class="section2_hover">成功天数</div>
                            </li>
                            <li>
                                <div>￥650万</div>
                                <div class="section2_hover">成功融资</div>
                            </li>
                            <li>
                                <div>傅盛</div>
                                <div class="section2_hover">领投人</div>
                            </li>
                        </ul>
                    </div>
                    <div class="section2_evaluate col-sm-3">
                        <p>
                            <span></span>
                            <span>跟投人评价：</span>
                            作为小余老师说的用户，我投小余老师说一方面支持自己喜欢的视频节目、一方面觉得好的项目一定有好的回报的。加上还有猎豹CEO傅盛领投，必须得支持。
                        </p>
                    </div>
                </a>
            </li>
            <li class="row">
                <a href="#">
                    <div class="section2_img col-sm-3">
                        <img src="{{ asset('heroHome/img/demoimg/xiaoyu.jpg') }}">
                        <img src="{{ asset('heroHome/img/demoimg/xiaoyu.jpg') }}">
                    </div>
                    <div class="section2_center col-sm-6">
                        <div class="section2_center_title">
                            <h3>小余老师说</h3>
                            <span>致力于让全国人更懂教育的互联网+教育公司</span>
                        </div>
                        <ul>
                            <li>
                                <div>1天</div>
                                <div class="section2_hover">成功天数</div>
                            </li>
                            <li>
                                <div>￥650万</div>
                                <div class="section2_hover">成功融资</div>
                            </li>
                            <li>
                                <div>傅盛</div>
                                <div class="section2_hover">领投人</div>
                            </li>
                        </ul>
                    </div>
                    <div class="section2_evaluate col-sm-3">
                        <p>
                            <span></span>
                            <span>跟投人评价：</span>
                            作为小余老师说的用户，我投小余老师说一方面支持自己喜欢的视频节目、一方面觉得好的项目一定有好的回报的。加上还有猎豹CEO傅盛领投，必须得支持。
                        </p>
                    </div>
                </a>
            </li>
        </ul>
    </section>
    <section id="section3" class="font-size">
        <div class="section_title">
            <h2>路演活动</h2>
            <a href="#">查看全部</a>
        </div>
        <ul class="row">
            <li class="col-sm-4">
                <a href="#">
                    <img src="{{ asset('heroHome/img/demoimg/Roadshow.jpg') }}"/>
                </a>
                <div class="ly">
                    <h3><a href="#">玩出未来2016：未来预测游戏</a></h3>
                    <span>进行中</span>
                </div>
                <span>
    				<span>微信HTML5</span>
    				<span>2016-12-21</span>
    			</span>
            </li>
            <li class="col-sm-4">
                <a href="#">
                    <img src="{{ asset('heroHome/img/demoimg/Roadshow.jpg') }}"/>
                </a>
                <div class="ly">
                    <h3><a href="#">玩出未来2016：未来预测游戏</a></h3>
                    <span>进行中</span>
                </div>
                <span>
    				<span>微信HTML5</span>
    				<span>2016-12-21</span>
    			</span>
            </li>
            <li class="col-sm-4">
                <a href="#">
                    <img src="{{ asset('heroHome/img/demoimg/Roadshow.jpg') }}"/>
                </a>
                <div class="ly">
                    <h3><a href="#">玩出未来2016：未来预测游戏</a></h3>
                    <span>进行中</span>
                </div>
                <span>
    				<span>微信HTML5</span>
    				<span>2016-12-21</span>
    			</span>
            </li>
        </ul>
    </section>
    <section id="section3s" class="font-size">
        <div class="section_title">
            <h2>创业大赛</h2>
            <a href="#">查看全部</a>
        </div>
        <ul class="row">
            <li class="col-sm-4">
                <a href="#">
                    <img src="{{ asset('heroHome/img/demoimg/Roadshow.jpg') }}"/>
                </a>
                <div class="ly">
                    <h3><a href="#">玩出未来2016：未来预测游戏</a></h3>
                    <span>进行中</span>
                </div>
                <span>
    				<span>微信HTML5</span>
    				<span>2016-12-21</span>
    			</span>
            </li>
            <li class="col-sm-4">
                <a href="#">
                    <img src="{{ asset('heroHome/img/demoimg/Roadshow.jpg') }}"/>
                </a>
                <div class="ly">
                    <h3><a href="#">玩出未来2016：未来预测游戏</a></h3>
                    <span>进行中</span>
                </div>
                <span>
    				<span>微信HTML5</span>
    				<span>2016-12-21</span>
    			</span>
            </li>
            <li class="col-sm-4">
                <a href="#">
                    <img src="{{ asset('heroHome/img/demoimg/Roadshow.jpg') }}"/>
                </a>
                <div class="ly">
                    <h3><a href="#">玩出未来2016：未来预测游戏</a></h3>
                    <span>进行中</span>
                </div>
                <span>
    				<span>微信HTML5</span>
    				<span>2016-12-21</span>
    			</span>
            </li>
        </ul>
    </section>
    <section id="section4" class="font-size">
        <div class="section_title">
            <h2>英雄学院</h2>
            <a href="#">查看全部</a>
        </div>
        <ul class="row">
            <li class="col-sm-6">
                <a href="#">
                    <span>第1期</span>
                    <img src="{{ asset('heroHome/img/demoimg/test5.jpg') }}"/>
                    <div>
                        <h3>最受尊敬的脑洞评选</h3>
                        <span>已结束</span>
                    </div>
                    <p>
                        虎嗅网发起的针对奇妙idea创造与执行者的品牌特色评选活动。产品服务、商业营销、影视IP、文化设计........这些奇妙idea的主人，或在各行业窠臼、或在让改变发生。向TA们表示喜爱与致敬，是活动初心，也是一次年度创新...</p>
                </a>
            </li>
            <li class="col-sm-6">
                <a href="#">
                    <span>第1期</span>
                    <img src="{{ asset('heroHome/img/demoimg/test5.jpg') }}"/>
                    <div>
                        <h3>最受尊敬的脑洞评选</h3>
                        <span>已结束</span>
                    </div>
                    <p>
                        虎嗅网发起的针对奇妙idea创造与执行者的品牌特色评选活动。产品服务、商业营销、影视IP、文化设计........这些奇妙idea的主人，或在各行业窠臼、或在让改变发生。向TA们表示喜爱与致敬，是活动初心，也是一次年度创新...</p>
                </a>
            </li>
        </ul>
    </section>
    </div>
    <div class=" container-fluid" style="background-color: #F6F6F6;">
    <section id="section5" class="font-size">
        <div class="section_title">
            <h2>英雄众筹</h2>
        </div>
        <div id="section5_content">
            <!-- <h2>众筹</h2> -->
            <ul id="section5_content_middle">
                <li class="active">最新上架</li>
                <li>即将结束</li>
                <a id="zcckgd_a" href="#">查看全部></a>
            </ul>
            <div id="section5_content_bottom">
                <ul class="row">
                    <li class="col-sm-3">
                        <a href="#">
                            <div class="img_block">
                                <img src="{{ asset('heroHome/img/demoimg/test.jpg') }}">
                                <div>
                                    <p>关注NOBADAY，这个冬天的盛宴，携家人共同感受机制的冰雪户外运动</p>
                                </div>
                            </div>
                            <div class="js_loding">
                                <h4>NOBADAY单板滑雪板</h4>
                                <div class="js_loding_father">
                                    <div class="js_loding_son"></div>
                                </div>
                                <span>目标</span>
                                <span>￥53000</span>
                                <span class="zcy">￥7949</span>
                                <span class="zcy">超值档位</span>
                            </div>
                        </a>
                    </li>
                    <li class="col-sm-3">
                        <a href="#">
                            <div class="img_block">
                                <img src="{{ asset('heroHome/img/demoimg/test.jpg') }}">
                                <div>
                                    <p>关注NOBADAY，这个冬天的盛宴，携家人共同感受机制的冰雪户外运动</p>
                                </div>
                            </div>
                            <div class="js_loding">
                                <h4>NOBADAY单板滑雪板</h4>
                                <div class="js_loding_father">
                                    <div class="js_loding_son"></div>
                                </div>
                                <span>目标</span>
                                <span>￥53000</span>
                                <span class="zcy">￥7949</span>
                                <span class="zcy">超值档位</span>
                            </div>
                        </a>
                    </li>
                    <li class="col-sm-3">
                        <a href="#">
                            <div class="img_block">
                                <img src="{{ asset('heroHome/img/demoimg/test.jpg') }}">
                                <div>
                                    <p>关注NOBADAY，这个冬天的盛宴，携家人共同感受机制的冰雪户外运动</p>
                                </div>
                            </div>
                            <div class="js_loding">
                                <h4>NOBADAY单板滑雪板</h4>
                                <div class="js_loding_father">
                                    <div class="js_loding_son"></div>
                                </div>
                                <span>目标</span>
                                <span>￥53000</span>
                                <span class="zcy">￥7949</span>
                                <span class="zcy">超值档位</span>
                            </div>
                        </a>
                    </li>
                    <li class="col-sm-3">
                        <a href="#">
                            <div class="img_block">
                                <img src="{{ asset('heroHome/img/demoimg/test.jpg') }}">
                                <div>
                                    <p>关注NOBADAY，这个冬天的盛宴，携家人共同感受机制的冰雪户外运动</p>
                                </div>
                            </div>
                            <div class="js_loding">
                                <h4>NOBADAY单板滑雪板</h4>
                                <div class="js_loding_father">
                                    <div class="js_loding_son"></div>
                                </div>
                                <span>目标</span>
                                <span>￥53000</span>
                                <span class="zcy">￥7949</span>
                                <span class="zcy">超值档位</span>
                            </div>
                        </a>
                    </li>
                </ul>
                <ul class="active row">
                    <li class="col-sm-3">
                        <a href="#">
                            <div class="img_block">
                                <img src="{{ asset('heroHome/img/demoimg/5837b19bN7c6a2b50.jpg') }}">
                                <div>
                                    <p>关注NOBADAY，这个冬天的盛宴，携家人共同感受机制的冰雪户外运动</p>
                                </div>
                            </div>
                            <div class="js_loding">
                                <h4>NOBADAY单板滑雪板</h4>
                                <div class="js_loding_father">
                                    <div class="js_loding_son"></div>
                                </div>
                                <span>目标</span>
                                <span>￥53000</span>
                                <span class="zcy">￥7949</span>
                                <span class="zcy">超值档位</span>
                            </div>
                        </a>
                    </li>
                    <li class="col-sm-3">
                        <a href="#">
                            <div class="img_block">
                                <img src="{{ asset('heroHome/img/demoimg/5837b19bN7c6a2b50.jpg') }}">
                                <div>
                                    <p>关注NOBADAY，这个冬天的盛宴，携家人共同感受机制的冰雪户外运动</p>
                                </div>
                            </div>
                            <div class="js_loding">
                                <h4>NOBADAY单板滑雪板</h4>
                                <div class="js_loding_father">
                                    <div class="js_loding_son"></div>
                                </div>
                                <span>目标</span>
                                <span>￥53000</span>
                                <span class="zcy">￥7949</span>
                                <span class="zcy">超值档位</span>
                            </div>
                        </a>
                    </li>
                    <li class="col-sm-3">
                        <a href="#">
                            <div class="img_block">
                                <img src="{{ asset('heroHome/img/demoimg/5837b19bN7c6a2b50.jpg') }}">
                                <div>
                                    <p>关注NOBADAY，这个冬天的盛宴，携家人共同感受机制的冰雪户外运动</p>
                                </div>
                            </div>
                            <div class="js_loding">
                                <h4>NOBADAY单板滑雪板</h4>
                                <div class="js_loding_father">
                                    <div class="js_loding_son"></div>
                                </div>
                                <span>目标</span>
                                <span>￥53000</span>
                                <span class="zcy">￥7949</span>
                                <span class="zcy">超值档位</span>
                            </div>
                        </a>
                    </li>
                    <li class="col-sm-3">
                        <a href="#">
                            <div class="img_block">
                                <img src="{{ asset('heroHome/img/demoimg/5837b19bN7c6a2b50.jpg') }}">
                                <div>
                                    <p>关注NOBADAY，这个冬天的盛宴，携家人共同感受机制的冰雪户外运动</p>
                                </div>
                            </div>
                            <div class="js_loding">
                                <h4>NOBADAY单板滑雪板</h4>
                                <div class="js_loding_father">
                                    <div class="js_loding_son"></div>
                                </div>
                                <span>目标</span>
                                <span>￥53000</span>
                                <span class="zcy">￥7949</span>
                                <span class="zcy">超值档位</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </section>
        </div>
<div class=" container-fluid">
    <section id="section6" class="font-size">
        <ul class="section6_top">
            <li>
                <h2>英雄社区</h2>
            </li>
        </ul>
        <div id="section6_bottom">
            <ul id="section6_left" class="row">
                <li class="col-sm-6">
                    <img src="{{ asset('heroHome/img/demoimg/Roadshow.jpg') }}"/>
                    <div>
                        <h3><a href="#">Ubuntu Core 16 黑客松一 Celebrate Ununtu</a></h3>
                        <p>Posted on 2016/11/11 10:44:05</p>
                        <p>Ubuntu Core 是一个精简版的Ununtu系统，完全采用安全、易于更新的开源Linux打包格式Snap构建。Ununtu Core针对生产环境从头开始设计</p>
                    </div>
                </li>
                <li class="col-sm-6">
                    <img src="{{ asset('heroHome/img/demoimg/Roadshow.jpg') }}"/>
                    <div>
                        <h3><a href="#">Ubuntu Core 16 黑客松一 Celebrate Ununtu</a></h3>
                        <p>Posted on 2016/11/11 10:44:05</p>
                        <p>Ubuntu Core 是一个精简版的Ununtu系统，完全采用安全、易于更新的开源Linux打包格式Snap构建。Ununtu Core针对生产环境从头开始设计</p>
                    </div>
                </li>
                <li class="col-sm-6">
                    <img src="{{ asset('heroHome/img/demoimg/Roadshow.jpg') }}"/>
                    <div>
                        <h3><a href="#">Ubuntu Core 16 黑客松一 Celebrate Ununtu</a></h3>
                        <p>Posted on 2016/11/11 10:44:05</p>
                        <p>Ubuntu Core 是一个精简版的Ununtu系统，完全采用安全、易于更新的开源Linux打包格式Snap构建。Ununtu Core针对生产环境从头开始设计</p>
                    </div>
                </li>
                <li class="col-sm-6">
                    <img src="{{ asset('heroHome/img/demoimg/Roadshow.jpg') }}"/>
                    <div>
                        <h3><a href="#">Ubuntu Core 16 黑客松一 Celebrate Ununtu</a></h3>
                        <p>Posted on 2016/11/11 10:44:05</p>
                        <p>Ubuntu Core 是一个精简版的Ununtu系统，完全采用安全、易于更新的开源Linux打包格式Snap构建。Ununtu Core针对生产环境从头开始设计</p>
                    </div>
                </li>
            </ul>
        </div>
        <ul class="section6_top">
            <li>
                <h2>市场资讯</h2>
            </li>
        </ul>
        <div id="yxzx" class="row">
            <ul class='col-sm-5 section6_right'>
                <li>
                    <h3><a href="#">人生必去的Maker Faire | 我们刚刚从台北和旧金山回来</a></h3>
                    <p>Posteed on 2016/07/03</p>
                </li>
                <li>
                    <h3><a href="#">人生必去的Maker Faire | 我们刚刚从台北和旧金山回来</a></h3>
                    <p>Posteed on 2016/07/03</p>
                </li>
                <li>
                    <h3><a href="#">人生必去的Maker Faire | 我们刚刚从台北和旧金山回来</a></h3>
                    <p>Posteed on 2016/07/03</p>
                </li>
                <li>
                    <h3><a href="#">人生必去的Maker Faire | 我们刚刚从台北和旧金山回来</a></h3>
                    <p>Posteed on 2016/07/03</p>
                </li>
            </ul>
            <ul class='col-sm-5 section6_right'>
                <li>
                    <h3><a href="#">人生必去的Maker Faire | 我们刚刚从台北和旧金山回来</a></h3>
                    <p>Posteed on 2016/07/03</p>
                </li>
                <li>
                    <h3><a href="#">人生必去的Maker Faire | 我们刚刚从台北和旧金山回来</a></h3>
                    <p>Posteed on 2016/07/03</p>
                </li>
                <li>
                    <h3><a href="#">人生必去的Maker Faire | 我们刚刚从台北和旧金山回来</a></h3>
                    <p>Posteed on 2016/07/03</p>
                </li>
                <li>
                    <h3><a href="#">人生必去的Maker Faire | 我们刚刚从台北和旧金山回来</a></h3>
                    <p>Posteed on 2016/07/03</p>
                </li>
            </ul>
        </div>
    </section>
    <!----英雄社区与市场咨询结束----->
    <!----英雄会友情机构开始----->
    <section id="section7" class="font-size">
        <h2>英雄会合作机构</h2>
        <ul class="row">
            <li class="col-sm-2"><a href="#"><img src="{{ asset('heroHome/img/demoimg/test2.jpg') }}"></a></li>
            <li class="col-sm-2"><a href="#"><img src="{{ asset('heroHome/img/demoimg/test2.jpg') }}"></a></li>
            <li class="col-sm-2"><a href="#"><img src="{{ asset('heroHome/img/demoimg/test2.jpg') }}"></a></li>
            <li class="col-sm-2"><a href="#"><img src="{{ asset('heroHome/img/demoimg/test2.jpg') }}"></a></li>
            <li class="col-sm-2"><a href="#"><img src="{{ asset('heroHome/img/demoimg/test2.jpg') }}"></a></li>
        </ul>
    </section>
    <!----英雄会友情机构结束----->
    </div>
<div class=" container-fluid" style="padding: 0px">
    <section id="section8" class="font-size">
        <img src="{{ asset('heroHome/img/demoimg/test3.jpg') }}"/>
    </section>
    </div>
<div class=" container-fluid" style="background: #F2F3F7;">
    <section id="section9" class="font-size">
        <h2>英雄会顶级投资机构联盟</h2>
        <ul class="row">
            <li class="col-sm-2">
                <img src="{{ asset('heroHome/img/demoimg/test4.jpg') }}"/>
                <a href="#">
                    <div>
                        <img src="{{ asset('heroHome/img/cross.png') }}"/>
                    </div>
                </a>
            </li>
            <li class="col-sm-2">
                <img src="{{ asset('heroHome/img/demoimg/test4.jpg') }}"/>
                <a href="#">
                    <div>
                        <img src="{{ asset('heroHome/img/cross.png') }}"/>
                    </div>
                </a>
            </li>
            <li class="col-sm-2">
                <img src="{{ asset('heroHome/img/demoimg/test4.jpg') }}"/>
                <a href="#">
                    <div>
                        <img src="{{ asset('heroHome/img/cross.png') }}"/>
                    </div>
                </a>
            </li>
            <li class="col-sm-2">
                <img src="{{ asset('heroHome/img/demoimg/test4.jpg') }}"/>
                <a href="#">
                    <div>
                        <img src="{{ asset('heroHome/img/cross.png') }}"/>
                    </div>
                </a>
            </li>
            <li class="col-sm-2">
                <img src="{{ asset('heroHome/img/demoimg/test4.jpg') }}"/>
                <a href="#">
                    <div>
                        <img src="{{ asset('heroHome/img/cross.png') }}"/>
                    </div>
                </a>
            </li>
        </ul>
        <ul class="row">
            <li class="col-sm-2">
                <img src="{{ asset('heroHome/img/demoimg/test4.jpg') }}"/>
                <a href="#">
                    <div>
                        <img src="{{ asset('heroHome/img/cross.png') }}"/>
                    </div>
                </a>
            </li>
            <li class="col-sm-2">
                <img src="{{ asset('heroHome/img/demoimg/test4.jpg') }}"/>
                <a href="#">
                    <div>
                        <img src="{{ asset('heroHome/img/cross.png') }}"/>
                    </div>
                </a>
            </li>
            <li class="col-sm-2">
                <img src="{{ asset('heroHome/img/demoimg/test4.jpg') }}"/>
                <a href="#">
                    <div>
                        <img src="{{ asset('heroHome/img/cross.png') }}"/>
                    </div>
                </a>
            </li>
            <li class="col-sm-2">
                <img src="{{ asset('heroHome/img/demoimg/test4.jpg') }}"/>
                <a href="#">
                    <div>
                        <img src="{{ asset('heroHome/img/cross.png') }}"/>
                    </div>
                </a>
            </li>
            <li class="col-sm-2">
                <img src="{{ asset('heroHome/img/demoimg/test4.jpg') }}"/>
                <a href="#">
                    <div>
                        <img src="{{ asset('heroHome/img/cross.png') }}"/>
                    </div>
                </a>
            </li>
        </ul>
    </section>
</div>
<footer class="container-fluid">
    <div class="container">
        <div class="row change-row-margin">
            <div class="footer-left col-xs-12 col-sm-4 col-md-4 col-lg-3">
                <p class="text-left">客服电话：4008652555<br>客服邮箱：qlyxh@.com<br>工作时间：周一至周五10:00-18:00</p>
            </div>
            <div class="footer-center col-xs-12  col-sm-4 col-md-4 col-lg-5">
                <a href="#">关于我们</a>
                <a href="#">新人课堂</a>
                <a href="#">常见问题</a>
            </div>
            <div class="footer-right col-xs-12  col-sm-4 col-md-4 col-lg-4">
                <span>关注奇立英雄会微信号</span>
                <p class="text-left">随时随地查看项目<br>进度及时推送</p>
            </div>
        </div>
    </div>
</footer>
<div class="container-fluid bottom">
    <p class="text-center">@2011-2016 崎立英雄会 | 京ICP备16042819号-1</p>
</div>
</body>
</html>
