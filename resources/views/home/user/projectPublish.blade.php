<!--项目发布弹出层 start-->
<div class="modal fade" id="_projectPunlish" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">项目发布</h4>
            </div>
            <!--引入项目发布表单元素-->
            <form id = "projectForm" class="form-horizontal" style="padding-bottom: 20px;">
                <div class = "col-sm-10 col-sm-offset-1">
                    <input id='title' name='title' type="text" class="form-control _input" placeholder="请输入项目标题">
                    <input id='habitude' name='habitude' type="text" class="form-control _input" placeholder="请输入项目性质">
                    <input id='less_funding' name='less_funding' type="text" class="form-control _input" placeholder="请输入起步资金">
                    <input id='cycle' name='cycle' type="text" class="form-control _input" placeholder="请输入项目周期">
                    <textarea id='content' name='content' class="form-control _input" rows="4" placeholder="请输入项目简介（50字以内）"></textarea>
                    <select id='project_type' name = 'project_type' style="float: left;">
                        <option>请选择项目分类</option>
                        <option value = '1'>新品上架</option>
                        <option value = '2'>健康生活</option>
                        <option value = '3'>热门推荐</option>
                        <option value = '4'>新品上架</option>
                        <option value = '5'>健康生活</option>
                        <option value = '6'>健康生活</option>
                        <option value = '7'>健康生活</option>
                        <option value = '8'>健康生活</option>
                    </select>
                </div>
                <div class = "col-sm-6">
                    <div id="img_container" style="margin-top: 30px;">
                        <button class="btn btn-info btn-sm" type="button" id="img_pick">选择图片</button>
                        <button class="btn btn-info btn-sm" type="button" id="file_pick">选择资料</button>
                    </div>
                </div>
                <!--隐藏表单区-->
                <input  type ='hidden' name = "image"/>
                <input  type ='hidden' name = "file"/>
                <input type="hidden" id="domain" value="http://ogd29n56i.bkt.clouddn.com/">
                <input type="hidden" id="uptoken_url" value="{{url('project/getuptoken/edit')}}">

                <div class = "col-sm-10 col-sm-offset-1">
                    <table id='pro_list_table' class="table table-striped table-hover"   style="margin-top:40px;display:none">
                        <thead>
                        <tr>
                            <th class="col-md-4">文件名</th>
                            <th class="col-md-2">大小</th>
                            <th class="col-md-6">详情</th>
                        </tr>
                        </thead>
                        <tbody id="fsUploadProgress">
                        </tbody>
                        <tbody id="fsUploadProgress2">
                        </tbody>
                    </table>
                </div>
                <button class="btn btn-info" type="submit" style="margin-left: 70%;margin-top: 40px;">提交</button>
            </form>
            <img src="{{asset('home/images/load.gif')}}" class="loading pull-right" style="left:45%;top:45%;position: absolute;z-index: 9999;" >


        </div>
    </div>
</div>
<!--项目发布弹出层 end-->