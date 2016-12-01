@extends('admin.layouts.master')
<style>
    .loading{z-index:999;position:absolute;display: none;}
    #alert-info{padding-left:10px;}
    table{font-size:14px;}
    .table button{margin-right:15px;}
    #fabu{
        width: 80%;
        height:80%;
    }
    .uploadify{display:inline-block;}
    .uploadify-button{border:none; border-radius:5px; margin-top:8px;}
    table.add_tab tr td span.uploadify-button-text{color: #FFF; margin:0;}
</style>
@section('content')
@section('title', '内容管理')
{{-- 弹出表单开始 --}}
<!--继承组件-->
<!--替换按钮ID-->
@section('form-id', 'myModal')
<!--定义弹出表单ID-->
@section('form-title', '详细信息：')
<!--定义弹出内容-->
@section('form-body')
    <div class="row" id="alert-form"></div>
    <div id="alert-info"></div>
@endsection
<!--定义底部按钮-->
@section('form-footer')
    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
@endsection
{{-- 弹出表单结束 --}}
{{--发布文章表单--}}
<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" id="fabu">
        <div class="modal-content">
            <form data-name="" role="form" id="yz_fb"  onsubmit="return false">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="title">文章发布</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="field-3">文章类型</label>
                                <div for="field-3">
                                    <select class="form-control" id="type" name="type">
                                        <option value="1">市场</option>
                                        <option value="2">政策发布</option>
                                        <option value="3">用户来搞</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="field-1" class="control-label">文章标题</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="article title...">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-5" class="control-label">缩略图</label>
                                <input type="text" size="50" style="width: 150px;" class="lg"  id="banner" name="banner" disabled="true">
                                <input id="file_upload" name="file_upload" type="file" multiple="true">
                                <img src="" id="article_thumb_img" style="max-width: 350px;max-height: 110px;">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="field-1" class="control-label">文章来源</label>
                                <input type="text" class="form-control" id="source" name="source" placeholder="article source...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group no-margin">
                                <label for="field-7" class="control-label">文章简述</label>
                                <textarea class="form-control autogrow" id="brief" name="brief" placeholder="Write something about your article" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;">                                                        </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-12 control-label">文章详情</label>
                        <div class="col-md-12">
                            <textarea id="UE" name="describe" class="describe"></textarea>
                        </div>
                    </div>

                    <meta name="csrf-token" content="{{ csrf_token() }}">

                </div>
                <div class="modal-footer" id="caozuo">
                    <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                    <button type="submit" data-name="" class="article_update btn btn-primary" id="add_article">发布</button>
                </div>
            </form>
        </div>
    </div>
</div><!-- /.modal -->
{{--修改文章表单--}}
<div class="modal fade bs-example-modal-lg" id="xg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">修改文章</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal p-20" data-name="" role="form" id="yz_xg"  onsubmit="return false">
                    <input name="id" type="hidden">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="field-3">文章类型</label>
                                <div for="field-3">
                                    <select class="form-control" id="xg_type" name="type">
                                        <option value="1">市场</option>
                                        <option value="2">政策发布</option>
                                        <option value="3">用户来搞</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9" style="margin-left: 68px;">
                            <div class="form-group">
                                <label for="field-1" class="control-label">文章标题</label>
                                <input type="text" class="form-control" id="xg_title" name="title" placeholder="article title...">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-5" class="control-label">缩略图</label>
                                <input type="text" size="50" style="width: 150px;" class="lg" name="banner" id="charge_banner" disabled="true">
                                <input id="file_charge" name="file_upload" type="file" multiple="true">
                                <img src="" id="charge_thumb_img" style="max-width: 350px;max-height: 110px;">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="field-1" class="control-label">文章来源</label>
                                <input type="text" class="form-control" id="xg_source" name="source" placeholder="article source...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group no-margin">
                                <label for="field-7" class="control-label">文章简述</label>
                                <textarea class="form-control autogrow" id="xg_brief" name="brief" placeholder="Write something about your article" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;">                                                        </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-12 control-label">文章详情</label>
                        <div class="col-md-12">
                            <textarea id="UE1" name="describe" class="describe"></textarea>
                        </div>
                    </div>

                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <center><button type="submit" class="btn btn-success m-l-10">修改</button></center>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="panel-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content p-0 b-0">
            <div class="panel panel-color panel-primary">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="panel-title">请填写否决理由</h3>
                </div>
                <div class="panel-body">
                    <textarea id = "reason" style="width: 100%;"></textarea><br><br>
                    <center><button class="btn btn-success status" id="pass_form">确定</button></center>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{--新的详情页--}}
