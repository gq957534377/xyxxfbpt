/*global Qiniu */
/*global plupload */
/*global FileProgress */
/*global hljs */


$(function() {
    var uploader = Qiniu.uploader({
        runtimes: 'html5,flash,html4',
        browse_button: 'edit_file_pick',
        container: 'edit_container',
        drop_element: 'img_container',
        max_file_size: '1000mb',
        flash_swf_url: 'bower_components/plupload/js/Moxie.swf',
        dragdrop: true,
        chunk_size: '4mb',
        uptoken_url: $('#uptoken_url').val(),
        domain: $('#domain').val(),
        get_new_uptoken: false,
        auto_start: true,
        log_level: 5,
        filters : {
            max_file_size : '100mb',
            prevent_duplicates: true,
            // Specify what files to browse for
            mime_types: [
                {title : "Image files", extensions : "doc,docx,docm,dotx,dotm,xls,xlsx,xlsm,xltx,xltm,xlsb,xlam,ppt,pptx,pptm,ppsx,ppsm,potx,potm,ppam"} // 限定jpg,gif,png后缀上传
            ]
        },
        init: {
            'FilesAdded': function(up, files) {
                $('table').show();
                $('#success').hide();
                plupload.each(files, function(file) {
                    var progress = new FileProgress(file, 'fsUploadProgress_edit_file');
                    progress.setStatus("等待中...");
                    progress.bindUploadCancel(up);
                });
            },
            'BeforeUpload': function(up, file) {
                var progress = new FileProgress(file, 'fsUploadProgress_edit_file');
                var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
                if (up.runtime === 'html5' && chunk_size) {
                    progress.setChunkProgess(chunk_size);
                }
            },

            // 上传过程这个函数会不断的执行,直到上传完成
            'UploadProgress': function(up, file) {
                $('._block').hide();
                var progress = new FileProgress(file, 'fsUploadProgress_edit_file');
                var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
                progress.setProgress(file.percent + "%", file.speed, chunk_size);
            },
            'UploadComplete': function() {
                var res = $.parseJSON(info);
                var domain = up.getOption('domain');
                url = domain + encodeURI(res.key);
            },
            'FileUploaded': function(up, file, info) {
                var progress = new FileProgress(file, 'fsUploadProgress_edit_file');
                progress.setComplete(up, info);

                //上传完成时将url放入隐藏的input[name=image]
                var res = $.parseJSON(info);
                var domain = up.getOption('domain');
                url = domain + encodeURI(res.key);
                $('input[name=image]').val(url);
            },
            'Error': function(up, err, errTip) {
                $('table').show();
                var progress = new FileProgress(err.file, 'fsUploadProgress_edit_file');
                progress.setError();
                progress.setStatus(errTip);
            }
            ,
            'Key': function(up, file) {
                var extarr = file['name'].split('.');
                if(extarr.length===1){
                    var arr=file['type'].split('/');
                    var prename = extarr[0];
                    var ext = (arr[arr.length-1]=='undefined')?'':arr[arr.length-1];
                }else{
                    var ext = '.'+ extarr[extarr.length-1]; //得到后缀
                    var index = file['name'].lastIndexOf('.');//得到最后一个点的坐标
                    var prename = file['name'].substring(0,index);//得到最后一个点之前的字符串
                }


                var time = Date.parse(new Date())/1000;
                $("input[name='ftype']").val(prename);
                var key = prename+'/'+time+ ext;
                return key;
            }
        }
    });



    uploader.bind('FileUploaded', function() {
        console.log('hello man,a file is uploaded');
    });
    $('#container').on(
        'dragenter',
        function(e) {
            e.preventDefault();
            $('#container').addClass('draging');
            e.stopPropagation();
        }
    ).on('drop', function(e) {
        e.preventDefault();
        $('#container').removeClass('draging');
        e.stopPropagation();
    }).on('dragleave', function(e) {
        e.preventDefault();
        $('#container').removeClass('draging');
        e.stopPropagation();
    }).on('dragover', function(e) {
        e.preventDefault();
        $('#container').addClass('draging');
        e.stopPropagation();
    });



    $('#show_code').on('click', function() {
        $('#myModal-code').modal();
        $('pre code').each(function(i, e) {
            hljs.highlightBlock(e);
        });
    });


    $('body').on('click', 'table button.btn', function() {
        $(this).parents('tr').next().toggle();
    });


    var getRotate = function(url) {
        if (!url) {
            return 0;
        }
        var arr = url.split('/');
        for (var i = 0, len = arr.length; i < len; i++) {
            if (arr[i] === 'rotate') {
                return parseInt(arr[i + 1], 10);
            }
        }
        return 0;
    };

    $('#myModal-img .modal-body-footer').find('a').on('click', function() {
        var img = $('#myModal-img').find('.modal-body img');
        var key = img.data('key');
        var oldUrl = img.attr('src');
        var originHeight = parseInt(img.data('h'), 10);
        var fopArr = [];
        var rotate = getRotate(oldUrl);
        if (!$(this).hasClass('no-disable-click')) {
            $(this).addClass('disabled').siblings().removeClass('disabled');
            if ($(this).data('imagemogr') !== 'no-rotate') {
                fopArr.push({
                    'fop': 'imageMogr2',
                    'auto-orient': true,
                    'strip': true,
                    'rotate': rotate,
                    'format': 'png'
                });
            }
        } else {
            $(this).siblings().removeClass('disabled');
            var imageMogr = $(this).data('imagemogr');
            if (imageMogr === 'left') {
                rotate = rotate - 90 < 0 ? rotate + 270 : rotate - 90;
            } else if (imageMogr === 'right') {
                rotate = rotate + 90 > 360 ? rotate - 270 : rotate + 90;
            }
            fopArr.push({
                'fop': 'imageMogr2',
                'auto-orient': true,
                'strip': true,
                'rotate': rotate,
                'format': 'png'
            });
        }

        $('#myModal-img .modal-body-footer').find('a.disabled').each(function() {

            var watermark = $(this).data('watermark');
            var imageView = $(this).data('imageview');
            var imageMogr = $(this).data('imagemogr');

            if (watermark) {
                fopArr.push({
                    fop: 'watermark',
                    mode: 1,
                    image: 'http://www.b1.qiniudn.com/images/logo-2.png',
                    dissolve: 100,
                    gravity: watermark,
                    dx: 100,
                    dy: 100
                });
            }

            if (imageView) {
                var height;
                switch (imageView) {
                    case 'large':
                        height = originHeight;
                        break;
                    case 'middle':
                        height = originHeight * 0.5;
                        break;
                    case 'small':
                        height = originHeight * 0.1;
                        break;
                    default:
                        height = originHeight;
                        break;
                }
                fopArr.push({
                    fop: 'imageView2',
                    mode: 3,
                    h: parseInt(height, 10),
                    q: 100,
                    format: 'png'
                });
            }

            if (imageMogr === 'no-rotate') {
                fopArr.push({
                    'fop': 'imageMogr2',
                    'auto-orient': true,
                    'strip': true,
                    'rotate': 0,
                    'format': 'png'
                });
            }
        });

        var newUrl = Qiniu.pipeline(fopArr, key);

        var newImg = new Image();
        img.attr('src', 'images/loading.gif');
        newImg.onload = function() {
            img.attr('src', newUrl);
            img.parent('a').attr('href', newUrl);
        };
        newImg.src = newUrl;
        return false;
    });

});
