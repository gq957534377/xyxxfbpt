/**
 * Created by wangt on 2016/12/23.
 */

(function ($) {
    var BlobBuilder = window.BlobBuilder || window.MozBlobBuilder || window.WebKitBlobBuilder || window.MSBlobBuilder || undefined;
    var FormData = window.FormData || undefined;
    var isTouchDevice = "ontouchstart" in document.documentElement;

    function dataURItoBlob(dataURI, callback) {
        var byteString = atob(dataURI.split(",")[1]);
        var mimeString = dataURI.split(",")[0].split(":")[1].split(";")[0];
        var ab = new ArrayBuffer(byteString.length);
        var ia = new Uint8Array(ab);
        for (var i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i)
        }
        var bb = new BlobBuilder();
        bb.append(ab);
        return bb.getBlob(mimeString)
    }


    function isCanvasSupported() {
        var elem = document.createElement("canvas");
        return !!(elem.getContext && elem.getContext("2d"))
    }


    var css = {
        base: {"position": "absolute", "top": 0, "left": 0, "margin": 0, "z-index": 4900},
        markers: {"z-index": 5000, "background-color": "rgba(0,0,0,0)"},
        rectangle: {
            "position": "absolute",
            "font-size": "14px",
            "font-weight": "bold",
            "z-index": 5500,
            "border": "2px solid #000"
        },
        unselectable: {
            "-moz-user-select": "-moz-none",
            "-khtml-user-select": "none",
            "-webkit-user-select": "none",
            "user-select": "none"
        }
    };
    var HTMLFeedback = {};
    HTMLFeedback.instances = {};
    HTMLFeedback.defaults = {

        container: $(document),
        uploadName: "screenshot",
        uploadMIME: "image/png",

        onPreRender: function () {
            alert("HTMLFeedback will now create a screenshot of the web elements " + "ONLY. The overlay and feedback window will hide for a second " + "and will then show again. Rendering can take a few seconds.")
        },
        onPostRender: function (canvas) {
        },
        onShow: function () {
        },
        onHide: function () {
        }
    };
    HTMLFeedback.paint = function (instance) {
        if (instance.options.useCanvas) {
            var context = instance.overlay[0].getContext("2d");
            context.clearRect(0, 0, instance.overlay.width(), instance.overlay.height());
            context.fillStyle = "rgba(0, 0, 0, 0.5)";
            context.fillRect(0, 0, instance.overlay.width(), instance.overlay.height())
        }
        instance.markers.find("div").each(function () {
            var element = $(this);
            var borderWidth = parseInt(element.css("border-left-width"), 10);
            if (instance.options.useCanvas) {
                context.clearRect(element.position().left, element.position().top, element.width() + borderWidth * 2, element.height() + borderWidth * 2)
            }
        })
    };
    HTMLFeedback.resize = function (instance) {
        if (instance.options.useCanvas) {
            instance.overlay.prop("width", instance.options.container.width());
            instance.overlay.prop("height", instance.options.container.height())
        }
        instance.markers.width(instance.options.container.width());
        instance.markers.height(instance.options.container.height())
    };
    HTMLFeedback.clear = function (instance) {
        instance.markers.html("");
        HTMLFeedback.paint(instance)
    };
    HTMLFeedback.show = function (instance) {
        if (instance.options.useCanvas) {
            instance.overlay.show()
        }
        instance.markers.show();
        instance.options.onShow()
    };
    HTMLFeedback.hide = function (instance) {
        if (instance.options.useCanvas) {
            instance.overlay.hide()
        }
        instance.markers.hide();
        instance.options.onHide()
    };
    HTMLFeedback.toggle = function (instance) {
        if (instance.markers.is(":visible")) {
            HTMLFeedback.hide(instance)
        } else {
            HTMLFeedback.show(instance)
        }
    };
    HTMLFeedback.render = function (instance) {
        if (instance.options.useCanvas) {
            instance.overlay.hide()
        }
        instance.options.onPreRender();
        html2canvas(instance.element, {
            onrendered: function (canvas) {
                instance.options.onPostRender(canvas);
                if (instance.options.useCanvas) {
                    instance.overlay.show()
                }
            }
        })
    };
    HTMLFeedback.upload = function (instance, extra) {
        var imageData = null;
        var imageMime = instance.options.uploadMime;
        var uploadName = instance.options.uploadName;
        if (instance.options.useCanvas) {
            instance.overlay.hide()
        }
        instance.options.onPreRender();
        html2canvas(instance.element, {
            onrendered: function (canvas) {
                instance.options.onPostRender(canvas);
                if (instance.options.uploadAsURI) {
                    imageData = canvas.toDataURL(imageMime)
                } else {
                    if (canvas.toBlob ? true : false) {
                        canvas.toBlob(function (blob) {
                            imageData = blob
                        }, imageMime)
                    } else {
                        imageData = dataURItoBlob(canvas.toDataURL(imageMime))
                    }
                }
                if (FormData) {
                    var form = new FormData();
                    form.append(uploadName, imageData);
                    $.each(extra.data || {}, function (key, value) {
                        form.append(key, value)
                    });
                    extra.data = form
                } else {
                    extra.data = extra.data || {};
                    extra.data[uploadName] = imageData
                }
                $.ajax($.extend({cache: false, contentType: false, processData: false, type: "POST"}, extra));
                if (instance.options.useCanvas) {
                    instance.overlay.show()
                }
            }
        })
    };
    HTMLFeedback.init = function (element, options) {
        var options = $.extend(HTMLFeedback.defaults, options);
        var overlay = options.useCanvas ? $("<canvas />").css(css.base).css(css.unselectable).appendTo(element) : null;
        var markers = $("<div />").css(css.base).css(css.markers).css(css.unselectable).appendTo(element);
        var instance = HTMLFeedback.instances[element] = {
            overlay: overlay,
            markers: markers,
            options: options,
            element: element
        };
        var rectangle = null;
        $(window).resize(function () {
            HTMLFeedback.resize(instance);
            HTMLFeedback.paint(instance)
        });
        HTMLFeedback.hide(instance);
        HTMLFeedback.resize(instance);
        HTMLFeedback.clear(instance)
    };
    $.fn.htmlfeedback = function (input, extra) {
        var type = typeof input;
        var self = $(this);
        if (arguments.length == 0 || type == "object") {
            HTMLFeedback.init(self, input)
        } else {
            if (type == "string") {
                var instance = HTMLFeedback.instances[self];
                switch (input.toLowerCase()) {
                    case"show":
                        HTMLFeedback.show(instance);
                        break;
                    case"hide":
                        HTMLFeedback.hide(instance);
                        break;
                    case"toggle":
                        HTMLFeedback.toggle(instance);
                        break;
                    case"render":
                        HTMLFeedback.render(instance, extra);
                        break;
                    case"upload":
                        HTMLFeedback.upload(instance, extra);
                        break;
                    case"reset":
                        HTMLFeedback.hide(instance);
                        HTMLFeedback.resize(instance);
                        HTMLFeedback.clear(instance);
                        break;
                    case"color":
                        instance.options.color = extra;
                        break
                }
                return self
            }
        }
    }
})(jQuery);