<div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="full-width-modalLabel" aria-hidden="true" style="display: none;width: 80%;margin-left: 10%">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <center><h2 id="xq_title">“军人”习近平：能战方能止战</h2></center>
                <br>
                <center><h6 class="modal-title" id="xq_time_author">2016-12-13 发表人：郭庆</h6></center>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <center><img id="xq_banner" src="{{asset('uploads/image/admin/road/20161128125029210.jpg')}}"></center>
                        </div>
                    </div>
                    <center><div class="modal-header col-md-12">
                        <center><p id="xq_brief">近日，新浪微博官方公布了一批通过违规手段刷话题阅读数、旨在冲击热门话题榜单的账号，并对话题和主持人做了封号处理，其中市级多位明星大咖、多档综艺节目以及多部热门网剧，明星有“向日葵老师娄艺潇”、“韩寒新单曲刷爆网络”、“蒋劲夫痛哭”等，热门综艺有《姐姐好饿第二季》《偶滴歌神啊》《越策越美丽》等，而《画江湖之不良人》《陈二狗的妖孽人生》《法医秦明》等热门网剧也在封禁之列。</p></center>
                    </div></center>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <p id="xq_describe">近日，新浪微博官方公布了一批通过违规手段刷话题阅读数、旨在冲击热门话题榜单的账号，并对话题和主持人做了封号处理，其中市级多位明星大咖、多档综艺节目以及多部热门网剧，明星有“向日葵老师娄艺潇”、“韩寒新单曲刷爆网络”、“蒋劲夫痛哭”等，热门综艺有《姐姐好饿第二季》《偶滴歌神啊》《越策越美丽》等，而《画江湖之不良人》《陈二狗的妖孽人生》《法医秦明》等热门网剧也在封禁之列。</p><p>　　</p><p>　　重要文娱项目几乎全靠刷榜，而这背后，是近期新浪微博盗取账号现象的屡屡发生，多数被盗账号都被用来刷榜，并形成名为“黑水”刷榜的特有营销方式。随着新浪微博官方的重拳出击，这条灰色产业链的生意，不那么好做了。</p><p>　　热门话题超六成花钱刷</p><p>　　你以为微博话题榜的前几位，都是大家真在讨论搜索的吗</p><p>　　尽管新浪微博不再占据社交媒体中的头把交椅，但微博因最具有开放性，重要性反而越发凸显。诸如王宝强离婚、林丹出轨等热点文娱新闻，总是先在微博上发酵，进而引发全民关注。</p><p>　　对不少营销公司来说，利用微博在引发话题热度上的影响力进行文娱项目或者艺人的推广，成了一条捷径。常年从事微博营销的老默笑言：“你以为微博话题榜的前几位，都是大家真在讨论搜索的吗？太天真了，微博话题榜超过六成靠刷，这就是一门生意。”而一位电影营销公司宣传人员透露，在电影整体宣传费用中，互联网的宣传费用占到40%，其中微博营销占很大比例，“新浪微博的话题次数、热搜次数，已成为一项必备的采购项目。”</p><p>　　不同的时间段和不同的排位顺序，价码也不同。一位知情人士介绍，微博热搜的价格，进前十、进前五和进前三的价码层层递增，而早上、中午、下午、晚上各个时段的价格都不太一样，“按照小时收费，内部的成本价就三四千元，对外开价可达到一万元至两万元。”他也直言，一般都是花钱先刷话题，之后再去刷热搜，一个话题炒热了之后，才做全网。</p><p>　　一个颇不寻常的现象是，微博热搜第五名的位置，似乎常年被刷榜占据。有业内人士透露，湖南卫视的热门综艺《真正男子汉》一播出，周末两天的热搜都在第五名，“小鲜肉”杨洋每次热搜都是刚好卡在第五。而刷榜也出现过乌龙事件，明星叶一茜发了一条女儿森碟的微博，没想到评论里却出现了各种夸综艺节目《一年级·毕业季》嘉宾孙耀琦的内容，刷榜水军跑错了地方，实在无比尴尬。</p><p>　　刷榜水军是怎么炼成的</p><p>　　一条由机器粉转发的微博大概需0.15元，一条评论的价格0.3元</p><p>　　已经有半年多没使用新浪微博的网友“琉球”近期登录微博，惊讶地发现自己的账号在近两个月里，一直在发一些与影视作品或综艺节目相关的营销内容。在经过与微博客服的沟通后，“琉球”确定自己被盗号了，“被”成了一名水军。此前，微博名为“来去之间”的新浪微博CEO王高飞曾转发过这样一条信息：2015年之后没有修改过密码的，理论上都是肉鸡，就看水军想不想用你的账号发博。</p><p>　　盗取别人的微博账号发信息，一般有两种来源，第一种是通过同名账号密码的方式撞开“社工库”，以获得成千上万的账户信息；第二种是以钓鱼网站的方式，窃取授权登录第三方平台的微博账号。这些“黑号”可以找一级或者二级代理商卖出去，在淘宝网输入“新浪微博账号”，根据带粉丝数量多少，从一元五个，到几百元一个的账号都有。</p><p>　　在整个产业链中，因为账号比较便宜，买卖账号属于产业链的低端，真正的“高端消费”是转发和评论。根据一家淘宝店的报价，一条由机器粉(营销号)转发的微博费用大概是0.15元，一条评论的价格是0.3元。相比之下，真人粉要贵得多，转发或者评论一条，至少要1元，有些可能达到十几元。</p><p>　　与此前水军给人留下的简单粗暴的印象不同，如今的水军变得更为“高级”。老默透露，为了让水军看起来更有素养，如今也会玩儿一些套路，“营销公司盗取账号后不一定全都是‘收费’转发冲击话题，也有可能出于‘养号’的目的，参与到一些真实热门话题的互动。”</p><p>　　警告是动真格还是吓唬人</p><p>　　新浪微博官方想要做真正的操盘手，就必须制定严格的游戏规则</p><p>　　新浪微博官方放出的这份违规名单，涉及面如此之广，自然在业界引起了巨大反响。在网络大电影公号主编易南看来，新浪微博官方的重拳出击，也恰恰说明了当前刷榜的情况已到了不得不禁的地步。</p><p>　　对于新浪微博的管制措施，多位在淘宝网上从事刷榜生意的卖家表示，这段时间刷榜不可能再像之前那样无所顾忌了。一位卖家直言：“现在即便告诉客户绝对没问题，官方监测不到，他也会非常慎重，因为每一次刷榜都有可能被封号。”不过，易南认为，新浪的警告会在一段时间内有效，但不可能完全杜绝刷榜现象，“微博水军不可能一下子失业，刷榜也会更走心，以前硬把一个话题往上推，一小时就能推到前三，现在可能分好几天推，先推到前十几，再慢慢推到前十乃至前五。”</p><p>　　事实上，新浪微博方面对于涉嫌使用“黑水”的话题主持人的处理公告，显得颇为耐人寻味：“以下主持人账号如欲继续使用该账号，请于2016年11月30日前，将刷榜所使用营销公司渠道，以及产生相关服务费用的发票、沟通对话记录等证据提供至站方邮箱huati2@sina.com以备核实，站方将酌情考虑解封事宜。月底前不联系站方提供指定资料的，视同放弃账号。”</p><p>　　对于这样的措辞，业内人士王中川道出个中玄机，微博热门话题榜是微博商业化的一部分，几乎所有上榜的文娱项目，理论上都应该是新浪微博的广告客户或合作伙伴。他直言：“新浪微博官方想要做真正的操盘手，就必须制定严格的游戏规则，首先就需要摸清究竟有哪些公司采用合理手段冲榜，哪些公司是‘黑水’的真正掌握者，以及可能存在的灰色地带。”</p><p>　　名词解释</p><p>　　“黑水”：专指通过盗取微博账号的方式冲击话题榜的行为，是当前不少刷榜营销公司惯用的手法。</p><p>　　“肉鸡”：互联网用语，是指可以被黑客远程控制的机器，在文中特指缺乏防护措施，能被随意盗取的微博账号。</p><p>　　“社工库”：在黑客圈指一种获取情报和信息的数据库，里面包含上亿用户名和登录密码。&nbsp;</p><p>　　信源：北京日报。蓝鲸娱乐新浪微博:@蓝鲸娱乐官微；公邮：yule@lanjinger.com。若有任何问题都请联系我们，可直接留言，感谢。</p><p>　　</p><p><br/></p>
                        </div>
                    </div>
                </div>
                <center><div class="modal-header col-md-12">
                        <center><p id="xq_source"></p></center>
                    </div></center>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<button class="btn btn-primary" data-toggle="modal" data-target="#con-close-modal">文章发布</button>
