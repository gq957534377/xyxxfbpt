<!--申请成为创业者 start-->
<div class="modal fade" id="myModal_1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">创业者申请</h4>
            </div>
            <img src="{{asset('home/images/load.gif')}}" class="loading pull-right" style="left:45%;top:45%;position: absolute;z-index: 9999;" >
            <form id="entrepreneur" class="form-horizontal" method="POST" action="#" accept-charset="UTF-8" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">真实姓名</label>
                    <div class="col-sm-6">
                        <input class="form-control" name="realname" type="text"></div>
                    <div class="col-sm-4 help-block">如：李小明</div></div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">
                        身份证号码
                    </label>
                    <div class="col-sm-6">
                        <input class="form-control" name="card_number" type="text"></div>
                    <div class="col-sm-4 help-block">如：363636201611110012</div></div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">籍贯</label>
                    <div class="col-sm-6">
                        <input class="form-control" name="hometown" value="" type="text"></div>
                    <div class="col-sm-4 help-block">如：湖北省武汉市光谷大道</div></div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">生日</label>
                    <div class="col-sm-6">
                        <input class="form-control" name="birthday" value="" type="text"></div>
                    <div class="col-sm-4 help-block">如：19931127</div></div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">性别</label>
                    <div class="col-sm-6">
                        <input class="sex1" name="sex" value="1" type="radio">男
                        <input class="sex0" name="sex" value="0" type="radio">女</div></div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">手机号</label>
                    <div class="col-sm-6">
                        <input class="form-control" name="tel" type="text"></div>
                    <div class="col-sm-4 help-block">如：18870913609</div></div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">身份证正面</label>
                    <div class="col-sm-6">
                        <input type="file" class="form-control" name="card_pic_a" type="text"></div>
                    <div class="col-sm-4 help-block">如：</div></div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">身份证反面</label>
                    <div class="col-sm-6">
                        <input type="file" class="form-control" name="card_pic_b" type="text"></div>
                    <div class="col-sm-4 help-block">如：</div></div>

                <div class="modal-footer">
                    <input class="btn btn-info" id="applySubmit" value="提交申请" type="button">
                </div>
            </form>
        </div>
    </div>
</div>
<!--申请成为创业者 end-->