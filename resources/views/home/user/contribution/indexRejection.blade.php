 @extends('home.layouts.userCenter')

@section('title', '我的投稿')

@section('style')
  <link href="{{ asset('home/css/user_center_contribute.css') }}" rel="stylesheet">
@endsection

@section('content')
      <!--我的投稿 已发表开始-->
      <!--导航开始-->
      <div class="tab-info-top col-xs-12 col-sm-9 col-md-9 col-lg-10 pad-clr">
            <a id="contribute" class="hidden-xs" href="/send?status=5">&nbsp;&nbsp;投稿&nbsp;&nbsp;<span class="triangle-down left-2"></span></a>
            <a class="pad-tab-top-info-xs {{ $status == 2 ? 'selected' : '' }}" href="/send?status=2">审核中({{ $TypeDataNum['releaseNum'] or 0 }})<span class="triangle-down left-2"></span></a>
            <a class="pad-tab-top-info-xs {{ $status == 1 ? 'selected' : '' }}" href="/send?status=1">已发表({{ $TypeDataNum['trailNum'] or 0 }})<span class="triangle-down left-2"></span></a>
            <a class="pad-tab-top-info-xs {{ $status == 3 ? 'selected' : '' }}" href="/send?status=3">已退稿({{ $TypeDataNum['notNum'] or 0 }})<span class="triangle-down left-2"></span></a>
            <a class="pad-tab-top-info-xs {{ $status == 4 ? 'selected' : '' }}" href="/send?status=4">草稿箱({{ $TypeDataNum['draftNum'] or 0 }})<span class="triangle-down left-2"></span></a>
      </div>
      <!--导航结束-->
      <div id="contributeNav" class="col-xs-12 col-sm-9 col-md-9 col-lg-10 fs-15 bgc-1 pad-2">


        <div class="contribute-box-head bb-1 pad-b5">
          <a href="javascript:void(0)" class="pad-r10 a-style-1" id="checkAll" name="checkAll" onclick="checkAllSwitch()">全选</a>
          <a id="delete" href="javascript:void(0)" class="a-style-1">删除</a>

        </div>

        @if($StatusCode == 200)
            @if(!empty($ResultData['data']))
                @foreach($ResultData['data'] as $val)
                    <div class="contribute-box pad-3 bb-1">
                        <div class="dis-in-bl pad-clr col-xs-12 col-sm-8">
                            {{--这里样式有BUG需要修改 checkbox-1 --}}
                            <label class="1">
                                <input type="checkbox" class="checkbox-contri" name="itemId"  id="{{ $val->guid }}"/>
                            </label>
                            <a class="a-style-1" href="/article/{{ $val->guid }}" target="_blank">{{ $val->title }}</a>
                        </div>
                        <div class="dis-in-bl col-sm-4 pad-clr mar-eml2-xs mar-emt03-xs hidden-xs">
                            <span data-delete="{{ $val->guid }}" class="bg-area bg-del pull-right"></span>
                            <a href="{{ asset('/send?status=5&write=' . $val->guid) }}" class="bg-area bg-write pull-right"></a>
                        </div>
                        <div class="col-xs-12 pad-clr">
                            <p class="mar-cb mar-eml2 mar-emt03">{{ date('Y-m-d H:i:s', $val->addtime) }}</p>
                        </div>
                        <div class="dis-in-bl col-xs-12 pad-clr mar-eml2-xs mar-emt03-xs visible-xs-block">
                            <span data-delete="{{ $val->guid }}" class="bg-area bg-del dis-in-bl"></span>
                            <a class="bg-area bg-write dis-in-bl"></a>`
                        </div>
                        <div class="clearfix"></div>
                    </div>
                @endforeach
                    <div class="text-center">
                        {!! $ResultData['pages'] !!}
                    </div>

            @endif
        @endif


      </div>
      <!--我的投稿 已发表结束-->

@endsection

@section('script')
    <script src="{{ asset('home/js/sweet-alert.min.js') }}"></script>
    <script src="{{ asset('home/js/contribute.js') }}"></script>

@endsection
