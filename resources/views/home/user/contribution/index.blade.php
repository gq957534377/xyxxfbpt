@extends('home.layouts.userCenter')

@section('title', '我的身份')

@section('style')
  <link href="{{ asset('home/css/user_center_contribute.css') }}" rel="stylesheet">
@endsection

@section('content')
      <!--我的投稿 已发表开始-->
      <!--导航开始-->
      <div class="tab-info-top col-xs-12 col-sm-9 col-md-9 col-lg-10 pad-clr">
        <a class="hidden-xs" href="#">&nbsp;&nbsp;投稿&nbsp;&nbsp;<span class="triangle-down left-2"></span></a>
        <a class="pad-tab-top-info-xs" href="/send?type=1&status=1">审核中(0)<span class="triangle-down left-2"></span></a>
        <a class="pad-tab-top-info-xs" href="#">已发表(0)<span class="triangle-down left-2"></span></a>
        <a class="pad-tab-top-info-xs" href="#">已退稿(0)<span class="triangle-down left-2"></span></a>
        <a class="pad-tab-top-info-xs" href="#">草稿箱(0)<span class="triangle-down left-2"></span></a>
      </div>
      <!--导航结束-->
      <div class="col-xs-12 col-sm-9 col-md-9 col-lg-10 fs-15 bgc-1 pad-2">
        <div class="contribute-box-head bb-1 pad-b5">
          <a href="javascript:void(0)" class="pad-r10 a-style-1" id="checkAll" name="checkAll" onclick="checkAllSwitch()">全选</a>
          <a href="javascript:void(0)" class="a-style-1">删除</a>
          <a href="javascript:void(0)" class="pull-right a-style-1">下一页</a>
          <a href="javascript:void(0)" class="pull-right pad-r10 a-style-1">上一页</a>

        </div>

        @if($StatusCode == 200)
          @foreach($ResultData['data'] as $val)
            <div class="contribute-box pad-3 bb-1">
              <div class="dis-in-bl pad-clr col-xs-12 col-sm-8">
                <label class="checkbox-1">
                  <input type="checkbox" value="guid" name="itemId"  id="1"/>
                </label>
                <a class="a-style-1" href="#">{{ $val->title }}</a>
              </div>
              <div class="dis-in-bl col-sm-4 pad-clr mar-eml2-xs mar-emt03-xs hidden-xs">
                <span class="bg-area bg-del pull-right"></span>
                <span class="bg-area bg-write pull-right"></span>
              </div>
              <div class="col-xs-12 pad-clr">
                <p class="mar-cb mar-eml2 mar-emt03">{{ $val->time }}</p>
              </div>
              <div class="dis-in-bl col-xs-12 pad-clr mar-eml2-xs mar-emt03-xs visible-xs-block">
                <span class="bg-area bg-del dis-in-bl"></span>
                <span class="bg-area bg-write dis-in-bl"></span>
              </div>
              <div class="clearfix"></div>
            </div>
          @endforeach
        @endif
        {!! $ResultData['pages'] !!}

      </div>
      <!--我的投稿 已发表结束-->

@endsection

@section('script')
<script>
//  document.onselectstart = new Function("return false");
  //     按钮状态
  var status = 0;
  //    全选 取消全选
  function checkAllSwitch() {
    if (status == 0) {
      $('input[name="itemId"]').prop('checked', 'true');
      $('.checkbox-1').removeClass('opacity-0').addClass('opacity-1');
      $("#checkAll").html('取消全选');
      status = 1;
    } else {
      $('input[name="itemId"]').each(function(){
        this.checked = false;
      });
      $('.checkbox-1').removeClass('opacity-1').addClass('opacity-0');
      $("#checkAll").html('全选');
      status = 0;
    }
  }
//  单个复选框操作
  $(function () {
    var inputs = $("input[name='itemId']");
    var num = inputs.length;
    inputs.on('click', function(){
      var num_checked = $("input[name='itemId']:checked").length;
//      alert(num_checked);
      if (this.checked == true) {
        $(this).parent().removeClass('opacity-0').addClass('opacity-1');
        if (num == num_checked) {
          $("#checkAll").html('取消全选');
          status = 1;
        }
      } else {
        $(this).parent().removeClass('opacity-1').addClass('opacity-0');
        if (num != num_checked) {
          $("#checkAll").html('全选');
          status = 0;
        }
      }
    });
  });
</script>
@endsection
