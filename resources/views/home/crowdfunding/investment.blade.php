@extends("home.layouts.index")
@section('content')
    <div style="margin: 0 auto;width: 700px;padding: 150px 0;">
    <input type="text" id="money" class="form-control" style="margin-bottom: 30px;"/>
    <div id="msgInfo" style="position:absolute;color: red;margin-top: -30px;display: none;">此框不可为空!</div>
    <button id="btnSub" class="btn btn-success" style="margin: 0 auto;display: block;">提交</button>
</div>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script>
        $("#money").focus(function () {
            $("#msgInfo").hide();
        })
        $("#money").keyup(function () {
            var str = parseInt($(this).val());
            if(isNaN(str)) {
                alert("请输入数字！");
                $(this).val("");
            }else{
                $(this).val(str)
            }
        })
        $("#btnSub").click(function () {
            var str = $("#money").val();
            if(str == ""){
                $("#msgInfo").show();
                return;
            }
            var num = parseInt($("#money").val());
            if(isNaN(num)) {
                alert("请输入数字！");
                $("#money").val("");
                return;
            }else{
                $("#money").val(num)
            }
            ajaxRequest();
        })
        function ajaxRequest() {
            var money = $("#money").val();
            var token = "{{csrf_token()}}";
            $.ajax({
                url:"/crowd_funding/"+"{{$project_id}}",
                type:"PUT",
                data:{_token:token,money:money},
                success:function (data) {
                    if(data.StatusCode == 200){
                        alert(data.ResultData)
                        window.location.href="/crowd_funding"
                    }else {
                        alert(data.ResultData)
                    }
                }
            })
        }
    </script>
@endsection
