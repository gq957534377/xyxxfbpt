@extends('home.layouts.index')
@section('content')
    <section id="contact-page">
        <div class="container main-container">
            <div class="users-show">
                <!--侧边菜单栏 Start-->
                @include('home.user.side')
                <!--侧边菜单栏 End-->
                <!--申请成为投资人 Start-->
                <div class="main-col col-md-9 left-col" style="margin-top: 15px;">
                    <div id="investorBox" class="panel panel-default padding-md" >
                        <div class="panel-body ">
                            <div style="height: 60px;">
                                <h2><i class="fa fa-cog" aria-hidden="true"></i>申请成为投资者</h2>
                            </div>
                            <hr>
                            <form id="investorForm"  class="form-horizontal" action="#" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">真实姓名</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="realname" type="text" placeholder="请输入真实姓名"></div>
                                    <div class="col-sm-4 help-block">请填写真实信息哦！</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">性别</label>
                                    <div class="col-sm-6">
                                        <label class="radio-inline">
                                            <input class="sex1" name="sex" value="1" type="radio">男
                                        </label>
                                        <label class="radio-inline">
                                            <input class="sex0" name="sex" value="2" type="radio">女
                                        </label></div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">出生年月</label>
                                    <div class="col-sm-6">
                                        <input class="form-control some_class" name="birthday" type="text" placeholder="请输入出生年月"></div>
                                    <div class="col-sm-4 help-block">如:19931127！</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">籍贯</label>
                                    <div class="col-sm-6">
                                        <div id="demo" class="citys">
                                            <p>
                                                <select  name="province"></select>
                                                <select  name="city"></select>
                                                <select  name="area"></select>
                                            </p>
                                            <input id="place" class="form-control" name="hometown" value="" type="text" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 help-block">如：湖北省武汉市光谷大道</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">手机号</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="tel" type="text" maxlength="11" placeholder="请输入手机号"></div>
                                    <div class="col-sm-4 help-block">如:18866669999！</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">身份证号码</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="card_number" type="text" maxlength="18" placeholder="请输入真实的身份证证件号"></div>
                                    <div class="col-sm-4 help-block">如:888888888888888888888！</div></div>

                                {{--<div class="form-group">--}}
                                {{--<label for="" class="col-sm-2 control-label">证件照</label>--}}
                                {{--<div class = "col-sm-6">--}}
                                {{--<div id="card_box" style="margin-top: 30px;">--}}
                                {{--<button class="btn btn-info btn-sm" type="button" id="card_pic_a">身份证正面</button>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--<!--隐藏表单区-->--}}
                                {{--<input  type ='hidden' name = "investor_carda"/>--}}
                                {{--<input type="hidden" id="cardmain" value="http://ogd29n56i.bkt.clouddn.com/">--}}
                                {{--<input type="hidden" id="card_url" value="{{url('project/getuptoken/edit')}}">--}}

                                {{--<div class = "col-sm-10 col-sm-offset-1">--}}
                                {{--<table class="table table-striped table-hover"   style="margin-top:40px;display:none">--}}
                                {{--<thead>--}}
                                {{--<tr>--}}
                                {{--<th class="col-md-4">文件名</th>--}}
                                {{--<th class="col-md-2">大小</th>--}}
                                {{--<th class="col-md-6">详情</th>--}}
                                {{--</tr>--}}
                                {{--</thead>--}}
                                {{--<tbody id="card_body">--}}
                                {{--</tbody>--}}
                                {{--</table>--}}
                                {{--</div>--}}
                                {{--</div>--}}

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">机构名称</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="orgname" type="text" placeholder="请输入机构名称"></div>
                                    <div class="col-sm-4 help-block">如:坚固控股有限集团</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">机构所在地</label>
                                    <div class="col-sm-6">
                                        <div id="demo1" class="citys">
                                            <p>
                                                <select  name="province"></select>
                                                <select  name="city"></select>
                                                <select  name="area"></select>
                                            </p>
                                            <input id="place1" class="form-control" name="orglocation" value="" type="text" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 help-block">如：湖北省武汉市光谷大道</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">资金规模</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="fundsize" type="text" placeholder="请输入机构资金规模"></div>
                                    <div class="col-sm-4 help-block"></div>如:1000000美元</div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">投资领域</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="field" type="text" placeholder="请输入投资领域"></div>
                                    <div class="col-sm-4 help-block">如:互联网行业</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">行业描述</label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" name="orgdesc" maxlength="500" placeholder="请对贵机构所在的行业中的地位描述，总字数不超过800个。"></textarea></div>
                                    <div class="col-sm-4 help-block">如:互联网</div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">从业年限</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="workyear" type="text" maxlength="2" placeholder="请输入从业年限"></div>
                                    <div class="col-sm-4 help-block"></div></div>

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">投资规模</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="scale" type="text" placeholder="规模以万为单位"></div>
                                    <div class="col-sm-4 help-block"></div></div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-6">
                                        <input class="btn btn-info" id="applyInvestor" value="提交申请" type="button">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--申请成为投资人 End-->
            </div>
        </div><!--/.container-->
    </section><!--/#contact-page-->
