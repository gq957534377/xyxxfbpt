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

    function touchToMouseEvent(event) {
        if (event.originalEvent.touches.length > 1) {
            return
        }
        var touch = event.originalEvent.changedTouches[0];
        var newEvent = document.createEvent("MouseEvents");
        var type = null;
        var simulateClick = false;
        switch (event.type) {
            case"touchstart":
                type = "mousedown";
                break;
            case"touchmove":
                type = "mousemove";
                break;
            case"touchend":
                type = "mouseup";
                break;
            default:
                return
        }
        if (event.type == "touchstart") {
            event.target.startX = touch.clientX;
            event.target.startY = touch.clientY
        } else {
            if (event.type == "touchend") {
                simulateClick = Math.abs(event.target.startX - touch.clientX) < 10 || Math.abs(event.target.startY - touch.clientY) < 10;
                if (simulateClick) {
                    type = "click"
                }
            }
        }
        newEvent.initMouseEvent(type, true, true, window, 1, touch.screenX, touch.screenY, touch.clientX, touch.clientY, false, false, false, false, 0, null);
        event.target.dispatchEvent(newEvent);
        event.preventDefault()
    }

    function isCanvasSupported() {
        var elem = document.createElement("canvas");
        return !!(elem.getContext && elem.getContext("2d"))
    }

    function distance(element) {
        var x = (element.position().left + element.width()) - element.position().left;
        var y = (element.position().top + element.height()) - element.position().top;
        return Math.sqrt(x * x + y * y)
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
        uploadAsURI: (BlobBuilder ? false : true),
        useCanvas: isCanvasSupported(),
        minimalDistance: 10,
        color: "rgba(255,255,255,0)",
        container: $(document),
        uploadName: "screenshot",
        uploadMIME: "image/png",
        onRectangleStart: function (rectangle, x, y) {
        },
        onRectangleEnd: function (rectangle, x, y) {
            rectangle.text("点我删除截图");
            rectangle.mouseover(function (e) {
                rectangle.text("点我删除截图")
            });
            rectangle.mouseout(function (e) {
                rectangle.text("")
            })
        },
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
        markers.mousedown(function (e) {
            rectangle = $("<div />").css({
                "left": e.pageX,
                "top": e.pageY
            }).css($.extend(css.rectangle, css.unselectable, {"background-color": instance.options.color}));
            var rectangleLeft = e.pageX;
            var rectangleTop = e.pageY;
            instance.options.onRectangleStart(rectangle, rectangleLeft, rectangleTop);
            rectangle.appendTo(markers);
            markers.mousemove(function (e) {
                rectangle.width(Math.abs(e.pageX - rectangleLeft));
                rectangle.height(Math.abs(e.pageY - rectangleTop));
                if (e.pageX < rectangleLeft) {
                    rectangle.css("left", e.pageX)
                }
                if (e.pageY < rectangleTop) {
                    rectangle.css("top", e.pageY)
                }
            })
        });
        markers.mouseup(function (e) {
            var self = rectangle;
            var remove = (function () {
                self.remove();
                HTMLFeedback.paint(instance)
            });
            if (distance(self) < options.minimalDistance) {
                remove()
            } else {
                instance.options.onRectangleEnd(self, e.pageX, e.pageY);
                self.mousedown(function () {
                    return false
                });
                self.click(remove)
            }
            markers.unbind("mousemove");
            HTMLFeedback.paint(instance)
        });
        if (isTouchDevice) {
            instance.markers.bind("touchstart", touchToMouseEvent);
            instance.markers.bind("touchmove", touchToMouseEvent);
            instance.markers.bind("touchend", touchToMouseEvent);
            instance.markers.bind("touchcancel", touchToMouseEvent)
        }
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
            $("#htmlfeedback-more").css({"background-color":"#96b97d"});
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
    $("#htmlfeedback-form").submit(function(e) {
        e.preventDefault();

        $("#htmlfeedback-more").css({"background-color":"#ffa52e"});
        $.post(
            "/feedback/feedback.php",
            {"description": $("#htmlfeedback-input-description").val(),"post_id" : 1,"fb_email" : $("#feedback_email").val()},
            function(result){
                if(result.flag==0) {
                    $("#htmlfeedback-info").html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> 抱歉，提交失败：' + result.msg);
                } else {
                    $("#htmlfeedback-submit").prop('disabled',true);
                    $("#htmlfeedback-info").html("您的意见我们已经收到了，谢谢！");
                    $("body").htmlfeedback("hide");
                }
            },
            "json"
        )

    });

    // 背景颜色设置

});
