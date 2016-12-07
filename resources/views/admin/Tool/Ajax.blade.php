<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
    /**
     * 初始化数据
     * @param string url url地址
     * @param string type 传送方式(get||post)
     * @param formObject formObj(form表单)
     * @param Boolean async 异步或同步
     * @param Boolean cache 缓存
     * @param Boolean processData 处理数据，处理转化成一个查询字符串
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
    /**
     * 实例化
     * @param data
     * @param success
     * @param error
     * @param before
     */
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