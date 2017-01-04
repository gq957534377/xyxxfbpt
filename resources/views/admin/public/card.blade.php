<div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">

    <img class="loading"  src="{{ asset('/admin/images/load.gif') }}" style="position: absolute;left: 43%;top: 30%;"/>

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="avatar-form" action="/web_admins/uploadorganizpic" enctype="multipart/form-data" method="post">
                <input class="organiz-type" name="organiz-type" value="2" type="hidden">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" type="button">&times;</button>
                    <h4 class="modal-title" id="avatar-modal-label">添加</h4>
                </div>
                <div class="modal-body">
                    <div class="avatar-body">
                        <div class="row text-coutent">
                            <div class="col-sm-6">
                                <label for="inputEmail3" class="col-sm-3 control-label">name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" data-method="coopname" name="name" placeholder="name">
                                </div>
                            </div>
                        </div>
                        <div class="row text-coutent">
                            <div class="col-sm-6">
                                <label for="inputEmail3" class="col-sm-3 control-label">url</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="url" placeholder="格式：http://您的链接地址">
                                </div>
                            </div>
                        </div>
                        <hr class="text-coutent">
                        <div class="avatar-upload">
                            <input class="avatar-scale" name="avatar-scale" value="1.6" type="hidden">
                            <input class="avatar-src" name="avatar_src" type="hidden">
                            <input class="avatar-data" name="avatar_data" type="hidden">
                            <label for="avatarInput">图片上传</label>
                            <input class="avatar-input" id="avatarInput" name="avatar_file" type="file"></div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="avatar-wrapper"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="avatar-preview preview-lg"></div>
                                <div class="avatar-preview preview-md"></div>
                                <div class="avatar-preview preview-sm"></div>
                            </div>
                        </div>
                        <div class="row avatar-btns">
                            <div class="col-md-9">
                                <div class="btn-group">
                                    <button class="btn" data-method="rotate" data-option="-90" type="button" title="Rotate -90 degrees"><i class="fa fa-undo"></i> 向左旋转</button>
                                </div>
                                <div class="btn-group">
                                    <button class="btn" data-method="rotate" data-option="90" type="button" title="Rotate 90 degrees"><i class="fa fa-repeat"></i> 向右旋转</button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-success btn-block avatar-save" type="submit"><i class="fa fa-save"></i> 保存修改</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

