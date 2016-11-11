<script>
    $(function () {
        var fun1 = function (jsonObj) {
            var json = jsonObj;
            for(var key in json){
                $("#"+key).html(json[key]);
            }
        }
        ajaxRequestGet("index_ajax",fun1)
    })
</script>