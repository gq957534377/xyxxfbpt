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
                <li><a class="btn btn-default active project_type" href="javascript:;" data-filter=".protype_1" project_type="1">热门推荐</a></li>
                <li><a class="btn btn-default project_type" href="javascript:;" data-filter=".protype_2" project_type="2">新品上架</a></li>
                <li><a class="btn btn-default project_type" href="javascript:;" data-filter=".protype_3" project_type="3">未来科技</a></li>
                <li><a class="btn btn-default project_type" href="javascript:;" data-filter=".protype_4" project_type="4">健康出行</a></li>
                <li><a class="btn btn-default project_type" href="javascript:;" data-filter=".protype_5" project_type="5">生活美学</a></li>
                <li><a class="btn btn-default project_type" href="javascript:;" data-filter=".protype_6" project_type="6">美食生活</a></li>
                <li><a class="btn btn-default project_type" href="javascript:;" data-filter=".protype_7" project_type="7">流行文化</a></li>
                <li><a class="btn btn-default project_type" href="javascript:;" data-filter="protype_8" project_type="8">爱心公益</a></li>
            </ul><!--/#portfolio-filter-->

            <div class="row">
                <div class="portfolio-items">
                    <!--返回视图模板数据遍历-->
                    @foreach ($data as $v)
                    <div class="portfolio-item apps col-xs-12 col-sm-4 col-md-3 protype_{{$v->project_type}}">
                        <div class="recent-work-wrap">
                            <img class="img-responsive" src="{{$v->image}}" alt="">
                            <div class="overlay">
                                <div class="recent-work-inner">
                                    <h3><a href="project/{{$v->project_id}}">{{$v->title}}</a></h3>
                                        <span>性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;质：{{$v->habitude}}</span><br>
                                    <span>起步资金：{{$v->less_funding}}</span><br>
                                    <span>项目周期：{{$v->cycle}}</span><br>
                                    <span>介&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;绍：{{$v->content}}</span>
                                    <a class="preview" href="project/{{$v->project_id}}" ><i class="fa fa-eye"></i> 查看详情</a>
                                </div>
                            </div>
                        </div>
                    </div><!--/.portfolio-item-->

                        @endforeach

                </div>
            </div>
        </div>
    </section><!--/#portfolio-item-->

@endsection
@section('script')
    <script src="{{url('JsService/Model/projectModel.js')}}"></script>
    <script>
    </script>
    @endsection
