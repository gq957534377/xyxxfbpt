<!--申请成为投资人 Start-->
<div class="main-col col-md-9 left-col" style="margin-top: 15px;">
    <div id="investorBox" class="panel panel-default padding-md" style="display: none;position: relative;z-index: 1;">
        <div class="panel-body ">
            <div style="height: 60px;">
                <h2><i class="fa fa-cog" aria-hidden="true"></i>申请成为投资者</h2>
            </div>
            <hr>
            <form id="investorForm"  class="form-horizontal" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">真实姓名</label>
                    <div class="col-sm-6">
                        <input class="form-control" name="investor_name" type="text" placeholder="请输入真实姓名"></div>
                    <div class="col-sm-4 help-block">请填写真实信息哦！</div></div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">性别</label>
                    <div class="col-sm-6">
                        <label class="radio-inline">
                            <input class="sex1" name="investor_sex" value="1" type="radio">男
                        </label>
                        <label class="radio-inline">
                            <input class="sex0" name="investor_sex" value="2" type="radio">女
                        </label></div></div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">出生年月</label>
                    <div class="col-sm-6">
                        <input class="form-control" name="investor_birthday" type="text" placeholder="请输入出生年月"></div>
                    <div class="col-sm-4 help-block">如:19931127！</div></div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">籍贯</label>
                    <div class="col-sm-6">
                        <input class="form-control" name="investor_hometown" type="text" placeholder="请输入籍贯"></div>
                    <div class="col-sm-4 help-block">如:湖北省武汉市！</div></div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">手机号</label>
                    <div class="col-sm-6">
                        <input class="form-control" name="investor_tel" type="text" maxlength="11" placeholder="请输入手机号"></div>
                    <div class="col-sm-4 help-block">如:18866669999！</div></div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">身份证号码</label>
                    <div class="col-sm-6">
                        <input class="form-control" name="investor_number" type="text" maxlength="18" placeholder="请输入真实的身份证证件号"></div>
                    <div class="col-sm-4 help-block">如:888888888888888888888！</div></div>

                {{--<div class="form-group">--}}
                {{--<label for="" class="col-sm-2 control-label">证件照</label>--}}
                {{--<div class = "col-sm-6">--}}
                {{--<div id="card_box" style="margin-top: 30px;">--}}
                {{--<button class="btn btn-info btn-sm" type="button" id="card_a">身份证正面</button>--}}
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
                        <input class="form-control" name="orglocation" type="text" placeholder="请输入机构所在地"></div>
                    <div class="col-sm-4 help-block">如:湖北武汉市</div></div>

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
                        <button class="btn btn-info" id="applyInvestor" >提交申请</button></div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--申请成为投资人 End-->