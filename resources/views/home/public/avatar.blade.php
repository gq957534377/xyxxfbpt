<div class="" id="crop-avatar">

    <!-- Current avatar -->
    <div class="avatar-view">
        <img id="head-pic" class="img-circle" src="{{asset('cropper/img/picture.jpg')}}" alt="Avatar" style="width: 71px;"/>
    </div>

    <!-- Cropping modal -->
    <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="avatar-form" action="{{url('/headpic')}}" enctype="multipart/form-data" method="post">
                    {{ csrf_field()}}
                    <input type="hidden" name="guid" value="{{session('user')->guid}}">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>
                        <h4 class="modal-title" id="avatar-modal-label">更换头像</h4>
                    </div>
                    <div class="modal-body">
                        <div class="avatar-body">

                            <!-- Upload image and data -->
                            <div class="avatar-upload">
                                <input class="avatar-src" name="avatar_src" type="hidden"/>
                                <input class="avatar-data" name="avatar_data" type="hidden"/>
                                <label for="avatarInput">头像上传</label>
                                <input class="avatar-input" id="avatarInput" name="avatar_file" type="file"/>
                            </div>

                            <!-- Crop and preview -->
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
                                        <button class="btn btn-info" data-method="rotate" data-option="-90" type="button" title="Rotate -90 degrees">向左转</button>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-info" data-method="rotate" data-option="90" type="button" title="Rotate 90 degrees">向右转</button>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-info btn-block avatar-save" type="submit">更换</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal -->

    <!-- Loading state -->
    <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
</div>