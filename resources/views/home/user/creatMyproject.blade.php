@extends('home.layouts.userCenter')

@section('title','创建我的项目')

@section('style')
  <link href="{{ asset('home/css/user_center_my_project-upload.css') }}" rel="stylesheet">
  <link href="{{asset('dateTime/jquery.datetimepicker.css')}}" rel="stylesheet">
  <link href="{{asset('cropper/css/cropper.min.css')}}" rel="stylesheet"/>
  <link href="{{asset('cropper/css/sitelogo.css')}}" rel="stylesheet"/>
@endsection
@section('content')

      <!--创建我的项目开始-->
      <div class="col-xs-12 col-sm-9 col-md-9 col-lg-10 my-project-upload">
        <div>
          <span>上传我的项目</span>
        </div>
        <p class="text-center fs-12 fs-c-2 mar-3">审核通过后会显示在“创新作品”</p>

        <!--表单开始-->
        <form id="projectForm" class="form-horizontal personal-data-edit" role="form" method="POST" action="#" accept-charset="UTF-8" enctype="multipart/form-data">

          <!--项目/产品名称 开始-->
          <div class="form-group mar-b30 line-h-3">
            <label for="form-title" class="col-md-3 col-lg-2 control-label mar-b10 pad-cr mar-xs--b"><span class="form-star">*</span>项目/产品名称</label>
            <div class="col-md-5 col-lg-4">
              <input name="title" type="text" class="form-control" id="form-title" placeholder="">
            </div>
          </div>
          <!--项目/产品名称 结束-->
          <!--一句话介绍 开始-->
          <div class="form-group mar-b30">
            <label for="form-introduction" class="col-md-3 col-lg-2 control-label mar-b10 mar-cb-xs"><span class="form-star">*</span>一句话介绍</label>
            <div class="col-md-8 col-lg-8">
              <textarea name="brief_content" class="form-control text-r ht-8" id="form-introduction"></textarea>
            </div>
          </div>
          <!--一句话介绍 结束-->
          <!--行业 开始-->
          <div class="form-group mar-cb line-h-3">
            <label for="project-area" class="col-xs-12 col-md-3 col-lg-2 control-label pad-cr mar-xs--b"><span class="form-star">*</span>行业</label>
            <div class="col-xs-8 col-md-5 col-lg-3 mar-b30">
              <select name="industry" class="form-control chr-c bg-1" id="project-area">
                <option value="">请选择领域</option>
                <option value="0">TMT</option>
                <option value="1">医疗健康</option>
                <option value="2">文化与创意</option>
                <option value="3">智能硬件</option>
                <option value="4">教育</option>
                <option value="5">电商</option>
                <option value="6">旅游</option>
                <option value="7">新农业</option>
                <option value="8">互联网金融</option>
                <option value="9">游戏</option>
                <option value="10">汽车后市场</option>
                <option value="11">企业级服务</option>
                <option value="12">数据服务</option>
                <option value="13">其他</option>
              </select>
            </div>
            <div class="col-md-4 ht-px34 mar-b30 hidden-lg hidden-sm hidden-xs"> </div>
            <label for="project-step" class="col-xs-12 col-md-3 col-lg-2 control-label mar-xs--b"><span class="form-star">*</span>融资阶段</label>
            <div class="col-xs-8 col-md-5 col-lg-3 mar-b30">
              <select name="financing_stage" class="form-control chr-c bg-1" id="project-step">
                <option value="">请选择阶段</option>
                <option value="0">种子轮</option>
                <option value="1">天使轮</option>
                <option value="2">Pre-A轮</option>
                <option value="3">A轮</option>
                <option value="4">B轮</option>
                <option value="5">C轮</option>
                <option value="6">D轮</option>
                <option value="7">E轮</option>
                <option value="8">F轮已上市</option>
                <option value="9">其他</option>
              </select>
            </div>
          </div>
          <!--行业 结束-->
          <!--项目详情 开始-->
          <div class="form-group mar-b30">
            <label for="project-details" class="col-md-3 col-lg-2 control-label mar-b10 mar-xs--b"><span class="form-star">*</span>项目详情</label>
            <div class="col-md-8 col-lg-8">
              <textarea name="content" class="form-control text-r ht-8" id="project-details" placeholder=""></textarea>
            </div>
          </div>
          <!--项目详情 结束-->
          <!--项目历程 开始-->
          <div class='form-group line-h-3'>
            <span style="word-break: keep-all" class="col-md-3 col-lg-2 control-label mar-b10 dis-in-bl mar-xs--b">项目历程(选填)</span>
            <div class='col-md-8'>
              <div class='col-xs-8 col-sm-8 col-md-8 pad-clr'>
                <input placeholder="此处单击填写下方内容发生的时间" class='form-control pad-cr-xs pad-l5-xs chr-c date-time' />
              </div>
            </div>
          </div>
          <div class="form-group mar-b15 mar-b15-xs line-h-3">
            <div class="col-xs-9 col-sm-10 col-md-offset-3 col-lg-offset-2 col-md-6">
              <input type="text" class="form-control form-title" id="project-content" placeholder="此处填写本次历程内容">
            </div>
          </div>
          <!--项目历程 结束-->

          <!--添加项目历程开始-->
          <div id="pro_exo_1" class='hiddens form-group line-h-3'>
            <span class='col-md-3 col-lg-2 control-label dis-in-bl ht-px34 hidden-sm hidden-xs'></span>
            <div class='col-md-8'>
              <div class='col-xs-8 col-sm-8 col-md-8 pad-clr'>
                <input placeholder="此处单击填写下方内容发生的时间" class='form-control pad-cr-xs pad-l5-xs chr-c date-time' />
              </div>
            </div>
          </div>
          <div id="pro_exo_1s" class='hiddens form-group mar-b15 mar-b15-xs line-h-3'>
            <div class='col-xs-9 col-sm-10 col-md-offset-3 col-lg-offset-2 col-md-6'>
              <input type='text' class='form-control form-title' id='project-content' placeholder='此处填写本次历程内容'>
            </div>
          </div>
          <div id="pro_exo_2" class='hiddens form-group line-h-3'>
            <span class='col-md-3 col-lg-2 control-label dis-in-bl ht-px34 hidden-sm hidden-xs'></span>
            <div class='col-md-8'>
              <div class='col-xs-8 col-sm-8 col-md-8 pad-clr'>
                <input placeholder="此处单击填写下方内容发生的时间" class='form-control pad-cr-xs pad-l5-xs chr-c date-time' />
              </div>
            </div>
          </div>
          <div id="pro_exo_2s" class='hiddens form-group mar-b15 mar-b15-xs line-h-3'>
            <div class='col-xs-9 col-sm-10 col-md-offset-3 col-lg-offset-2 col-md-6'>
              <input type='text' class='form-control form-title' id='project-content' placeholder='此处填写本次历程内容'>
            </div>
          </div>
          <div id="pro_exo_3" class='hiddens form-group line-h-3'>
            <span class='col-md-3 col-lg-2 control-label dis-in-bl ht-px34 hidden-sm hidden-xs'></span>
            <div class='col-md-8'>
              <div class='col-xs-8 col-sm-8 col-md-8 pad-clr'>
                <input placeholder="此处单击填写下方内容发生的时间" class='form-control pad-cr-xs pad-l5-xs chr-c date-time' />
              </div>
            </div>
          </div>
          <div id="pro_exo_3s" class='hiddens form-group mar-b15 mar-b15-xs line-h-3'>
            <div class='col-xs-9 col-sm-10 col-md-offset-3 col-lg-offset-2 col-md-6'>
              <input type='text' class='form-control form-title' id='project-content' placeholder='此处填写本次历程内容'>
            </div>
          </div>
          <div id="pro_exo_4" class='hiddens form-group line-h-3'>
            <span class='col-md-3 col-lg-2 control-label dis-in-bl ht-px34 hidden-sm hidden-xs'></span>
            <div class='col-md-8'>
              <div class='col-xs-8 col-sm-8 col-md-8 pad-clr'>
                <input placeholder="此处单击填写下方内容发生的时间" class='form-control pad-cr-xs pad-l5-xs chr-c date-time' />
              </div>
            </div>
          </div>
          <div id="pro_exo_4s" class='hiddens form-group mar-b15 mar-b15-xs line-h-3'>
            <div class='col-xs-9 col-sm-10 col-md-offset-3 col-lg-offset-2 col-md-6'>
              <input type='text' class='form-control form-title' id='project-content' placeholder='此处填写本次历程内容'>
            </div>
          </div>
          <div id="pro_exo_5" class='hiddens form-group line-h-3'>
            <span class='col-md-3 col-lg-2 control-label dis-in-bl ht-px34 hidden-sm hidden-xs'></span>
            <div class='col-md-8'>
              <div class='col-xs-8 col-sm-8 col-md-8 pad-clr'>
                <input placeholder="此处单击填写下方内容发生的时间" class='form-control pad-cr-xs pad-l5-xs chr-c date-time' />
              </div>
            </div>
          </div>
          <div id="pro_exo_5s" class='hiddens form-group mar-b15 mar-b15-xs line-h-3'>
            <div class='col-xs-9 col-sm-10 col-md-offset-3 col-lg-offset-2 col-md-6'>
              <input type='text' class='form-control form-title' id='project-content' placeholder='此处填写本次历程内容'>
            </div>
          </div>
          <div id="pro_exo_6" class='hiddens form-group line-h-3'>
            <span class='col-md-3 col-lg-2 control-label dis-in-bl ht-px34 hidden-sm hidden-xs'></span>
            <div class='col-md-8'>
              <div class='col-xs-8 col-sm-8 col-md-8 pad-clr'>
                <input placeholder="此处单击填写下方内容发生的时间" class='form-control pad-cr-xs pad-l5-xs chr-c date-time' />
              </div>
            </div>
          </div>
          <div id="pro_exo_6s" class='hiddens form-group mar-b15 mar-b15-xs line-h-3'>
            <div class='col-xs-9 col-sm-10 col-md-offset-3 col-lg-offset-2 col-md-6'>
              <input type='text' class='form-control form-title' id='project-content' placeholder='此处填写本次历程内容'>
            </div>
          </div>
          <div id="pro_exo_7" class='hiddens form-group line-h-3'>
            <span class='col-md-3 col-lg-2 control-label dis-in-bl ht-px34 hidden-sm hidden-xs'></span>
            <div class='col-md-8'>
              <div class='col-xs-8 col-sm-8 col-md-8 pad-clr'>
                <input placeholder="此处单击填写下方内容发生的时间" class='form-control pad-cr-xs pad-l5-xs chr-c date-time' />
              </div>
            </div>
          </div>
          <div id="pro_exo_7s" class='hiddens form-group mar-b15 mar-b15-xs line-h-3'>
            <div class='col-xs-9 col-sm-10 col-md-offset-3 col-lg-offset-2 col-md-6'>
              <input type='text' class='form-control form-title' id='project-content' placeholder='此处填写本次历程内容'>
            </div>
          </div>
          <div id="pro_exo_8" class='hiddens form-group line-h-3'>
            <span class='col-md-3 col-lg-2 control-label dis-in-bl ht-px34 hidden-sm hidden-xs'></span>
            <div class='col-md-8'>
              <div class='col-xs-8 col-sm-8 col-md-8 pad-clr'>
                <input placeholder="此处单击填写下方内容发生的时间" class='form-control pad-cr-xs pad-l5-xs chr-c date-time' />
              </div>
            </div>
          </div>
          <div id="pro_exo_8s" class='hiddens form-group mar-b15 mar-b15-xs line-h-3'>
            <div class='col-xs-9 col-sm-10 col-md-offset-3 col-lg-offset-2 col-md-6'>
              <input type='text' class='form-control form-title' id='project-content' placeholder='此处填写本次历程内容'>
            </div>
          </div>
          <div id="pro_exo_9" class='hiddens form-group line-h-3'>
            <span class='col-md-3 col-lg-2 control-label dis-in-bl ht-px34 hidden-sm hidden-xs'></span>
            <div class='col-md-8'>
              <div class='col-xs-8 col-sm-8 col-md-8 pad-clr'>
                <input placeholder="此处单击填写下方内容发生的时间" class='form-control pad-cr-xs pad-l5-xs chr-c date-time' />
              </div>
            </div>
          </div>
          <div id="pro_exo_9s" class='hiddens form-group mar-b15 mar-b15-xs line-h-3'>
            <div class='col-xs-9 col-sm-10 col-md-offset-3 col-lg-offset-2 col-md-6'>
              <input type='text' class='form-control form-title' id='project-content' placeholder='此处填写本次历程内容'>
            </div>
          </div>
          <!--添加项目历程 结束-->
          <!--添加 删除 开始-->
          <div class="form-group">
            <!--col-sm-offset-2-->
            <div class="col-xs-4 col-sm-3 col-md-offset-3 col-md-3 col-lg-offset-2 col-lg-2">
              <button id="add_Pro_Exp" type="button" class="btn btn-1 bgc-2 fs-c-1 zxz wid-2 wid-2-xs">添加</button>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-2">
              <button id="del_Pro_Exp" type="button" class="hiddens btn btn-1 bgc-2 fs-c-1 zxz wid-2 wid-2-xs">删除</button>
            </div>
          </div>
          <!--添加 删除 结束-->

          <!--目前需求 开始-->
          {{--<div class="form-group mar-b30 line-h-3">--}}
            {{--<label for="invest-area" class="col-sm-12 col-md-3 col-lg-2 control-label pad-cr mar-xs--b"><span class="form-star">*</span>目前需求</label>--}}
            {{--<div class="col-sm-8 col-md-5 col-lg-4">--}}
              {{--<select name="now_need" class="form-control chr-c bg-1" id="invest-area">--}}
                {{--<option value="">请选择需求</option>--}}
                {{--<option value="1">1</option>--}}
                {{--<option value="2">2</option>--}}
                {{--<option value="3">3</option>--}}
              {{--</select>--}}
            {{--</div>--}}
          {{--</div>--}}
          <!--目前需求 结束-->
          <!--需求简述 开始-->
          {{--<div class="form-group mar-b30">--}}
            {{--<label for="project-request" class="col-md-3 col-lg-2 control-label mar-b10 mar-xs--b"><span class="form-star">*</span>简述需求</label>--}}
            {{--<div class="col-md-8 col-lg-8">--}}
              {{--<textarea name="brief_need" class="form-control text-r ht-8" id="project-request" placeholder=""></textarea>--}}
            {{--</div>--}}
          {{--</div>--}}
          <!--需求简述 结束-->
          <!--上传logo 开始 -->
          <div class="form-group mar-b30">
            <input id="logoUrl" style="border:0;position: absolute;z-index: -1;" type="text" name="logo_img" value="">
            <label for="upload-logo" class="col-md-3 col-lg-2 control-label pad-cr mar-xs--b"><span class="form-star">*</span>上传logo</label>
            <div class="col-md-5 col-lg-5">
              <div id="logo" class="col-md-6">
                <div class="avatar-view" title="">
                  <img src="{{ asset('home/img/upload-card.png') }}" alt="Logo">
                </div>
              </div>
            </div>
          </div>
          <!--上传 logo 结束-->
          <!--上传banner 开始-->
          <div class="form-group mar-b30">
            <input id="bannerUrl" style="border:0;position: absolute;z-index: -1;" type="text" name="banner_img">
            <label for="upload-banner" class="col-md-3 col-lg-2 control-label pad-cr mar-xs--b"><span class="form-star">*</span>上传banner</label>
            <div class="col-md-5 col-lg-5">
              <div id="banner" class="col-md-6">
                <div class="avatar-view" title="">
                  <img src="{{ asset('home/img/upload-card.png') }}" alt="Logo">
                </div>
              </div>
            </div>
          </div>
          <!--上传banner 结束-->

          <!--添加核心成员 开始-->
          <div class="form-group mar-b15 line-h-3">
            <span class="col-md-3 col-lg-2 control-label mar-b10 dis-in-bl mar-xs--b"><span class="form-star">*</span>核心成员</span>
            <div class="col-md-9 col-lg-10">
              <div class="row mar-clr">
                <label for="member-name" class="col-xs-3 col-sm-2 col-md-2 col-lg-1 control-label pad-clr mar-b10 text-c-sm text-c-xs">名字</label>
                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-3 pad-clr mar-b10">
                  <input class="form-control pad-cr-xs pad-l5-xs chr-c" id="member-name">
                </div>
                <label for="member-company" class="col-xs-3 col-sm-2 col-md-2 col-lg-1 control-label pad-clr text-l-lg text-l-md mar-b10 text-c-sm text-c-xs">公司</label>
                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-3 pad-clr mar-b10">
                  <input class="form-control pad-cr-xs pad-l5-xs chr-c" id="member-company">
                </div>
                <label for="member-position" class="col-xs-3 col-sm-2 col-md-2 col-lg-1 control-label pad-clr text-l-lg text-l-md mar-b10 text-c-sm text-c-xs">职位</label>
                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-3 pad-clr mar-b10">
                  <input class="form-control pad-cr-xs pad-l5-xs chr-c" id="member-position">
                </div>
              </div>
              <div class="row mar-clr">
                <label for="member-pic" class="col-xs-3 col-sm-2 col-md-2 col-lg-1 control-label pad-clr mar-3 line-h-2 text-c-sm text-c-xs">头像</label>
                <div class="col-xs-9 col-sm-5 col-md-5 col-lg-5 mar-3 pad-cl">
                  <input type="hidden" id="touxiangUrl">
                  <div id="touxiang">
                    <div class="avatar-view">
                      <img src="{{ asset('home/img/upload-card.png') }}" alt="Logo">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row mar-clr">
                <label for="member-introduce" class="col-xs-3 col-sm-2 col-md-2 col-lg-1 control-label pad-clr mar-b10 text-c-sm text-c-xs">简介</label>
                <div class="col-xs-9 col-sm-9 col-md-8 col-lg-8 pad-clr">
                  <textarea class="form-control text-r ht-8" id="member-introduce" placeholder=""></textarea>
                  <input style="border:0;position: absolute;z-index: -1;" type="text" name="team_member">
                </div>
              </div>
            </div>
          </div>
          <!--添加核心成员 结束-->
          <!--添加 删除 开始-->
          <div class="form-group">
            <div class="col-xs-offset-1 col-xs-4 col-sm-offset-2 col-sm-3 col-md-offset-3 col-md-3 col-lg-offset-2 col-lg-2">
              <button type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz wid-2 wid-2-xs">添加</button>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-2">
              <button type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz wid-2 wid-2-xs">删除</button>
            </div>
          </div>
          <!--添加 删除 结束-->

          <!--上传BP 开始 -->
          <div class="form-group mar-b30">
            <label for="upload-bp" class="col-md-3 col-lg-2 control-label pad-cr mar-xs--b">上传BP(选填)</label>
            <div class="col-md-5 col-lg-5">
              <input type="button" onclick="inputbp.click()" id="upload-bp" class="upload-button zxz">
              <input type="file" id="inputbp" class="hidden" >
            </div>
          </div>
          <!--上传BP 结束-->
          <div class="form-group mar-b30">
            <label for="project-details" class="col-md-3 col-lg-2 control-label mar-b10 mar-xs--b"><span class="form-star">*</span>隐私设置</label>
            <div class="privacy-block col-md-8 col-lg-8">
              <div class="col-md-2 col-lg-2">
              <input name="privacy"  type="radio" value="0">
                <label>保密</label>
              </div>
              <div class="col-md-5 col-lg-5">
                <input name="privacy"  type="radio" value="1">
                <label >可以向投资人公开</label>
              </div>
              <div class="col-md-4 col-lg-4">
                <input name="privacy"  type="radio" value="2" checked>
                <label >向所有人公开</label>
              </div>
            </div>
          </div>
          <!--提交按钮-->
          <div class="form-group">
            <div class="col-xs-4 col-sm-3 col-md-offset-3 col-md-3 col-lg-offset-2 col-lg-2">
              <button type="submit" class="btn btn-1 bgc-2 fs-c-1 zxz wid-2 wid-2-xs">提交</button>
            </div>
          </div>
          <!--提交按钮-->

        </form>
        <!--表单结束-->
        @include('home.public.card')
      </div>
      <!--创建我的项目结束-->
