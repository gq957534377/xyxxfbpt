<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
    /**
     *
     * @param string url url地址
     * @param string type 传送方式(get||post)
     * @param formObject formObj(form表单)
     * @param Boolean async
     * @param Boolean cache
     * @param Boolean processData
     * @constructor
    */

    function AjaxWork(url,type,formObj,async,cache,processData) {
        this.url   = url;
        this.type  = type;
        this.data  = new FormData($(formObj)[0]) || null;
        this.async = async || true;
        this.cache = cache || true;
        this.processData = processData || true;
    }

    AjaxWork.prototype.upload =function (data,success,error,before) {
        $.ajax({
            url :this.url,
            type :this.type,
            data : data || this.data,
            async : this.async,
            cache : this.cache,
            contentType : this.contentType,
            processData : this.processData,
            success : success || null,
            error : error || null,
            beforeSend : before || null
        })
    }
</script>