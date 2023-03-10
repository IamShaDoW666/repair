


(function() {
  "use strict";
  var EkkoLightbox;

  EkkoLightbox = function(element, options) {
    var content, footer, header, video_id,
      _this = this;
    this.options = $.extend({
      gallery_parent_selector: '*:not(.row)',
      title: null,
      footer: null,
      remote: null,
      left_arrow_class: '.fa .fa-chevron-left',
      right_arrow_class: '.fa .fa-chevron-right',
      directional_arrows: true,
      type: null,
      onShow: function() {},
      onShown: function() {},
      onHide: function() {},
      onHidden: function() {},
      id: false
    }, options || {});
    this.$element = $(element);
    content = '';
    this.modal_id = this.options.modal_id ? this.options.modal_id : 'ekkoLightbox-' + Math.floor((Math.random() * 1000) + 1);
    header = '<div class="modal-header"' + (this.options.title ? '' : ' style="display:none"') + '><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">' + this.options.title + '</h4></div>';
    footer = '<div class="modal-footer"' + (this.options.footer ? '' : ' style="display:none"') + '>' + this.options.footer + '</div>';
    $(document.body).append('<div id="' + this.modal_id + '" class="ekko-lightbox modal fade" tabindex="-1"><div class="modal-dialog"><div class="modal-content">' + header + '<div class="modal-body"><div class="ekko-lightbox-container"><div></div></div></div>' + footer + '</div></div></div>');
    this.modal = $('#' + this.modal_id);
    this.modal_body = this.modal.find('.modal-body').first();
    this.lightbox_container = this.modal_body.find('.ekko-lightbox-container').first();
    this.lightbox_body = this.lightbox_container.find('> div:first-child').first();
    this.modal_arrows = null;
    this.padding = {
      left: parseFloat(this.modal_body.css('padding-left'), 10),
      right: parseFloat(this.modal_body.css('padding-right'), 10),
      bottom: parseFloat(this.modal_body.css('padding-bottom'), 10),
      top: parseFloat(this.modal_body.css('padding-top'), 10)
    };
    if (!this.options.remote) {
      this.error('No remote target given');
    } else {
      this.gallery = this.$element.data('gallery');
      if (this.gallery) {
        if (this.options.gallery_parent_selector === 'document.body' || this.options.gallery_parent_selector === '') {
          this.gallery_items = $(document.body).find('*[data-toggle="lightbox"][data-gallery="' + this.gallery + '"]');
        } else {
          this.gallery_items = this.$element.parents(this.options.gallery_parent_selector).first().find('*[data-toggle="lightbox"][data-gallery="' + this.gallery + '"]');
        }
        this.gallery_index = this.gallery_items.index(this.$element);
        $(document).on('keydown.ekkoLightbox', this.navigate.bind(this));
        if (this.options.directional_arrows && this.gallery_items.length > 1) {
          this.lightbox_container.prepend('<div class="ekko-lightbox-nav-overlay"><a href="#" class="' + this.strip_stops(this.options.left_arrow_class) + '"></a><a href="#" class="' + this.strip_stops(this.options.right_arrow_class) + '"></a></div>');
          this.modal_arrows = this.lightbox_container.find('div.ekko-lightbox-nav-overlay').first();
          this.lightbox_container.find('a' + this.strip_spaces(this.options.left_arrow_class)).on('click', function(event) {
            event.preventDefault();
            return _this.navigate_left();
          });
          this.lightbox_container.find('a' + this.strip_spaces(this.options.right_arrow_class)).on('click', function(event) {
            event.preventDefault();
            return _this.navigate_right();
          });
        }
      }
      if (this.options.type) {
        if (this.options.type === 'image') {
          this.preloadImage(this.options.remote, true);
        } else if (this.options.type === 'youtube' && (video_id = this.getYoutubeId(this.options.remote))) {
          this.showYoutubeVideo(video_id);
        } else if (this.options.type === 'vimeo') {
          this.showVimeoVideo(this.options.remote);
        } else {
          this.error("Could not detect remote target type. Force the type using data-type=\"image|youtube|vimeo\"");
        }
      } else {
        this.detectRemoteType(this.options.remote);
      }
    }
    this.modal.on('show.bs.modal', this.options.onShow.bind(this)).on('shown.bs.modal', function() {
      if (_this.modal_arrows) {
        _this.resize(_this.lightbox_body.width());
      }
      return _this.options.onShown.call(_this);
    }).on('hide.bs.modal', this.options.onHide.bind(this)).on('hidden.bs.modal', function() {
      if (_this.gallery) {
        $(document).off('keydown.ekkoLightbox');
      }
      _this.modal.remove();
      return _this.options.onHidden.call(_this);
    }).modal('show', options);
    return this.modal;
  };

  EkkoLightbox.prototype = {
    strip_stops: function(str) {
      return str.replace(/\./g, '');
    },
    strip_spaces: function(str) {
      return str.replace(/\s/g, '');
    },
    isImage: function(str) {
      return str.match(/(^data:image\/.*,)|(\.(jp(e|g|eg)|gif|png|bmp|webp|svg)((\?|#).*)?$)/i);
    },
    isSwf: function(str) {
      return str.match(/\.(swf)((\?|#).*)?$/i);
    },
    getYoutubeId: function(str) {
      var match;
      match = str.match(/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/);
      if (match && match[2].length === 11) {
        return match[2];
      } else {
        return false;
      }
    },
    getVimeoId: function(str) {
      if (str.indexOf('vimeo') > 0) {
        return str;
      } else {
        return false;
      }
    },
    navigate: function(event) {
      event = event || window.event;
      if (event.keyCode === 39 || event.keyCode === 37) {
        if (event.keyCode === 39) {
          return this.navigate_right();
        } else if (event.keyCode === 37) {
          return this.navigate_left();
        }
      }
    },
    navigate_left: function() {
      var src;
      if (this.gallery_items.length === 1) {
        return;
      }
      if (this.gallery_index === 0) {
        this.gallery_index = this.gallery_items.length - 1;
      } else {
        this.gallery_index--;
      }
      this.$element = $(this.gallery_items.get(this.gallery_index));
      this.updateTitleAndFooter();
      src = this.$element.attr('data-remote') || this.$element.attr('href');
      return this.detectRemoteType(src, this.$element.attr('data-type'));
    },
    navigate_right: function() {
      var next, src;
      if (this.gallery_items.length === 1) {
        return;
      }
      if (this.gallery_index === this.gallery_items.length - 1) {
        this.gallery_index = 0;
      } else {
        this.gallery_index++;
      }
      this.$element = $(this.gallery_items.get(this.gallery_index));
      src = this.$element.attr('data-remote') || this.$element.attr('href');
      this.updateTitleAndFooter();
      this.detectRemoteType(src, this.$element.attr('data-type'));
      if (this.gallery_index + 1 < this.gallery_items.length) {
        next = $(this.gallery_items.get(this.gallery_index + 1), false);
        src = next.attr('data-remote') || next.attr('href');
        if (next.attr('data-type') === 'image' || this.isImage(src)) {
          return this.preloadImage(src, false);
        }
      }
    },
    detectRemoteType: function(src, type) {
      var video_id;
      if (type === 'image' || this.isImage(src)) {
        return this.preloadImage(src, true);
      } else if (type === 'youtube' || (video_id = this.getYoutubeId(src))) {
        return this.showYoutubeVideo(video_id);
      } else if (type === 'vimeo' || (video_id = this.getVimeoId(src))) {
        return this.showVimeoVideo(video_id);
      } else {
        return this.error("Could not detect remote target type. Force the type using data-type=\"image|youtube|vimeo\"");
      }
    },
    updateTitleAndFooter: function() {
      var caption, footer, header, title;
      header = this.modal.find('.modal-dialog .modal-content .modal-header');
      footer = this.modal.find('.modal-dialog .modal-content .modal-footer');
      title = this.$element.data('title') || "";
      caption = this.$element.data('footer') || "";
      if (title) {
        header.css('display', '').find('.modal-title').html(title);
      } else {
        header.css('display', 'none');
      }
      if (caption) {
        footer.css('display', '').html(caption);
      } else {
        footer.css('display', 'none');
      }
      return this;
    },
    showLoading: function() {
      this.lightbox_body.html('<div class="modal-loading">Loading..</div>');
      return this;
    },
    showYoutubeVideo: function(id) {
      var height, width;
      width = this.$element.data('width') || 560;
      height = this.$element.data('height') || 315;
      this.resize(width);
      this.lightbox_body.html('<iframe width="' + width + '" height="' + height + '" src="//www.youtube.com/embed/' + id + '?badge=0&autoplay=1&html5=1" frameborder="0" allowfullscreen></iframe>');
      if (this.modal_arrows) {
        return this.modal_arrows.css('display', 'none');
      }
    },
    showVimeoVideo: function(id) {
      this.resize(500);
      this.lightbox_body.html('<iframe width="500" height="281" src="' + id + '?autoplay=1" frameborder="0" allowfullscreen></iframe>');
      if (this.modal_arrows) {
        return this.modal_arrows.css('display', 'none');
      }
    },
    error: function(message) {
      this.lightbox_body.html(message);
      return this;
    },
    preloadImage: function(src, onLoadShowImage) {
      var img,
        _this = this;
      img = new Image();
      if ((onLoadShowImage == null) || onLoadShowImage === true) {
        img.onload = function() {
          var image, width;
          width = _this.checkImageDimensions(img.width);
          image = $('<img />');
          image.attr('src', img.src);
          image.css('max-width', '100%');
          _this.lightbox_body.html(image);
          if (_this.modal_arrows) {
            _this.modal_arrows.css('display', 'block');
          }
          return _this.resize(width);
        };
        img.onerror = function() {
          return _this.error('Failed to load image: ' + src);
        };
      }
      img.src = src;
      return img;
    },
    resize: function(width) {
      var width_inc_padding;
      width_inc_padding = width + this.padding.left + this.padding.right;
      this.modal.find('.modal-content').css('width', width_inc_padding);
      this.modal.find('.modal-dialog').css('width', width_inc_padding + 20);
      this.lightbox_container.find('a').css('padding-top', function() {
        return $(this).parent().height() / 2;
      });
      return this;
    },
    checkImageDimensions: function(max_width) {
      var w, width;
      w = $(window);
      width = max_width;
      if ((max_width + (this.padding.left + this.padding.right + 20)) > w.width()) {
        width = w.width() - (this.padding.left + this.padding.right + 20);
      }
      return width;
    },
    close: function() {
      return this.modal.modal('hide');
    }
  };

  $.fn.ekkoLightbox = function(options) {
    return this.each(function() {
      var $this;
      $this = $(this);
      options = $.extend({
        remote: $this.attr('data-remote') || $this.attr('href'),
        gallery_parent_selector: $this.attr('data-parent'),
        type: $this.attr('data-type')
      }, options, $this.data());
      new EkkoLightbox(this, options);
      return this;
    });
  };

}).call(this);



$.ajaxPrefilter(function( options, original_Options, jqXHR ) {
  options.async = false;
});
    jQuery.migrateMute = true

  $(function() {

  $('body').on('click', '[data-toggle="modal"]', function(){
    $($(this).attr("data-target")+' .modal-dialog').load($(this).attr("href"));
  });  

      $('#sidebar_toggle').on('click', function(e) {
          var body = $('body');
          var state = '';

          if (!body.hasClass('sidebar-collapse')) {
              state = 'sidebar-collapse';
          }

          $.ajax({
              type: 'post',
              mode: 'queue',
              url: base_url + 'panel/welcome/nav_toggle',
              data: {
                  state: state
              },
              success: function(data) {

              }
          });
      });
      $('.select').select2();

  });

$(document).ajaxStart(function() {
  $("#loadingmessage").show();
});

$(document).ajaxStop(function() {
  $("#loadingmessage").hide();
});
function formatMyDecimal(number) {
  var options = {
    decimal : site.settings.decimal_seperator,
    thousand: site.settings.thousand_seperator,
    precision : 2,
  };
  return accounting.formatNumber(number, options)
}
function formatDecimal(number) {
  var options = {
    decimal : ".",
    thousand: "",
    precision : 2,
  };
  return accounting.formatNumber(number, options)
}


$(function () {
  $('#form_cat').parsley({
      errorsContainer: function(pEle) {
          var $err = pEle.$element.closest('.form-group');
          return $err;
      }
  }); 
}); 



$(document).ready(function() {
  jQuery(document).on("change", ".gen_slug", function (e) {
      getSlug($(this).val(), 'category');
  });


    
  $('#date_range').daterangepicker({
    ranges   : {
      'Today'       : [moment(), moment()],
      'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month'  : [moment().startOf('month'), moment().endOf('month')],
      'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    locale: {
        format: (site.dateFormats.js_sdate).toUpperCase()
    },
  });

  $('.tip').tooltip();
  $(document).on('click', '.activate_toggle_po', function(e) {
      e.preventDefault();
      $('.activate_toggle_po').popover({html: true, placement: 'left', trigger: 'manual'}).popover('show').not(this).popover('hide');
      return false;
  });
  $(document).on('click', '.activate_toggle_po-close', function() {
      $('.activate_toggle_po').popover('hide');
      return false;
  });
  $(document).on('click', '.po-delete', function () {
      var id = $(this).attr('id');
      $(this).closest('tr').remove();
  });
  $(document).on('click', '.email_payment', function (e) {
      e.preventDefault();
      var link = $(this).attr('href');
      $.get(link, function(data) {
          bootbox.alert(data.msg);
      });
      return false;
  });
});