@endsection

@section('script')
  <script src="{{asset('dateTime/build/jquery.datetimepicker.full.js')}}"></script>
  <script src="{{asset('home/js/dateTime.js')}}"></script>
  <script src="{{asset('home/js/projectValidate.js')}}"></script>
  <script src="{{asset('cropper/js/cropper.min.js')}}"></script>
  <script src="{{asset('cropper/js/zxzCooperClass.js')}}"></script>
  <script>
    //添加项目历程
    var zxz ={fun:function () {
      alert(1);
    }}
    function logo() {
      return new CropAvatar($('#logo'),zxz);
    }
    logo();
    var Pro_Exp_Num = 1;
    $('#add_Pro_Exp').click(function () {
      var Pro_Exo = '#pro_exo_'+Pro_Exp_Num;
      var Pro_Exos = '#pro_exo_'+Pro_Exp_Num+'s';
      $(Pro_Exo).toggleClass('hiddens');
      $(Pro_Exos).toggleClass('hiddens');
      Pro_Exp_Num ++
      selectBtn();
    });
    $('#del_Pro_Exp').click(function () {
      Pro_Exp_Num --
      var Pro_Exo = '#pro_exo_'+Pro_Exp_Num;
      var Pro_Exos = '#pro_exo_'+Pro_Exp_Num+'s';
      $(Pro_Exo).toggleClass('hiddens');
      $(Pro_Exos).toggleClass('hiddens');
      $(Pro_Exo+" input").val("");
      $(Pro_Exos+" input").val("");
      selectBtn();
    });
    function selectBtn() {
      if (Pro_Exp_Num ==9){
        $('#add_Pro_Exp').addClass('hiddens');
      }else if (Pro_Exp_Num ==1){
        $('#del_Pro_Exp').addClass('hiddens');
      }else {
        $('#add_Pro_Exp').removeClass('hiddens');
        $('#del_Pro_Exp').removeClass('hiddens');
      }
    }

  </script>
@endsection