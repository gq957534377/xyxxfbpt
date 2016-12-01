function Activity(){
    Activity.prototype.ajax = function(url,type,data,success){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:url,
            type:type,
            data:data,
            beforeSend:function(){$('.loading').show();},
            success:function (data) {
                success(data);
            },
            error:function(){
                $('.loading').hide();
            }
        })
    };
}