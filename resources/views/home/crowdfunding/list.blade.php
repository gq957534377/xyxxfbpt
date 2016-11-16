@extends('home.layouts.index')
@section('content')
	<section id="portfolio">
		<div class="container" id="plotBord">
			<div class="row wow fadeInUp">
				<div class="portfolio-items">

                    @for($i=0;$i<count($data["projectInfo"]);$i++)
                        @if($i%2==1)
                            {{-- */$m="float:right;margin-right:50px;";/* --}}
                        @else
                            {{-- */$m="float:left;margin-left:50px;";/* --}}
                        @endif
					<div style="margin-top: 35px;width: 450px;{{$m}}" class="portfolio-item apps col-xs-12 col-md-4">
						<div class="recent-work-wrap">
							<img class="img-responsive" src="{{asset('home/images/portfolio/full/item1.png')}}" alt="">
							<div class="overlay">
								<div class="recent-work-inner">
									<h3><a href="{{url('crowd_funding/'.$data["crowdInfo"][$i]->project_id.'/edit')}}">{{$data["crowdInfo"][$i]->title}}</a></h3>
									<p>简介：{{$data["crowdInfo"][$i]->simple_info}}</p>
                                    <h3 style="color: #fff">预筹金额(￥):<b>{{$data["crowdInfo"][$i]->fundraising}}</b></h3>
                                    <h3 style="color: #fff">已筹金额(￥):<b>{{$data["crowdInfo"][$i]->fundraising_now}}</b></h3>
                                    <h3 style="color: #fff">开始日期:<b>{{$data["crowdInfo"][$i]->starttime}}</b></h3>
                                    <h3 style="color: #fff">结束日期:<b>{{$data["crowdInfo"][$i]->endtime}}</b></h3>
									<a class="preview" href="{{url('crowd_funding/'.$data["crowdInfo"][$i]->project_id.'/edit')}}"><i class="fa fa-eye"></i> 查看</a>
								</div>
							</div>
						</div>
					</div><!--/.portfolio-item-->
                    @endfor
				</div>
			</div>
		</div>
        <center id="pageBlock">
            {!!  $data["forPage"]["pages"]  !!}
        </center>
	</section>

@endsection