<img src="/admin/images/load.gif" class="loading">

<div class="wraper container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-md-4">
                <div class="col-md-6"><h3 class="title">文章管理</h3></div>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="xz_type" name="xz_type">
                    <option value="1">市场</option>
                    <option value="2">政策</option>
                    <option value="3">用户来稿</option>
                </select>
            </div>
            <div class="col-md-4">
                <button class="btn-primary" id="chakan">查看</button>
            </div>
        </div>
        <div class="btn-group-vertical">
            <div class="btn-group-vertical">
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    已发布
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" data-status="1">
                    <li><a href="#" class="status1" data-user="1">管理员文稿</a></li>
                    <li><a href="#" class="status1" data-user="2">用户来稿</a></li>
                </ul>
            </div>
            <div class="btn-group-vertical">
                <button type="button" data-status="2" class="status1 btn btn-default dropdown-toggle" data-toggle="dropdown">
                    待审核...
                </button>
            </div>
            <div class="btn-group-vertical">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    已下架
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" data-status="3">
                    <li><a href="#" class="status1" data-user="1">管理员文稿</a></li>
                    <li><a href="#" class="status1" data-user="2">用户来稿</a></li>
                </ul>
            </div>
        </div>
        <center><h1 id="list_title">管理员文稿</h1></center>
    </div>
    <div class="panel" id="data"></div>