$(document).ready(function() {
    // 初始化
    $("body").htmlfeedback({
        onShow: function() {
            $("#htmlfeedback-close").show();
            $("#htmlfeedback-container-more").show("fast").addClass("expanded");
            $("#htmlfeedback-info").html('<i class="fa fa-comments-o" aria-hidden="true"></i> 我的建议');
            $("#htmlfeedback-more").css({"background-color":"#ff9036"});
            $("#htmlfeedback-submit").prop('disabled',false);
        },
        onHide: function() {
            $("#htmlfeedback-close").hide();
            $("#htmlfeedback-container-more").hide("fast").removeClass("expanded");
        },
        onPreRender: function() {
            $("#htmlfeedback-container").hide();
        },
        onPostRender: function(canvas) {
            $("#htmlfeedback-container").show();
        }
    });

    // 显示隐藏反馈对话框
    $("#htmlfeedback-more").click(function() {
        $("body").htmlfeedback("toggle");

    });

    // 重置反馈
    $("#htmlfeedback-reset").click(function() {
        $("body").htmlfeedback("reset");
    });
    $("#is-screenshots").change(function(e) {
        if($('#is-screenshots').prop('checked')) {
            $('#screenshots').show();
        } else {
            $('#screenshots').hide();
        }
    });
    // 上传到服务器

    // $("#htmlfeedback-form").submit(function(e) {
    //     e.preventDefault();
    //
    //     $("#htmlfeedback-more").css({"background-color":"#ffa52e"});
    //     $.ajaxSetup({
    //         // 将laravel的csrftoken加入请求头，所以页面中应该有meta标签，详细写法在上面的form表单部分
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //
    //     $.ajax({
    //         type : 'post',
    //         url: "/openim",
    //         data: {
    //             "description": $("#htmlfeedback-input-description").val(),
    //             "fb_email" : $("#feedback_email").val()
    //         },
    //         success: function(msg){
    //
    //             if(msg.StatusCode == '400') {
    //                 $("#htmlfeedback-info").html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> 抱歉，提交失败：' + msg.ResultData);
    //             } else {
    //
    //                 $("#htmlfeedback-submit").prop('disabled',true);
    //                 $("#htmlfeedback-info").html("您的意见我们已经收到了，谢谢！");
    //                 $("body").htmlfeedback("hide");
    //             }
    //         },
    //         error: function(XMLHttpRequest){
    //             var number = XMLHttpRequest.status;
    //             var msg = "Error: "+number+",数据异常！";
    //             alert(msg);
    //         }
    //
    //     });
    //
    // });

    // 背景颜色设置

});

