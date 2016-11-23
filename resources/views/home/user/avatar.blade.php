<!--修改头像弹出层 start-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">更换头像</h4>
            </div>
            <form method="POST" id="headPicForm" enctype="muitipart/form-data" >
                <input type="hidden" mame="_method" value="put">
                <div class="modal-body">
                    <img id="headpic" src="{{asset('home/images/man1.jpg')}}" class="img-circle" style="width: 147px;height: 138.88px;"><br>
                    <input type="file" name="headpic" />
                </div>
            </form>
            <div class="modal-footer">
                <button id="changeHead" type="button" class="btn btn-info">更换</button>
            </div>
        </div>
    </div>
</div>
<!--修改头像弹出层 end-->