</div>

@endsection
@section('script')
    <!--alertInfo JS-->
    <script src="http://cdn.rooyun.com/js/classie.js"></script>
    <script src="http://cdn.rooyun.com/js/modaleffects.js"></script>
    <!--引用ajax模块-->
    <script src="JsService/Controller/ajaxController.js" type="text/javascript"></script>
    <script src="JsService/Model/article/articleAjaxBeforeModel.js" type="text/javascript"></script>
    <script src="JsService/Model/article/articleAjaxSuccessModel.js" type="text/javascript"></script>
    <script src="JsService/Model/article/articleAjaxErrorModel.js" type="text/javascript"></script>
    <script src="http://cdn.rooyun.com/js/classie.js"></script>
    <script src="http://cdn.rooyun.com/js/modaleffects.js"></script>
    <!--alertInfo end-->
    <script src="http://cdn.rooyun.com/js/jquery.validate.min.js"></script>
    <!--引用ajax模块-->
    <!--alertInfo end-->
    <script src="{{url('uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="{{url('uploadify/uploadify.css')}}">
    <script type="text/javascript">
        <?php $timestamp = time();?>
        //发布文章-图片上传
        $(function() {
            $('#file_upload').uploadify({
                'buttonText':'选择图片',
                'formData'     : {
                    'timestamp' : '<?php echo $timestamp;?>',
                    '_token'     : "{{csrf_token()}}",
                },
                'swf'      : '{{url('uploadify/uploadify.swf')}}',
                'uploader' : '{{url('/upload')}}',
                'onUploadSuccess':function (file,data,response) {
                    var data = JSON.parse(data);
                    $('#banner').val(data.res);
                    $('#article_thumb_img').attr('src',data.res);
                },
                'onUploadError' : function(file, errorCode, errorMsg, errorString) {
                    alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
                }
            });
            //修改文章-图片上传
            $('#file_charge').uploadify({
                'buttonText':'修改图片',
                'formData'     : {
                    'timestamp' : '<?php echo $timestamp;?>',
                    '_token'     : "{{csrf_token()}}",
                },
                'swf'      : '{{url('uploadify/uploadify.swf')}}',
                'uploader' : '{{url('/upload')}}',
                'onUploadSuccess':function (file,data,response) {
                    var data = JSON.parse(data);
                    $('#charge_banner').val(data.res);
                    $('#charge_thumb_img').attr('src',data.res);
                },
                'onUploadError' : function(file, errorCode, errorMsg, errorString) {
                    alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
                }
            });
        });
    </script>
    <script>
        var list_type = null;
        var list_status = 1;
        var list_user = 1;
        //列表文章类型设置
        function listType(type,status,user) {
            list_type = type;
            list_status = status;
            list_user = user;
            list(type,status,user);
        }
        //分类查看数据
        $('#chakan').click(function(){
            if (list_user == 1){
                listType($('#xz_type').val(),list_status,list_user);
            }
        });

        //状态+用户选择
        $('.status1').off('click').on('click',function () {
            if ($(this).data('status') == 2){
                $('.dropdown-toggle').removeClass('btn-success').addClass('btn-default');
                $(this).addClass('btn-success');
                list_status = 2;
                list_user = 2;
                $('#list_title').html($(this).html());
            }else{
                $('.dropdown-toggle').removeClass('btn-success').addClass('btn-default');
                $(this).parent().parent().siblings('button').addClass('btn-success');
                list_status = $(this).parent().parent().data('status');
                list_user = $(this).data('user');
                $('#list_title').html($(this).parent().html());
            }
            listType(list_type,list_status,list_user);
        });

        {{--修改--}}
                !function($) {
            "use strict";
            var FormValidator = function() {
                this.$signupForm = $("#yz_xg");
            };

            //初始化
            FormValidator.prototype.init = function() {
                //插件验证完成执行操作 可以不写
                $.validator.setDefaults({
                    submitHandler: function() {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        var data = new FormData();
                        var resul={
                            type:$('#yz_xg').find('select[name=type]').val(),
                            title:$('#yz_xg').find('input[name=title]').val(),
                            banner:$('#yz_xg').find('input[name=banner]').val(),
                            source:$('#yz_xg').find('input[name=source]').val(),
                            brief:$('#yz_xg').find('textarea[name=brief]').val(),
                            describe:ue1.getContent(),
                        };
                        console.log(resul);
                        data.append( "type"      , resul.type);
                        data.append( "title"      , resul.title);
                        data.append( "brief"   , resul.brief);
                        data.append( "describe", resul.describe);
                        data.append( "banner", resul.banner);
                        data.append( "source", resul.source);
                        $.ajax({
                            url     : '/article/' + $('input[name=id]').val() + '?user='+list_user,
                            type:'put',
                            data:resul,
                            before  : ajaxBeforeNoHiddenModel,
                            success : check,
                            error   : ajaxErrorModel
                        });
                        function check(data){
                            console.log(data);
                            $('.loading').hide();
                            $('#myModal').modal('show');
                            $('#alert-form').html('');
                            $('.modal-title').html('提示');
                            if (data) {
                                if (data.StatusCode == 200) {
                                    $('.bs-example-modal-lg').modal('hide');
                                    $('#alert-info').html('<p>文章修改成功!</p>');
                                    listType(resul.type,list_status,list_user);
                                } else {
                                    $('#alert-info').html('<p>' + data.ResultData + '</p>');
                                }
                            } else {
                                $('#alert-info').html('<p>未知的错误</p>');
                            }
                        }
                    }
                });
                this.$signupForm.validate({
                    rules: {
                        type: {
                            required: true,
                        },
                        title: {
                            required: true,
                        },
                        source: {
                            required: true
                        },
                        brief:{
                            required: true
                        },
                        describe:{
                            required: true,
                        },
                        banner:{
                            required: true,
                        }
                    },
                    //提示信息
                    messages: {
                        type: {
                            required: '请输入文章类型'
                        },
                        title: {
                            required: '请输入文章标题'
                        },
                        brief:{
                            required: '请输入文章简述'
                        },
                        source:{
                            required: '请输入文章来源'
                        },
                        describe:{
                            required: '请输入路演详情'
                        },
                        banner:{
                            required: '缩略图不能为空'
                        }
                    }
                });

            },
                    //init
                    $.FormValidator = new FormValidator,
                    $.FormValidator.Constructor = FormValidator
        }(window.jQuery),
                function($) {
                    "use strict";
                    $.FormValidator.init()
                }(window.jQuery);

        //发布
        !function($) {
            "use strict";
            var FormValidator = function() {
                this.$signupForm = $("#yz_fb");
            };

            //初始化
            FormValidator.prototype.init = function() {
                //插件验证完成执行操作 可以不写
                $.validator.setDefaults({
                    submitHandler: function() {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        var data = new FormData();
                        var resul={
                            type:$('select[name=type]').val(),
                            title:$('input[name=title]').val(),
                            banner:$('input[name=banner]').val(),
                            source:$('input[name=source]').val(),
                            brief:$('textarea[name=brief]').val(),
                            describe:$('textarea[name=describe]').val(),
                        };
                        console.log(resul);
                        data.append( "type"      , resul.type);
                        data.append( "title"      , resul.title);
                        data.append( "brief"   , resul.brief);
                        data.append( "describe", resul.describe);
                        data.append( "banner", resul.banner);
                        data.append( "source", resul.source);
                        $('#alert-info').html();
                        $.ajax({
                            url     : '/article',
                            type:'post',
                            data:resul,
                            before  : ajaxBeforeNoHiddenModel,
                            success : check,
                            error   : ajaxErrorModel
                        });
                        function check(data){
                            $('.loading').hide();
                            $('#myModal').modal('show');
                            $('#alert-form').html('');
                            $('.modal-title').html('提示');
                            console.log(data);
                            if (data) {
                                if (data.StatusCode == 200) {
                                    $('#con-close-modal').modal('hide');
                                    $('#alert-info').html('<p>文章发布成功!</p>');
                                    $('#yz_fb').find('input[name=title]').val('');
                                    $('#yz_fb').find('input[name=source]').val('');
                                    $('#yz_fb').find('input[name=banner]').val('');
                                    $('#article_thumb_img').attr('src','');
                                    $('#yz_fb').find('textarea[name=brief]').val('');
                                    ue.setContent('');
                                    list(resul.type,list_status,list_user);
                                } else {
                                    $('#alert-info').html('<p>' + data.ResultData + '</p>');
                                }
                            } else {
                                $('#alert-info').html('<p>未知的错误</p>');
                            }
                        }

                    }
                });
                this.$signupForm.validate({
                    rules: {
                        type: {
                            required: true,
                        },
                        title: {
                            required: true,
                            maxlength:50
                        },
                        source: {
                            required: true,
                            maxlength:50
                        },
                        brief:{
                            required: true,
                            rangelength:[40,100]
                        },
                        describe:{
                            required: true,
                            minlength:50
                        },
                        banner:{
                            required: true,
                        }
                    },
                    //提示信息
                    messages: {
                        type: {
                            required: '请选择文章类型',
                        },
                        title: {
                            required: '请输入文章标题',
                            maxlength:'标题最多50个字符'
                        },
                        brief:{
                            required: '请输入文章简述',
                            rangelength:'请输入40-100个字符作为简述'
                        },
                        source:{
                            required: '请输入文章来源',
                            maxlength:'来源最多50个字符'
                        },
                        describe:{
                            required: '请输入文章详情',
                            minlength:'详情长度最少50个字符'
                        },
                        banner:{
                            required: '缩略图不能为空'
                        }
                    }
                });

            },
                    $.FormValidator = new FormValidator,
                    $.FormValidator.Constructor = FormValidator
        }(window.jQuery),
                function($) {
                    "use strict";
                    $.FormValidator.init()
                }(window.jQuery);

        //修改文章信息展示旧的信息
        function updateArticle() {
            $('.charge-road').click(function () {
                $('.loading').hide();
                var ajax = new ajaxController();
                ajax.ajax({
                    url     : '/article/' + $(this).data('name') +'?user=' + list_user,
                    before  : ajaxBeforeNoHiddenModel,
                    success : date,
                    error   : ajaxErrorModel
                });
            });
        }

        //展示文章信息详情
        function showInfo() {
            $('.info').click(function () {
                var ajax = new ajaxController();
                ajax.ajax({
                    url     : '/article/' + $(this).data('name') + '?user=' + list_user,
                    before  : ajaxBeforeNoHiddenModel,
                    success : showInfoList,
                    error   : ajaxErrorModel
                });
            });
        }

        // 修改文章信息状态
        function modifyStatus() {
            $('.status').off('click').click(function () {
                var _this = $(this);
                var ajax = new ajaxController();

                var url = '/article/'+ $(this).data('name') + '/edit/?status=' + $(this).data('status')+'&user='+list_user;
                if($(this).data('status') == 3 && list_user == 2){
                    url = '/article/'+ $(this).data('name') + '/edit/?status=' + $(this).data('status')+'&user='+list_user+'&reason='+$('#reason').val();
                }
                ajax.ajax({
                    url     : url,
                    before  : ajaxBeforeNoHiddenModel,
                    success : checkStatus,
                    error   : ajaxErrorModel
                });

                function checkStatus(data){
                    $('.loading').hide();
                    $('#myModal').modal('show');
                    $('.modal-title').html('提示');
                    if (data) {
                        if (data.StatusCode == 200) {
                            var code = data.ResultData;
                            $('#alert-form').hide();
                            _this.data('status', code);
                            if (_this.children().hasClass("btn-danger")) {
                                _this.children().removeClass("btn-danger").addClass("btn-primary").html('启用');
                            } else if (_this.children().hasClass("btn-primary")) {
                                _this.children().removeClass("btn-primary").addClass("btn-danger").html('禁用');
                            }
                            $('#panel-modal').modal('hide');
                            $('#alert-info').html('<p>状态修改成功!</p>');
                            listType(list_type,list_status,list_user);
                        } else {
                            $('#alert-form').hide();
                            $('#alert-info').html('<p>状态修改失败！</p>');
                        }
                    } else {
                        $('#alert-form').hide();
                        $('#alert-info').html('<p>未知的错误</p>');
                    }
                }
            });

            $('#pass').click(function () {
                $('#pass_form').attr('data-name',$(this).data('name'));
                $('#pass_form').attr('data-status',$(this).data('status'));
            });


        }

        // 页面加载时触发事件请求分页数据
        function list(type,status,user) {
            var ajax = new ajaxController();
            ajax.ajax({
                url     : '/article/create?type='+type+'&status='+status+'&user='+user,
                before  : ajaxBeforeModel,
                success : getInfoList,
                error   : ajaxErrorModel,
            });
        }
        listType(list_type,list_status,list_user);
    </script>
@endsection
