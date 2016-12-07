(function (factory) {
  if (typeof define === 'function' && define.amd) {
    define(['jquery'], factory);
  } else if (typeof exports === 'object') {
    // Node / CommonJS
    factory(require('jquery'));
  } else {
    factory(jQuery);
  }
})(function ($) {

  'use strict';

  var console = window.console || { log: function () {} };
  // 头像上传处理类
  function CropAvatar($element) {
    this.$container = $element;

    this.$avatarView = this.$container.find('.avatar-view');
    this.$avatar = this.$avatarView.find('img');
    this.$avatarModal = this.$container.find('#avatar-modal');
    this.$loading = this.$container.find('.load');

    this.$avatarForm = this.$avatarModal.find('.avatar-form');
    this.$avatarUpload = this.$avatarForm.find('.avatar-upload');
    this.$avatarSrc = this.$avatarForm.find('.avatar-src');
    this.$avatarData = this.$avatarForm.find('.avatar-data');
    this.$avatarInput = this.$avatarForm.find('.avatar-input');
    this.$avatarSave = this.$avatarForm.find('.avatar-save');
    this.$avatarBtns = this.$avatarForm.find('.avatar-btns');

    this.$avatarWrapper = this.$avatarModal.find('.avatar-wrapper');
    this.$avatarPreview = this.$avatarModal.find('.avatar-preview');

    this.init();
    console.log(this);
  }

  // 类实例方法
  CropAvatar.prototype = {
    // 构造函数
    constructor: CropAvatar,

    // 浏览器兼容支持
    support: {
      fileList: !!$('<input type="file">').prop('files'),
      blobURLs: !!window.URL && URL.createObjectURL,
      formData: !!window.FormData
    },

    // 初始化
    init: function () {
      this.support.datauri = this.support.fileList && this.support.blobURLs;

      if (!this.support.formData) {
        this.initIframe();
      }

      this.initTooltip();
      this.initModal();
      this.addListener();
    },

    // 添加监听事件
    addListener: function () {
      this.$avatarView.on('click', $.proxy(this.click, this));
      this.$avatarInput.on('change', $.proxy(this.change, this));
      this.$avatarForm.on('submit', $.proxy(this.submit, this));
      this.$avatarBtns.on('click', $.proxy(this.rotate, this));
    },

    // 初始化工具提示
    initTooltip: function () {
      this.$avatarView.tooltip({
        placement: 'bottom' // 提示摆放位置
      });
    },

    // 初始化模态框
    initModal: function () {
      this.$avatarModal.modal({
        show: false // 模态框默认隐藏
      });
    },

    // 初始化预览
    initPreview: function () {
      // 设置预览时 头像不同尺寸
      var url = this.$avatar.attr('src');

      this.$avatarPreview.empty().html('<img src="' + url + '">');
    },

    // 初始化Iframe
    initIframe: function () {
      var target = 'upload-iframe-' + (new Date()).getTime(),
          $iframe = $('<iframe>').attr({
            name: target,
            src: ''
          }),
          _this = this;

      // Ready ifrmae
      $iframe.one('load', function () {

        // respond response
        $iframe.on('load', function () {
          var data;

          try {
            data = $(this).contents().find('body').text();
          } catch (e) {
            console.log(e.message);
          }

          if (data) {
            try {
              data = $.parseJSON(data);
            } catch (e) {
              console.log(e.message);
            }

            _this.submitDone(data);
          } else {
            _this.submitFail('图片上传失败!');
          }

          _this.submitEnd();

        });
      });

      this.$iframe = $iframe;
      this.$avatarForm.attr('target', target).after($iframe.hide());
    },

    // 点击事件，模态框显示，预览开启
    click: function () {
      this.$avatarModal.modal('show');
      this.initPreview();
    },

    // 联动事件，判断下图片格式
    change: function () {
      var files,
          file;

      if (this.support.datauri) {
        files = this.$avatarInput.prop('files');

        if (files.length > 0) {
          file = files[0];

          if (this.isImageFile(file)) {
            if (this.url) {
              URL.revokeObjectURL(this.url); // Revoke the old one
            }

            this.url = URL.createObjectURL(file);
            this.startCropper();
          }
        }
      } else {
        file = this.$avatarInput.val();

        if (this.isImageFile(file)) {
          this.syncUpload();
        }
      }
    },

    // 提交事件
    submit: function () {
      if (!this.$avatarSrc.val() && !this.$avatarInput.val()) {
        return false;
      }

      if (this.support.formData) {
        this.ajaxUpload();
        return false;
      }
    },

    // 旋转
    rotate: function (e) {
      var data;

      if (this.active) {
        data = $(e.target).data();

        if (data.method) {
          this.$img.cropper(data.method, data.option);
        }
      }
    },

    // 是否是图片
    isImageFile: function (file) {
      if (file.type) {
        return /^image\/\w+$/.test(file.type);
      } else {
        return /\.(jpg|jpeg|png|gif)$/.test(file);
      }
    },

    // 截取的信息，起始点、宽高、旋转角度信息
    startCropper: function () {
      var _this = this;

      if (this.active) {
        this.$img.cropper('replace', this.url);
      } else {
        this.$img = $('<img src="' + this.url + '">');
        this.$avatarWrapper.empty().html(this.$img);
        this.$img.cropper({
          aspectRatio: 1,
          preview: this.$avatarPreview.selector,
          strict: false,
          crop: function (data) {
            var json = [
                  '{"x":' + data.x,
                  '"y":' + data.y,
                  '"height":' + data.height,
                  '"width":' + data.width,
                  '"rotate":' + data.rotate + '}'
                ].join();

            _this.$avatarData.val(json);
          }
        });

        this.active = true;
      }
    },

    // 截取完后
    stopCropper: function () {
      if (this.active) {
        this.$img.cropper('destroy');
        this.$img.remove();
        this.active = false;
      }
    },

    // 异步上传
    ajaxUpload: function () {
      var url = this.$avatarForm.attr('action'),
          data = new FormData(this.$avatarForm[0]),
          _this = this;

      $.ajax(url, {
        type: 'post',
        data: data,
        dataType: 'json',
        processData: false,
        contentType: false,

        beforeSend: function () {
          _this.submitStart();
        },

        success: function (data) {
          _this.submitDone(data);
        },

        error: function (XMLHttpRequest, textStatus, errorThrown) {
          _this.submitFail(textStatus || errorThrown);
        },

        complete: function () {
          _this.submitEnd();
        }
      });
    },

    syncUpload: function () {
      this.$avatarSave.click();
    },

    submitStart: function () {
      this.$loading.fadeIn();
    },

    submitDone: function (data) {
      console.log(data);

      if ($.isPlainObject(data) && data.state === 200) {
        if (data.result) {
          this.url = data.result;

          if (this.support.datauri || this.uploaded) {
            this.uploaded = false;
            this.cropDone();
          } else {
            this.uploaded = true;
            this.$avatarSrc.val(this.url);
            this.startCropper();
          }

          this.$avatarInput.val('');
        } else if (data.message) {
          this.alert(data.message);
        }
      } else {
        this.alert(data.result);
      }
    },

    submitFail: function (msg) {
      this.alert(msg);
    },

    submitEnd: function () {
      this.$loading.fadeOut();
    },

    cropDone: function () {
      this.$avatarForm.get(0).reset();
      this.$avatar.attr('src', this.url);
      $("#head_pic").attr('src',this.url);
      this.stopCropper();
      this.$avatarModal.modal('hide');
    },

    alert: function (msg) {
      var $alert = [
            '<div class="alert alert-danger avater-alert">',
              '<button type="button" class="close" data-dismiss="alert">&times;</button>',
              msg,
            '</div>'
          ].join('');

      this.$avatarUpload.after($alert);
    }
  };

  $(function () {
    return new CropAvatar($('#crop-avatar'));
  });
});