$(window).scroll(function () {
    var _stop = $(window).scrollTop();
    if (_stop == 100) {
        $('#htmlfeedback-container').show();
    }

    if(_stop>=100) {
        $(".go-top").fadeIn();
        if ($('#htmlfeedback-container').length){
            if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                // some code..
            } else {
                $("#htmlfeedback-container").show();
            }
        }
    }else {
        $(".go-top").fadeOut();
    }
});


$(".go-top").click(function(event){
    $('html,body').animate({scrollTop:0}, 100);
    return false;
});



!(function ($) {
    "use strict";//使用严格标准
    // 获取表单元素
    var FormValidator = function(){
        this.$signOnForm = $("#htmlfeedback-form");
    };

    // 初始化
    FormValidator.prototype.init = function() {

        // ajax 异步
        $.validator.setDefaults({
            // 提交触发事件
            submitHandler: function() {
                $.ajaxSetup({
                    //将laravel的csrftoken加入请求头，所以页面中应该有meta标签，详细写法在上面的form表单部分
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                //与正常form不同，通过下面这样来获取需要验证的字段
                var data = new FormData();
                data.append( "description"     , $("#htmlfeedback-input-description").val());
                data.append( "fb_email"     , $("#feedback_email").val());

                //开始正常的ajax
                // 异步登录
                $.ajax({
                    type: "POST",
                    url: '/openim',
                    data: {
                        'description': $("#htmlfeedback-input-description").val(),
                        'fb_email': $("#feedback_email").val(),
                    },
                    success:function(data){
                        switch (data.StatusCode){
                            case '400':
                                // promptBoxHandle('警告',data.ResultData);
                                alert('警告,'+data.ResultData);
                                break;
                            case '200':
                                $("#htmlfeedback-submit").prop('disabled',true);
                                $("#htmlfeedback-info").html("您的意见我们已经收到了，谢谢！");
                                $("body").htmlfeedback("hide");
                                break;
                        }
                    }
                });
            }
        });
        // 验证规则和提示信息
        this.$signOnForm.validate({
            // 验证规则
            rules: {
                description: {
                    required: true,
                    maxlength: 400,
                    minlength: 10
                },
                fb_email: {
                    email:true,
                }
            },
            // 提示信息
            messages: {
                description: {
                    required: "意见不能为空!",
                    maxlength:"意见最多智能输入400个字符！",
                    minlength:"意见最少为10个字符！",
                },
                fb_email: {
                    email: "邮箱格式不正确！"
                }
            },
            errorPlacement: function(error, element) {
                // Append error within linked label
                $('#error-info').html(error[0].textContent).fadeIn(1000);
            }
        });
    };
    $.FormValidator = new FormValidator;
    $.FormValidator.Constructor = FormValidator;
})(window.jQuery),
    function($){
        "use strict";
        $.FormValidator.init();
    }(window.jQuery);

