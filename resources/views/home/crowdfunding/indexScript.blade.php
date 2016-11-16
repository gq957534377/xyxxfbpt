<script>
    $(function () {
        var fun1 = function (jsonObj) {
            var json = jsonObj;
            for(var key in json){
                $("#"+key).html(json[key]);
            }
        }
        ajaxRequestGet("/crowd_funding/create",fun1)
    })
</script>