@endsection
@section('script')
    <script>
        $(function(){
            var guid = $("#userinfo").val();
            var realname = $("input[name='realname']");
            var hometown = $("input[name='hometown']");
            var birthday = $("input[name='birthday']");
            var card_number = $('input[name="card_number"]');
            var headpic = $('#headpic');
            var sex = $("input[name='sex']");
            var sex0 = $(".sex0");
            var sex1 = $(".sex1");
            var tel = $("input[name='tel']");
            var orgname = $("input[name='orgname']");
            var orglocation = $("input[name='orglocation']");
            var fundsize = $("input[name='fundsize']");
            var field = $("input[name='field']");
            var orgdesc = $("textarea[name='orgdesc']");
            var workyear = $("input[name='workyear']");
            var scale = $("input[name='scale']");
            var width = $("#userBox").width()/2 -40;
            var height = $("#userBox").height()/2 -50;
            //异步获取
            $.ajax({
                type: "get",
                url: '/roleinfo'+'/'+guid,
                beforeSend:function(){
                    $(".loading").css({'width':'80px','height':'80px','left':width,'top':height}).show();
                },
                success: function(msg){
                    // 将传过json格式转换为json对象
                    switch(msg.StatusCode){
                        case '200':
                            headpic.attr('src','uploads/image/'+msg.ResultData.msg.headpic);
                            realname.empty().val(msg.ResultData.msg.realname);
                            card_number.empty().val(msg.ResultData.msg.card_number);
                            hometown.empty().val(msg.ResultData.msg.hometown);
                            birthday.empty().val(msg.ResultData.msg.birthday);
                            msg.ResultData.msg.sex == 1?sex1.attr('checked','true'):sex0.attr('checked','true');
                            tel.empty().val(msg.ResultData.msg.tel);
                            orgname.empty().val(msg.ResultData.msg.orgname);
                            orglocation.empty().val(msg.ResultData.msg.orglocation);
                            fundsize.empty().val(msg.ResultData.msg.fundsize);
                            field.empty().val(msg.ResultData.msg.field);
                            orgdesc.empty().val(msg.ResultData.msg.orgdesc);
                            workyear.empty().val(msg.ResultData.msg.workyear);
                            scale.empty().val(msg.ResultData.msg.scale);

                            $(".loading").hide();
                            break;
                        case '404':
                            alert(msg.ResultData);
                            $(".loading").hide();
                            break;
                        case '500':
                            alert(msg.ResultData);
                            $(".loading").hide();
                            break;
                    }
                }
            });
            // 城级联动
            $('#demo').citys({
                required:false,
                nodata:'disabled',
                onChange:function(data){
                    var text = data['direct']?'(直辖市)':'';
                    $('#place').val(data['province']+text+' '+data['city']+' '+data['area']);
                }
            });
            $('#demo1').citys({
                required:false,
                nodata:'disabled',
                onChange:function(data){
                    var text = data['direct']?'(直辖市)':'';
                    $('#place1').val(data['province']+text+' '+data['city']+' '+data['area']);
                }
            });
            // 申请成为投资者
            $("#applyInvestor").click(function(){
                var formData = new FormData(document.getElementById("investorForm"));
                formData.append('guid',guid);
                ajaxRequire('/user/apply','POST',formData,$('#investorForm'),1);
            });
        });
    </script>
    @include('home.user.ajax.ajaxRequire')
    @include('home.public.dateTime')
@endsection