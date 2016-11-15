<!-- 按钮触发模态框 -->
<button id="promptModal" class="btn btn-primary btn-sm hidden" data-toggle="modal" data-target="#myModalqq" style="width: 0px;height: 0px;margin: 0px;padding: 0px;display: none;">提示</button>
<!-- 提示消息模态框（Modal） -->
<div id="promptBox">

</div>


<script>
    // 错误提示模态框
    function promptBox(title,body){
        var html = "";
        html += '<div class="modal fade modal-sm" id="myModalqq" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
        html += '  <div class="modal-dialog modal-sm">';
        html += '     <div class="modal-content">';
        html += '        <div class="modal-header">';
        html += '          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times;</button>';
        html += '          <h4 class="modal-title" id="myModalLabel"> '+title+'  </h4>';
        html += '        </div>';
        html += '        <div class="modal-body">';
        html += body;
        html += '        </div>';
        html += '        <div class="modal-footer">';
        html += '            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>';
        html += '        </div>';
        html += '     </div><!-- /.modal-content -->';
        html += '  </div><!-- /.modal --> ';
        html += '</div>';
        $("#promptBox").append(html);
    }

    // 触发
    function promptBoxHandle(title,body)
    {
        promptBox(title,body);
        $('#promptModal').click();
    }

</script>