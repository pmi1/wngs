jQuery(function(){
  initTooltips();
  initCarousel();
  initCollapse();
  initFixedNav();
  initAnchors();
  initBurgerMenu();
  initBgCover();
  initSearchCollapse();
 // FontResize.init();
 // initBtns();
  initTabs();
  initAddClass();
  initVideoModal();
  initAutocomplete();
  initCustomScroll();
  initCustomRow();
});

function initCustomRow() {
  var holders = jQuery('.row-validation');

  holders.each(function() {
    var holder = jQuery(this);
    var selects = holder.find('select');
    var targetSelect = jQuery(selects[1]);

    selects.each(function() {
      var select = jQuery(this);

      select.on('change', function() {
        if (targetSelect.attr('disabled') == 'disabled') {
         targetSelect.attr('disabled', false);
        }
      });
    });
  });

  ResponsiveHelper.addRange({
      '..991': {
          on: function() {
            holders.collapse({
              addClassBeforeAnimation: false,
              activeClass: 'row-active',
              opener: '.row-opener',
              slider: '.row-slide',
              animSpeed: 400,
              hideOnClickOutside: true,
              effect: 'slide'
            });
          },
          off: function() {
            holders.collapse('destroy');
          }
      }
  });
}

// initialize custom form elements
function initCustomScroll() {
  var win = jQuery(window);

  jcf.replaceAll();

  function resizeHandler() {
    jcf.refresh('.jcf-scrollable');
  }
  win.on('load resize orientationchange', resizeHandler);
}

function initAutocomplete() {
  var input = jQuery('.form-autocomplete');

  $.widget( "custom.catcomplete", $.ui.autocomplete, {
    _create: function() {
      this._super();
      this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
    },
    _renderMenu: function( ul, items ) {
      var that = this,
        currentCategory = "";
      $.each( items, function( index, item ) {
        var li;
        if ( item.category != currentCategory ) {
          ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
          currentCategory = item.category;
        }
        li = that._renderItemData( ul, item );
        if ( item.category ) {
          li.attr( "aria-label", item.category + " : " + item.label );
        }
      });
    }
  });
  var data = [
    { label: "anders", category: "" },
    { label: "andreas", category: "" },
    { label: "antal", category: "" },
    { label: "annhhx10", category: "Products" },
    { label: "annk K12", category: "Products" },
    { label: "annttop C13", category: "Products" },
    { label: "anders andersson", category: "People" },
    { label: "andreas andersson", category: "People" },
    { label: "andreas johnson", category: "People" }
  ];

  input.catcomplete({
    source: data,
    delay: 0,
    minLength: 2,
    select: function( event, ui ) {
      console.log( "Selected: " + ui.item.value + " aka " + ui.item.id );
    }
  });
}

function initVideoModal() {
  var videoContainer = jQuery('#modalVideo');
  var videoHolder = jQuery('#video-frame');

  videoContainer.fitVids();
  videoContainer.on("hidden.bs.modal", function () {
      var url = videoHolder.attr('src');
      videoHolder.attr('src', '');
      videoHolder.attr('src', url);
  });
}

function initAddClass() {
  var activeClass = 'compare-active';
  var body = jQuery('body');
  var openers = jQuery('.add-to-compare');

  openers.on('click', function() {
    if (!body.hasClass(activeClass)) {
      body.addClass(activeClass);
    }
  })
}

function initTabs() {
  // jQuery('.tabset').tabset({
  //   tabLinks: 'li',
  //   attrib: 'data-tab'
  // });

  jQuery('.tabset').slideBox({
    items: '.tabset-item',
    boxHold: '.tabset-list',
    opener: '.link-opener',
    slideWrap: '.slide-holder',
    hiddenBox: '.tab-horisontal-content'
  });
}

function initSearchCollapse() {
  jQuery('.collapse-holder').collapse({
    addClassBeforeAnimation: false,
    activeClass: 'collapse-active',
    opener: '.more-opener',
    slider: '.collapse-frame',
    animSpeed: 400,
    effect: 'slide'
  });
}

function initBgCover() {
  jQuery('.bg-cover, .bg-stretch').bgCover();
}

function initBtns() {
  var btns = jQuery('.resizer');

  initCheckValue();

  function initCheckValue() {
    var body = jQuery('body');
    var container = jQuery('#value');

    container.html(body.attr('style').split(': ')[1].toString().split('em;'));
  }

  btns.each(function() {
    jQuery(this).click(function() {
      setTimeout(initCheckValue);
    })
  })
}

// mobile menu init
function initBurgerMenu() {
  jQuery('body').BurgerNavigation({
    BurgerActiveClass: 'menu-active',
    BurgerOpener: '.menu-opener, .menu-close',
    hideOnClickOutside: true,
    BurgerDrop: '.mobile-nav'
  });
}

// initialize smooth anchor links
function initAnchors() {
  var offset = jQuery('body').data('offset');

  jQuery('.anchor-nav-drop a[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top - offset + 1
        }, 400);
        return false;
      }
    }
  });
}


/*
 * jQuery SlideBox plugin
 */
;(function($) {
  function SlideBox(options) {
    this.options = $.extend({
      holder: null,
      items: '.box',
      slideWrap: '.slide',
      hiddenBox: '.hidden-info',
      btnClose: '.btn-close',
      animSpeed: 0,
      activeClass: 'active'
    }, options);

    this.init();
  }
  SlideBox.prototype = {
    init: function() {
      this.findElements();
      this.makeCallback('onInit', this);
      this.attachEvents();
    },
    findElements: function() {
      this.holder = jQuery(this.options.holder);
      this.items = this.holder.find(this.options.items);
      this.openers = this.items.find(this.options.opener);

      this.boxHold = this.holder.find(this.options.boxHold);
      this.slideBox = this.holder.find(this.options.slideWrap);

      this.btnClose = this.slideBox.find(this.options.btnClose);
      this.btnPrev = this.holder.find(this.options.btnPrev);
      this.btnNext = this.holder.find(this.options.btnNext);

      this.win = jQuery(window);
      this.showFlag = false;
      this.firstShowFlag = false;

      this.slideBox.hide();
      this.currentStep = 0;
      this.stepsCount = this.items.length;
    },
        attachEvents: function() {
      var self = this;

      this.clickHandler = function(e) {
        self.currentStep = self.openers.index(e.currentTarget);

        var item = self.items.eq(self.currentStep).parent();
        var slide = item.find(self.options.hiddenBox);

        if (slide.length !== 0){
          e.preventDefault();

          if (!self.holder.hasClass(self.options.activeClass)) {
            self.firstShowFlag = true;
            self.initShowSlide(true);
          } else {
            self.firstShowFlag = false;
            if (!item.hasClass(self.options.activeClass)) {
              self.initChangeSlide();
            } else {
              self.initHideSlide();
            }
          }
        }
      };

      this.onWindowResize = function() {
        if (self.showFlag) {
          self.resizeHandler();
        }
      };

      this.prevSlideHandler = function(e) {
        e.preventDefault();
        self.prevSlideSwitch();
      };

      this.nextSlideHandler = function(e) {
        e.preventDefault();
        self.nextSlideSwitch();
      };

      var activeItem = this.items.filter(this.options.activeClass);

      if (activeItem.length !== 0) {
        this.currentStep = this.items.index(activeItem);
        this.initShowSlide(false);
      }

      this.btnPrev.on('click', this.prevSlideHandler);
      this.btnNext.on('click', this.nextSlideHandler);
      this.openers.on('click', this.clickHandler);
      this.win.on('resize.triggerRefreshMenu orientationchange.triggerRefreshMenu', this.onWindowResize);
        },
        prevSlideSwitch: function() {
      var self = this;

      if (this.currentStep > 0) {
        this.currentStep--;
      } else {
        this.currentStep = this.stepsCount - 1;
      }

      this.initChangeSlide();
    },
    nextSlideSwitch: function() {
      var self = this;

      if (this.currentStep < this.stepsCount - 1) {
        this.currentStep++;
      } else {
        this.currentStep = 0;
      }

      this.initChangeSlide();
    },
    initShowSlide: function (flag) {
      var self = this;

      // self.resizeHandler();

      this.activeItem = this.items.eq(this.currentStep);
      var slide = this.activeItem.find(this.options.hiddenBox);

      this.items.removeClass(this.options.activeClass);
      this.holder.add(this.activeItem).addClass(this.options.activeClass);
      this.activeSlide = this.getActiveItem(this.activeItem);

      this.slideBox.insertAfter(this.activeSlide);

      slide.appendTo(this.slideBox);
      this.slideBox.data('parent', this.activeItem.children());

      this.slideBox.stop(true, true).slideDown({
        // duration: self.options.animSpeed,
        duration: !flag ? 0 : self.options.animSpeed,
        complete: function() {
          self.initCloseHandler();
          self.showFlag = true;
          self.makeCallback('onChange', self);
        }
      });
    },
    resizeHandler: function() {
      this.activeSlide = this.getActiveItem(this.activeItem);

      if (this.prevSlide !== this.activeSlide) {
        this.slideBox.hide();
        this.activeSlide = this.getActiveItem(this.activeItem);
        this.prevSlide = this.activeSlide;
        this.slideBox.insertAfter(this.activeSlide);
        this.slideBox.show();
      }
    },
    initCloseHandler: function() {
      var self = this;

      this.btnClose = this.slideBox.find(this.options.btnClose);

      this.closeHandler = function(e) {
        e.preventDefault();
        self.initHideSlide();
      };

      this.btnClose.on('click', this.closeHandler);
    },
    initChangeSlide: function (flag) {
      var self = this;

      self.slideBox.stop().slideUp({
        duration: !flag ? 0 : self.options.animSpeed,
        complete: function() {
          var parent = self.slideBox.data('parent');
          self.slideBox.children().appendTo(parent);
          self.initShowSlide(flag);
        }
      });
    },
    initHideSlide: function() {
      var self = this;
      this.galleryAnimating = false;
      this.holder.add(this.items).removeClass(this.options.activeClass);

      this.slideBox.stop().slideUp({
        duration: self.options.animSpeed,
        complete: function() {
          self.makeCallback('onChange', self);

          var parent = self.slideBox.data('parent');
          self.slideBox.children().appendTo(parent);

          self.galleryAnimating = true;
          self.showFlag = false;
        }
      });
    },
    getActiveItem: function(item) {
      var self = this;

      var lastSlide = self.items.filter(function() {
        return jQuery(this).offset().top === item.offset().top || (jQuery(this).offset().top + jQuery(this).height() > item.offset().top + item.height() && jQuery(this).offset().top + jQuery(this).height() < item.offset().top + item.height());
      }).last();

      return lastSlide;
    },
    makeCallback: function(name) {
      if (typeof this.options[name] === 'function') {
        var args = Array.prototype.slice.call(arguments);
        args.shift();
        this.options[name].apply(this, args);
      }
    }
    };

  $.fn.slideBox = function(options) {
    return this.each(function() {
      $(this).data('SlideBox', new SlideBox($.extend(options, { holder:this })));
    });
  };
})(jQuery);


// font resize script
FontResize = {
  options: {
    maxStep: 1.5,
    defaultFS: 0.875,
    resizeStep: 0.125,
    resizeHolder: 'body',
    cookieName: 'fontResizeCookie'
  },
  init: function() {
    this.runningLocal = (location.protocol.indexOf('file:') === 0);
    this.setDefaultScaling();
    this.addDefaultHandlers();
  },
  addDefaultHandlers: function() {
    this.addHandler('increase','inc');
    this.addHandler('decrease','dec');
    this.addHandler('reset');
  },
  setDefaultScaling: function() {
    if(this.options.resizeHolder == 'html') { this.resizeHolder = document.documentElement; }
    else { this.resizeHolder = document.body; }
    var cSize = this.getCookie(this.options.cookieName);
      this.fSize = this.options.defaultFS;
    this.changeSize();
  },
  changeSize: function(direction) {
    if(typeof direction !== 'undefined') {
      if(direction == 1) {
        this.fSize += this.options.resizeStep;
        if (this.fSize > this.options.defaultFS * this.options.maxStep) this.fSize = this.options.defaultFS * this.options.maxStep;
      } else if(direction == -1) {
        this.fSize -= this.options.resizeStep;
        if (this.fSize < this.options.defaultFS / this.options.maxStep) this.fSize = this.options.defaultFS / this.options.maxStep;
      } else {
        this.fSize = this.options.defaultFS;
      }
    }
    this.resizeHolder.style.fontSize = this.fSize + 'em';
    this.updateCookie(this.fSize.toFixed(2));

    // refresh Cufon if present
    if(typeof Cufon !== 'undefined' && typeof Cufon.refresh === 'function') {
      Cufon.refresh();
    }
    return false;
  },
  addHandler: function(obj, type) {
    if(typeof obj === 'string') { obj = document.getElementById(obj); }
    if(obj && obj.tagName) {
      switch (type) {
        case 'inc':
          obj.onclick = this.bind(this.changeSize,this, [1]);
          break;
        case 'dec':
          obj.onclick = this.bind(this.changeSize,this, [-1]);
          break;
        default:
          obj.onclick = this.bind(this.changeSize,this, [0]);
      }
    }
  },
  updateCookie: function(scaleLevel) {
    if(!this.runningLocal) {
      this.setCookie(this.options.cookieName,scaleLevel);
    }
  },
  getCookie: function(name) {
    var matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
    return matches ? decodeURIComponent(matches[1]) : undefined;
  },
  setCookie: function(name, value) {
    var exp = new Date();
    exp.setTime(exp.getTime()+(30*24*60*60*1000));
    document.cookie = name + '=' + value + ';' +'expires=' + exp.toGMTString() + ';' +'path=/';
  },
  bind: function(fn, scope, args){
    return function() {
      return fn.apply(scope, args || arguments);
    };
  }
};


function initFixedNav() {
    var win = jQuery(window);
    var body = jQuery('#wrapper');
    var header = jQuery('#header');
    var headerHeight = header.outerHeight();
    var fixedClass = 'fixed-header';
    var flag = false;

    resizeHandler();

    function resizeHandler() {
      var winTop = win.scrollTop();
      if (winTop >= headerHeight && !flag) {
        flag = true;
        body.addClass(fixedClass);
      } else if(winTop < headerHeight && flag) {
        flag = false;
        body.removeClass(fixedClass);
      }
    };

    win.on('resize orientationchange scroll', resizeHandler);
}


function initCollapse() {
  var containers = jQuery('.post-flexible');
  var win = jQuery(window);
  var activeClass = 'collapse-active';

    containers.each(function() {
      var holder = jQuery(this);
      var slide = holder.find('.post-slide');
      var content = slide.find('.post-content');
      var holderHeight = content.outerHeight();
      var maxHeight = holder.data('height') ? holder.data('height') : 100;

      if (holderHeight > maxHeight) {
        if (!holder.hasClass(activeClass)) {
          holder.addClass(activeClass);
        }
        slide.css('max-height', maxHeight);
        holder.attr('data-max', holderHeight);
        holder.attr('data-height', maxHeight);
      } else if(holderHeight < maxHeight && holder.hasClass(activeClass)){
        holder.removeClass(activeClass);
      }
    });

  containers.collapse({
    addClassBeforeAnimation: false,
    activeClass: 'post-active',
    opener: '.post-opener',
    slider: '.post-slide',
    animSpeed: 400,
    effect: 'none',
    onInit: function(self) {
      self.opener.on('click', function(e) {
        var slide = jQuery(this).closest('.slick-list');
        var container = jQuery(this).closest('.' + activeClass);
        var itemSlider = container.find(self.options.slider);
        var item = jQuery(self.holder);

        e.preventDefault();

        if (self.holder.hasClass(self.options.activeClass)) {
          itemSlider.css('max-height', container.data('max'));
          self.holder.addClass(self.options.activeClass);
        } else {
          itemSlider.css('max-height', container.data('height'));
          self.holder.removeClass(self.options.activeClass);
        }

        if (slide && container) {
          var slider = slide.closest('.slick-slider');

          setTimeout(function() {
            jQuery(slider).slick("slickSetOption", "refresh", null, true);
          }, self.options.animSpeed+1);
        }

      });
    }
  });
}

function initCarousel() {
  var flag = false;
  var container = jQuery('.products-gallery');
  var slideshow = jQuery('.products-carousel');
  var pagination = container.find('.pagination');
  var busyClass = 'busy';

  slideshow.slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    asNavFor: '.products-gallery .pagination'
  });

  pagination.slick({
    slidesToShow: 8,
    slidesToScroll: 1,
    asNavFor: '.products-carousel',
    dots: false,
    centerMode: false,
    focusOnSelect: true,
    draggable: false,
    nextArrow: '<span class="btn-right"><i class="icon-shevron-right"></i></span>',
    prevArrow: '<span class="btn-left"><i class="icon-shevron-left"></i></span>',
    responsive: [
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 4
        }
      }
      // You can unslick at a given breakpoint now by adding:
      // settings: "unslick"
      // instead of a settings object
    ]
  })
  slideshow.on('beforeChange', function(event, slick, currentSlide, nextSlide){
    if (!container.hasClass(busyClass)) {
      container.addClass(busyClass);
    }
  });
  slideshow.on('afterChange', function(event, slick, currentSlide, nextSlide){
    if (container.hasClass(busyClass)) {
      container.removeClass(busyClass);
    }
  });

  // jQuery('.products-gallery .pagination').on('beforeChange', function(event,slick,slide,nextSlide) {
  //     jQuery('.products-carousel').find('.slick-slide').removeClass('slick-current').eq(nextSlide).addClass('slick-current');
  // });

  jQuery('.carousel-default').slick({
    dots: false,
    infinite: true,
    speed: 600,
    slidesToShow: 1,
    adaptiveHeight: true,
    draggable: false,
    nextArrow: '<span class="btn-right"><i class="icon-shevron-right"></i></span>',
    prevArrow: '<span class="btn-left"><i class="icon-shevron-left"></i></span>',
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          draggable: true
        }
      }
    ]
  });
}

function initTooltips() {
  var tooltipBtn = jQuery('[data-toggle="tooltip"]');
  tooltipBtn.tooltip();
  tooltipBtn.on('click', function(e) {
    e.preventDefault();
  });
}


/*
 * jQuery Open/Close plugin
 */
;(function($) {
  function collapse(options) {
    this.options = $.extend({
      addClassBeforeAnimation: true,
      hideOnClickOutside: false,
      activeClass:'active',
      opener:'.opener',
      slider:'.slide',
      animSpeed: 400,
      effect:'fade',
      event:'click'
    }, options);
    this.init();
  }
  collapse.prototype = {
    init: function() {
      if (this.options.holder) {
        this.findElements();
        this.attachEvents();
        this.makeCallback('onInit', this);
      }
    },
    findElements: function() {
      this.holder = $(this.options.holder);
      this.opener = this.holder.find(this.options.opener);
      this.slider = this.holder.find(this.options.slider);
    },
    attachEvents: function() {
      // add handler
      var self = this;
      this.eventHandler = function(e) {
        e.preventDefault();
        if (self.slider.hasClass(slideHiddenClass)) {
          self.showSlide();
        } else {
          self.hideSlide();
        }
      };
      self.opener.bind(self.options.event, this.eventHandler);

      // hover mode handler
      if (self.options.event === 'over') {
        self.opener.bind('mouseenter', function() {
          if (!self.holder.hasClass(self.options.activeClass)){
            self.showSlide();
          }
        });
        self.holder.bind('mouseleave', function() {
          self.hideSlide();
        });
      }

      // outside click handler
      self.outsideClickHandler = function(e) {
        if (self.options.hideOnClickOutside) {
          var target = $(e.target);
          if (!target.is(self.holder) && !target.closest(self.holder).length) {
            self.hideSlide();
          }
        }
      };

      // set initial styles
      if (this.holder.hasClass(this.options.activeClass)) {
        $(document).bind('click touchstart', self.outsideClickHandler);
      } else {
        this.slider.addClass(slideHiddenClass);
      }
    },
    showSlide: function() {
      var self = this;
      if (self.options.addClassBeforeAnimation) {
        self.holder.addClass(self.options.activeClass);
      }
      self.slider.removeClass(slideHiddenClass);
      $(document).bind('click touchstart', self.outsideClickHandler);

      self.makeCallback('animStart', true);
      toggleEffects[self.options.effect].show({
        box: self.slider,
        speed: self.options.animSpeed,
        complete: function() {
          if (!self.options.addClassBeforeAnimation) {
            self.holder.addClass(self.options.activeClass);
          }
          self.makeCallback('animEnd', true);
        }
      });
    },
    hideSlide: function() {
      var self = this;
      if (self.options.addClassBeforeAnimation) {
        self.holder.removeClass(self.options.activeClass);
      }
      $(document).unbind('click touchstart', self.outsideClickHandler);

      self.makeCallback('animStart', false);
      toggleEffects[self.options.effect].hide({
        box: self.slider,
        speed: self.options.animSpeed,
        complete: function() {
          if (!self.options.addClassBeforeAnimation) {
            self.holder.removeClass(self.options.activeClass);
          }
          self.slider.addClass(slideHiddenClass);
          self.makeCallback('animEnd', false);
        }
      });
    },
    destroy: function() {
      console.log('ololo');
      this.slider.removeClass(slideHiddenClass).css({ display:'' });
      this.opener.unbind(this.options.event, this.eventHandler);
      this.holder.removeClass(this.options.activeClass).removeData('collapse');
      $(document).unbind('click touchstart', this.outsideClickHandler);
    },
    makeCallback: function(name) {
      if (typeof this.options[name] === 'function') {
        var args = Array.prototype.slice.call(arguments);
        args.shift();
        this.options[name].apply(this, args);
      }
    }
  };

  // add stylesheet for slide on DOMReady
  var slideHiddenClass = 'js-slide-hidden';
  (function() {
    var tabStyleSheet = $('<style type="text/css">')[0];
    var tabStyleRule = '.' + slideHiddenClass;
    tabStyleRule += '{position:absolute !important;left:-9999px !important;top:-9999px !important;display:block !important}';
    if (tabStyleSheet.styleSheet) {
      tabStyleSheet.styleSheet.cssText = tabStyleRule;
    } else {
      tabStyleSheet.appendChild(document.createTextNode(tabStyleRule));
    }
    $('head').append(tabStyleSheet);
  }());

  // animation effects
  var toggleEffects = {
    slide: {
      show: function(o) {
        o.box.stop(true).hide().slideDown(o.speed, o.complete);
      },
      hide: function(o) {
        o.box.stop(true).slideUp(o.speed, o.complete);
      }
    },
    fade: {
      show: function(o) {
        o.box.stop(true).hide().fadeIn(o.speed, o.complete);
      },
      hide: function(o) {
        o.box.stop(true).fadeOut(o.speed, o.complete);
      }
    },
    none: {
      show: function(o) {
        o.box.hide().show(0, o.complete);
      },
      hide: function(o) {
        o.box.hide(0, o.complete);
      }
    }
  };

  // jQuery plugin interface
  $.fn.collapse = function(opt) {
    return this.each(function() {
      jQuery(this).data('collapse', new collapse($.extend(opt, { holder: this })));
    });
  };
}(jQuery));

;(function($) {
  function BurgerNavigation(options) {
    this.options = $.extend({
      container: null,
      hideOnClickOutside: false,
      BurgerActiveClass: 'nav-active',
      BurgerOpener: '.nav-opener',
      BurgerDrop: '.nav-drop',
      toggleEvent: 'click',
      outsideClickEvent: 'click touchstart pointerdown MSPointerDown'
    }, options);
    this.createStructure();
    this.attachEvents();
  }
  BurgerNavigation.prototype = {
    createStructure: function() {
      this.page = $('html');
      this.container = $(this.options.container);
      this.opener = this.container.find(this.options.BurgerOpener);
      this.drop = this.container.find(this.options.BurgerDrop);
    },
    attachEvents: function() {
      var self = this;

      if(activateResizeHandler) {
        activateResizeHandler();
        activateResizeHandler = null;
      }

      this.outsideClickHandler = function(e) {
        if(self.isOpened()) {
          var target = $(e.target);
          if(!target.closest(self.opener).length && !target.closest(self.drop).length) {
            self.hide();
          }
        }
      };

      this.openerClickHandler = function(e) {
        e.preventDefault();
        self.toggle();
      };

      this.opener.on(this.options.toggleEvent, this.openerClickHandler);
    },
    isOpened: function() {
      return this.container.hasClass(this.options.BurgerActiveClass);
    },
    show: function() {
      this.container.addClass(this.options.BurgerActiveClass);
      if(this.options.hideOnClickOutside) {
        this.page.on(this.options.outsideClickEvent, this.outsideClickHandler);
      }
    },
    hide: function() {
      this.container.removeClass(this.options.BurgerActiveClass);
      if(this.options.hideOnClickOutside) {
        this.page.off(this.options.outsideClickEvent, this.outsideClickHandler);
      }
    },
    toggle: function() {
      if(this.isOpened()) {
        this.hide();
      } else {
        this.show();
      }
    },
    destroy: function() {
      this.container.removeClass(this.options.BurgerActiveClass);
      this.opener.off(this.options.toggleEvent, this.clickHandler);
      this.page.off(this.options.outsideClickEvent, this.outsideClickHandler);
    }
  };

  var activateResizeHandler = function() {
    var win = $(window),
      doc = $('html'),
      resizeClass = 'resize-active',
      flag, timer;
    var removeClassHandler = function() {
      flag = false;
      doc.removeClass(resizeClass);
    };
    var resizeHandler = function() {
      if(!flag) {
        flag = true;
        doc.addClass(resizeClass);
      }
      clearTimeout(timer);
      timer = setTimeout(removeClassHandler, 500);
    };
    win.on('resize orientationchange', resizeHandler);
  };

  $.fn.BurgerNavigation = function(options) {
    return this.each(function() {
      var params = $.extend({}, options, {container: this}),
        instance = new BurgerNavigation(params);
      $.data(this, 'BurgerNavigation', instance);
    });
  };
}(jQuery));


/*
 * jQuery bg cover plugin
 */
 ;(function($) {
  'use strict';

  var styleRules = {};
  var templates = {
    '2x': [
      '(-webkit-min-device-pixel-ratio: 1.5)',
      '(min-resolution: 192dpi)',
      '(min-device-pixel-ratio: 1.5)',
      '(min-resolution: 1.5dppx)'
    ],
    '3x': [
      '(-webkit-min-device-pixel-ratio: 3)',
      '(min-resolution: 384dpi)',
      '(min-device-pixel-ratio: 3)',
      '(min-resolution: 3dppx)'
    ]
  };

  function addSimple(imageSrc, media, id) {
    var style = buildRule(id, imageSrc);

    addRule(media, style);
  }

  function addRetina(imageData, media, id) {
    var currentRules = templates[imageData[1]].slice();
    var patchedRules = currentRules;
    var style = buildRule(id, imageData[0]);

    if (media !== 'default') {
      patchedRules = $.map(currentRules, function(ele, i) {
        return ele + ' and ' + media;
      });
    }

    media = patchedRules.join(',');

    addRule(media, style);
  }

  function buildRule(id, src) {
    return '#' + id + '{background-image: url("' + src + '");}';
  }

  function addRule(media, rule) {
    var $styleTag = styleRules[media];
    var styleTagData;
    var rules = '';

    if (media === 'default') {
      rules = rule + ' ';
    } else {
      rules = '@media ' + media + '{' + rule + '}';
    }

    if (!$styleTag) {
      styleRules[media] = $('<style>').text(rules).appendTo('head');
    } else {
      styleTagData = $styleTag.text();
      styleTagData = styleTagData.substring(0, styleTagData.length - 2) + ' }' + rule + '}';
      $styleTag.text(styleTagData);
    }
  }

  $.fn.bgCover = function() {
    return this.each(function() {
      var $block = $(this);
      var $items = $block.children('[data-srcset]');
      var id = 'bg-stretch' + Date.now() + (Math.random() * 1000).toFixed(0);

      if ($items.length) {
        $block.attr('id', id);

        $items.each(function() {
          var $item = $(this);
          var data = $item.data('srcset').split(', ');
          var media = $item.data('media') || 'default';
          var dataLength = data.length;
          var itemData;
          var i;

          for (i = 0; i < dataLength; i++) {
            itemData = data[i].split(' ');

            if (itemData.length === 1) {
              addSimple(itemData[0], media, id);
            } else {
              addRetina(itemData, media, id);
            }
          }
        });
      }

      $items.detach();
    });
  };
 }(jQuery));

// tabs plugin
!function(a,b){"use strict";function c(a,b){this.$holder=a,this.options=b,this.init()}c.prototype={init:function(){this.$tabLinks=this.$holder.find(this.options.tabLinks),this.setStartActiveIndex(),this.setActiveTab(),this.options.autoHeight&&(this.$tabHolder=a(this.$tabLinks.eq(0).attr(this.options.attrib)).parent()),this.makeCallback("onInit",this)},setStartActiveIndex:function(){var d,a=this.getClassTarget(this.$tabLinks),b=a.filter("."+this.options.activeClass),c=this.$tabLinks.filter("["+this.options.attrib+'="'+location.hash+'"]');this.options.checkHash&&c.length&&(b=c),d=a.index(b),this.activeTabIndex=this.prevTabIndex=d===-1?this.options.defaultTab?0:null:d},setActiveTab:function(){var b=this;this.$tabLinks.each(function(c,d){var e=a(d),f=b.getClassTarget(e),g=a(e.attr(b.options.attrib));c!==b.activeTabIndex?(f.removeClass(b.options.activeClass),g.addClass(b.options.tabHiddenClass).removeClass(b.options.activeClass)):(f.addClass(b.options.activeClass),g.removeClass(b.options.tabHiddenClass).addClass(b.options.activeClass)),b.attachTabLink(e,c)})},attachTabLink:function(a,b){var c=this;a.on(this.options.event+".tabset",function(a){a.preventDefault(),c.activeTabIndex===c.prevTabIndex&&c.activeTabIndex!==b&&(c.activeTabIndex=b,c.switchTabs())})},resizeHolder:function(a){var b=this;a?(this.$tabHolder.height(a),setTimeout(function(){b.$tabHolder.addClass("transition")},10)):b.$tabHolder.removeClass("transition").height("")},switchTabs:function(){var a=this,b=this.$tabLinks.eq(this.prevTabIndex),c=this.$tabLinks.eq(this.activeTabIndex),d=this.getTab(b),e=this.getTab(c);d.removeClass(this.options.activeClass),a.haveTabHolder()&&this.resizeHolder(d.outerHeight()),setTimeout(function(){a.getClassTarget(b).removeClass(a.options.activeClass),d.addClass(a.options.tabHiddenClass),e.removeClass(a.options.tabHiddenClass).addClass(a.options.activeClass),a.getClassTarget(c).addClass(a.options.activeClass),a.haveTabHolder()?(a.resizeHolder(e.outerHeight()),setTimeout(function(){a.resizeHolder(),a.prevTabIndex=a.activeTabIndex,a.makeCallback("onChange",a)},a.options.animSpeed)):a.prevTabIndex=a.activeTabIndex},this.options.autoHeight?this.options.animSpeed:1)},getClassTarget:function(a){return this.options.addToParent?a.parent():a},getActiveTab:function(){return this.getTab(this.$tabLinks.eq(this.activeTabIndex))},getTab:function(b){return a(b.attr(this.options.attrib))},haveTabHolder:function(){return this.$tabHolder&&this.$tabHolder.length},destroy:function(){var b=this;this.$tabLinks.off(".tabset").each(function(){var c=a(this);b.getClassTarget(c).removeClass(b.options.activeClass),a(c.attr(b.options.attrib)).removeClass(b.options.activeClass+" "+b.options.tabHiddenClass)}),this.$holder.removeData("Tabset")},makeCallback:function(a){if("function"==typeof this.options[a]){var b=Array.prototype.slice.call(arguments);b.shift(),this.options[a].apply(this,b)}}},a.fn.tabset=function(b){var d=Array.prototype.slice.call(arguments),e=d[0],f=a.extend({activeClass:"active",addToParent:!1,autoHeight:!1,checkHash:!1,defaultTab:!0,animSpeed:500,tabLinks:"a",attrib:"href",event:"click",tabHiddenClass:"js-tab-hidden"},b);return f.autoHeight=f.autoHeight&&a.support.opacity,this.each(function(){var a=jQuery(this),g=a.data("Tabset");"object"==typeof b||"undefined"==typeof b?a.data("Tabset",new c(a,f)):"string"==typeof e&&g&&"function"==typeof g[e]&&(d.shift(),g[e].apply(g,d))})}}(jQuery,jQuery(window));

/*! jQuery Migrate v3.0.0 | (c) jQuery Foundation and other contributors | jquery.org/license */
"undefined"==typeof jQuery.migrateMute&&(jQuery.migrateMute=!0),function(a,b){"use strict";function c(c){var d=b.console;e[c]||(e[c]=!0,a.migrateWarnings.push(c),d&&d.warn&&!a.migrateMute&&(d.warn("JQMIGRATE: "+c),a.migrateTrace&&d.trace&&d.trace()))}function d(a,b,d,e){Object.defineProperty(a,b,{configurable:!0,enumerable:!0,get:function(){return c(e),d}})}a.migrateVersion="3.0.0",function(){var c=b.console&&b.console.log&&function(){b.console.log.apply(b.console,arguments)},d=/^[12]\./;c&&(a&&!d.test(a.fn.jquery)||c("JQMIGRATE: jQuery 3.0.0+ REQUIRED"),a.migrateWarnings&&c("JQMIGRATE: Migrate plugin loaded multiple times"),c("JQMIGRATE: Migrate is installed"+(a.migrateMute?"":" with logging active")+", version "+a.migrateVersion))}();var e={};a.migrateWarnings=[],void 0===a.migrateTrace&&(a.migrateTrace=!0),a.migrateReset=function(){e={},a.migrateWarnings.length=0},"BackCompat"===document.compatMode&&c("jQuery is not compatible with Quirks Mode");var f=a.fn.init,g=a.isNumeric,h=a.find,i=/\[(\s*[-\w]+\s*)([~|^$*]?=)\s*([-\w#]*?#[-\w#]*)\s*\]/,j=/\[(\s*[-\w]+\s*)([~|^$*]?=)\s*([-\w#]*?#[-\w#]*)\s*\]/g;a.fn.init=function(a){var b=Array.prototype.slice.call(arguments);return"string"==typeof a&&"#"===a&&(c("jQuery( '#' ) is not a valid selector"),b[0]=[]),f.apply(this,b)},a.fn.init.prototype=a.fn,a.find=function(a){var b=Array.prototype.slice.call(arguments);if("string"==typeof a&&i.test(a))try{document.querySelector(a)}catch(d){a=a.replace(j,function(a,b,c,d){return"["+b+c+'"'+d+'"]'});try{document.querySelector(a),c("Attribute selector with '#' must be quoted: "+b[0]),b[0]=a}catch(e){c("Attribute selector with '#' was not fixed: "+b[0])}}return h.apply(this,b)};var k;for(k in h)Object.prototype.hasOwnProperty.call(h,k)&&(a.find[k]=h[k]);a.fn.size=function(){return c("jQuery.fn.size() is deprecated; use the .length property"),this.length},a.parseJSON=function(){return c("jQuery.parseJSON is deprecated; use JSON.parse"),JSON.parse.apply(null,arguments)},a.isNumeric=function(b){function d(b){var c=b&&b.toString();return!a.isArray(b)&&c-parseFloat(c)+1>=0}var e=g(b),f=d(b);return e!==f&&c("jQuery.isNumeric() should not be called on constructed objects"),f},d(a,"unique",a.uniqueSort,"jQuery.unique is deprecated, use jQuery.uniqueSort"),d(a.expr,"filters",a.expr.pseudos,"jQuery.expr.filters is now jQuery.expr.pseudos"),d(a.expr,":",a.expr.pseudos,'jQuery.expr[":"] is now jQuery.expr.pseudos');var l=a.ajax;a.ajax=function(){var a=l.apply(this,arguments);return a.promise&&(d(a,"success",a.done,"jQXHR.success is deprecated and removed"),d(a,"error",a.fail,"jQXHR.error is deprecated and removed"),d(a,"complete",a.always,"jQXHR.complete is deprecated and removed")),a};var m=a.fn.removeAttr,n=a.fn.toggleClass,o=/\S+/g;a.fn.removeAttr=function(b){var d=this;return a.each(b.match(o),function(b,e){a.expr.match.bool.test(e)&&(c("jQuery.fn.removeAttr no longer sets boolean properties: "+e),d.prop(e,!1))}),m.apply(this,arguments)},a.fn.toggleClass=function(b){return void 0!==b&&"boolean"!=typeof b?n.apply(this,arguments):(c("jQuery.fn.toggleClass( boolean ) is deprecated"),this.each(function(){var c=this.getAttribute&&this.getAttribute("class")||"";c&&a.data(this,"__className__",c),this.setAttribute&&this.setAttribute("class",c||b===!1?"":a.data(this,"__className__")||"")}))};var p=!1;a.swap&&a.each(["height","width","reliableMarginRight"],function(b,c){var d=a.cssHooks[c]&&a.cssHooks[c].get;d&&(a.cssHooks[c].get=function(){var a;return p=!0,a=d.apply(this,arguments),p=!1,a})}),a.swap=function(a,b,d,e){var f,g,h={};p||c("jQuery.swap() is undocumented and deprecated");for(g in b)h[g]=a.style[g],a.style[g]=b[g];f=d.apply(a,e||[]);for(g in b)a.style[g]=h[g];return f};var q=a.data;a.data=function(b,d,e){var f;return d&&d!==a.camelCase(d)&&(f=a.hasData(b)&&q.call(this,b),f&&d in f)?(c("jQuery.data() always sets/gets camelCased names: "+d),arguments.length>2&&(f[d]=e),f[d]):q.apply(this,arguments)};var r=a.Tween.prototype.run;a.Tween.prototype.run=function(b){a.easing[this.easing].length>1&&(c('easing function "jQuery.easing.'+this.easing.toString()+'" should use only first argument'),a.easing[this.easing]=a.easing[this.easing].bind(a.easing,b,this.options.duration*b,0,1,this.options.duration)),r.apply(this,arguments)};var s=a.fn.load,t=a.event.fix;a.event.props=[],a.event.fixHooks={},a.event.fix=function(b){var d,e=b.type,f=this.fixHooks[e],g=a.event.props;if(g.length)for(c("jQuery.event.props are deprecated and removed: "+g.join());g.length;)a.event.addProp(g.pop());if(f&&!f._migrated_&&(f._migrated_=!0,c("jQuery.event.fixHooks are deprecated and removed: "+e),(g=f.props)&&g.length))for(;g.length;)a.event.addProp(g.pop());return d=t.call(this,b),f&&f.filter?f.filter(d,b):d},a.each(["load","unload","error"],function(b,d){a.fn[d]=function(){var a=Array.prototype.slice.call(arguments,0);return"load"===d&&"string"==typeof a[0]?s.apply(this,a):(c("jQuery.fn."+d+"() is deprecated"),a.splice(0,0,d),arguments.length?this.on.apply(this,a):(this.triggerHandler.apply(this,a),this))}}),a(function(){a(document).triggerHandler("ready")}),a.event.special.ready={setup:function(){this===document&&c("'ready' event is deprecated")}},a.fn.extend({bind:function(a,b,d){return c("jQuery.fn.bind() is deprecated"),this.on(a,null,b,d)},unbind:function(a,b){return c("jQuery.fn.unbind() is deprecated"),this.off(a,null,b)},delegate:function(a,b,d,e){return c("jQuery.fn.delegate() is deprecated"),this.on(b,a,d,e)},undelegate:function(a,b,d){return c("jQuery.fn.undelegate() is deprecated"),1===arguments.length?this.off(a,"**"):this.off(b,a||"**",d)}});var u=a.fn.offset;a.fn.offset=function(){var b,d=this[0],e={top:0,left:0};return d&&d.nodeType?(b=(d.ownerDocument||document).documentElement,a.contains(b,d)?u.apply(this,arguments):(c("jQuery.fn.offset() requires an element connected to a document"),e)):(c("jQuery.fn.offset() requires a valid DOM element"),e)};var v=a.param;a.param=function(b,d){var e=a.ajaxSettings&&a.ajaxSettings.traditional;return void 0===d&&e&&(c("jQuery.param() no longer uses jQuery.ajaxSettings.traditional"),d=e),v.call(this,b,d)};var w=a.fn.andSelf||a.fn.addBack;a.fn.andSelf=function(){return c("jQuery.fn.andSelf() replaced by jQuery.fn.addBack()"),w.apply(this,arguments)};var x=a.Deferred,y=[["resolve","done",a.Callbacks("once memory"),a.Callbacks("once memory"),"resolved"],["reject","fail",a.Callbacks("once memory"),a.Callbacks("once memory"),"rejected"],["notify","progress",a.Callbacks("memory"),a.Callbacks("memory")]];a.Deferred=function(b){var d=x(),e=d.promise();return d.pipe=e.pipe=function(){var b=arguments;return c("deferred.pipe() is deprecated"),a.Deferred(function(c){a.each(y,function(f,g){var h=a.isFunction(b[f])&&b[f];d[g[1]](function(){var b=h&&h.apply(this,arguments);b&&a.isFunction(b.promise)?b.promise().done(c.resolve).fail(c.reject).progress(c.notify):c[g[0]+"With"](this===e?c.promise():this,h?[b]:arguments)})}),b=null}).promise()},b&&b.call(d,d),d}}(jQuery,window);

/*! Picturefill - v3.0.1 - 2015-09-30
 * http://scottjehl.github.io/picturefill
 * Copyright (c) 2015 https://github.com/scottjehl/picturefill/blob/master/Authors.txt; Licensed MIT
 */
!function(a){var b=navigator.userAgent;a.HTMLPictureElement&&/ecko/.test(b)&&b.match(/rv\:(\d+)/)&&RegExp.$1<41&&addEventListener("resize",function(){var b,c=document.createElement("source"),d=function(a){var b,d,e=a.parentNode;"PICTURE"===e.nodeName.toUpperCase()?(b=c.cloneNode(),e.insertBefore(b,e.firstElementChild),setTimeout(function(){e.removeChild(b)})):(!a._pfLastSize||a.offsetWidth>a._pfLastSize)&&(a._pfLastSize=a.offsetWidth,d=a.sizes,a.sizes+=",100vw",setTimeout(function(){a.sizes=d}))},e=function(){var a,b=document.querySelectorAll("picture > img, img[srcset][sizes]");for(a=0;a<b.length;a++)d(b[a])},f=function(){clearTimeout(b),b=setTimeout(e,99)},g=a.matchMedia&&matchMedia("(orientation: landscape)"),h=function(){f(),g&&g.addListener&&g.addListener(f)};return c.srcset="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==",/^[c|i]|d$/.test(document.readyState||"")?h():document.addEventListener("DOMContentLoaded",h),f}())}(window),function(a,b,c){"use strict";function d(a){return" "===a||"  "===a||"\n"===a||"\f"===a||"\r"===a}function e(b,c){var d=new a.Image;return d.onerror=function(){z[b]=!1,aa()},d.onload=function(){z[b]=1===d.width,aa()},d.src=c,"pending"}function f(){L=!1,O=a.devicePixelRatio,M={},N={},s.DPR=O||1,P.width=Math.max(a.innerWidth||0,y.clientWidth),P.height=Math.max(a.innerHeight||0,y.clientHeight),P.vw=P.width/100,P.vh=P.height/100,r=[P.height,P.width,O].join("-"),P.em=s.getEmValue(),P.rem=P.em}function g(a,b,c,d){var e,f,g,h;return"saveData"===A.algorithm?a>2.7?h=c+1:(f=b-c,e=Math.pow(a-.6,1.5),g=f*e,d&&(g+=.1*e),h=a+g):h=c>1?Math.sqrt(a*b):a,h>c}function h(a){var b,c=s.getSet(a),d=!1;"pending"!==c&&(d=r,c&&(b=s.setRes(c),s.applySetCandidate(b,a))),a[s.ns].evaled=d}function i(a,b){return a.res-b.res}function j(a,b,c){var d;return!c&&b&&(c=a[s.ns].sets,c=c&&c[c.length-1]),d=k(b,c),d&&(b=s.makeUrl(b),a[s.ns].curSrc=b,a[s.ns].curCan=d,d.res||_(d,d.set.sizes)),d}function k(a,b){var c,d,e;if(a&&b)for(e=s.parseSet(b),a=s.makeUrl(a),c=0;c<e.length;c++)if(a===s.makeUrl(e[c].url)){d=e[c];break}return d}function l(a,b){var c,d,e,f,g=a.getElementsByTagName("source");for(c=0,d=g.length;d>c;c++)e=g[c],e[s.ns]=!0,f=e.getAttribute("srcset"),f&&b.push({srcset:f,media:e.getAttribute("media"),type:e.getAttribute("type"),sizes:e.getAttribute("sizes")})}function m(a,b){function c(b){var c,d=b.exec(a.substring(m));return d?(c=d[0],m+=c.length,c):void 0}function e(){var a,c,d,e,f,i,j,k,l,m=!1,o={};for(e=0;e<h.length;e++)f=h[e],i=f[f.length-1],j=f.substring(0,f.length-1),k=parseInt(j,10),l=parseFloat(j),W.test(j)&&"w"===i?((a||c)&&(m=!0),0===k?m=!0:a=k):X.test(j)&&"x"===i?((a||c||d)&&(m=!0),0>l?m=!0:c=l):W.test(j)&&"h"===i?((d||c)&&(m=!0),0===k?m=!0:d=k):m=!0;m||(o.url=g,a&&(o.w=a),c&&(o.d=c),d&&(o.h=d),d||c||a||(o.d=1),1===o.d&&(b.has1x=!0),o.set=b,n.push(o))}function f(){for(c(S),i="",j="in descriptor";;){if(k=a.charAt(m),"in descriptor"===j)if(d(k))i&&(h.push(i),i="",j="after descriptor");else{if(","===k)return m+=1,i&&h.push(i),void e();if("("===k)i+=k,j="in parens";else{if(""===k)return i&&h.push(i),void e();i+=k}}else if("in parens"===j)if(")"===k)i+=k,j="in descriptor";else{if(""===k)return h.push(i),void e();i+=k}else if("after descriptor"===j)if(d(k));else{if(""===k)return void e();j="in descriptor",m-=1}m+=1}}for(var g,h,i,j,k,l=a.length,m=0,n=[];;){if(c(T),m>=l)return n;g=c(U),h=[],","===g.slice(-1)?(g=g.replace(V,""),e()):f()}}function n(a){function b(a){function b(){f&&(g.push(f),f="")}function c(){g[0]&&(h.push(g),g=[])}for(var e,f="",g=[],h=[],i=0,j=0,k=!1;;){if(e=a.charAt(j),""===e)return b(),c(),h;if(k){if("*"===e&&"/"===a[j+1]){k=!1,j+=2,b();continue}j+=1}else{if(d(e)){if(a.charAt(j-1)&&d(a.charAt(j-1))||!f){j+=1;continue}if(0===i){b(),j+=1;continue}e=" "}else if("("===e)i+=1;else if(")"===e)i-=1;else{if(","===e){b(),c(),j+=1;continue}if("/"===e&&"*"===a.charAt(j+1)){k=!0,j+=2;continue}}f+=e,j+=1}}}function c(a){return k.test(a)&&parseFloat(a)>=0?!0:l.test(a)?!0:"0"===a||"-0"===a||"+0"===a?!0:!1}var e,f,g,h,i,j,k=/^(?:[+-]?[0-9]+|[0-9]*\.[0-9]+)(?:[eE][+-]?[0-9]+)?(?:ch|cm|em|ex|in|mm|pc|pt|px|rem|vh|vmin|vmax|vw)$/i,l=/^calc\((?:[0-9a-z \.\+\-\*\/\(\)]+)\)$/i;for(f=b(a),g=f.length,e=0;g>e;e++)if(h=f[e],i=h[h.length-1],c(i)){if(j=i,h.pop(),0===h.length)return j;if(h=h.join(" "),s.matchesMedia(h))return j}return"100vw"}b.createElement("picture");var o,p,q,r,s={},t=function(){},u=b.createElement("img"),v=u.getAttribute,w=u.setAttribute,x=u.removeAttribute,y=b.documentElement,z={},A={algorithm:""},B="data-pfsrc",C=B+"set",D=navigator.userAgent,E=/rident/.test(D)||/ecko/.test(D)&&D.match(/rv\:(\d+)/)&&RegExp.$1>35,F="currentSrc",G=/\s+\+?\d+(e\d+)?w/,H=/(\([^)]+\))?\s*(.+)/,I=a.picturefillCFG,J="position:absolute;left:0;visibility:hidden;display:block;padding:0;border:none;font-size:1em;width:1em;overflow:hidden;clip:rect(0px, 0px, 0px, 0px)",K="font-size:100%!important;",L=!0,M={},N={},O=a.devicePixelRatio,P={px:1,"in":96},Q=b.createElement("a"),R=!1,S=/^[ \t\n\r\u000c]+/,T=/^[, \t\n\r\u000c]+/,U=/^[^ \t\n\r\u000c]+/,V=/[,]+$/,W=/^\d+$/,X=/^-?(?:[0-9]+|[0-9]*\.[0-9]+)(?:[eE][+-]?[0-9]+)?$/,Y=function(a,b,c,d){a.addEventListener?a.addEventListener(b,c,d||!1):a.attachEvent&&a.attachEvent("on"+b,c)},Z=function(a){var b={};return function(c){return c in b||(b[c]=a(c)),b[c]}},$=function(){var a=/^([\d\.]+)(em|vw|px)$/,b=function(){for(var a=arguments,b=0,c=a[0];++b in a;)c=c.replace(a[b],a[++b]);return c},c=Z(function(a){return"return "+b((a||"").toLowerCase(),/\band\b/g,"&&",/,/g,"||",/min-([a-z-\s]+):/g,"e.$1>=",/max-([a-z-\s]+):/g,"e.$1<=",/calc([^)]+)/g,"($1)",/(\d+[\.]*[\d]*)([a-z]+)/g,"($1 * e.$2)",/^(?!(e.[a-z]|[0-9\.&=|><\+\-\*\(\)\/])).*/gi,"")+";"});return function(b,d){var e;if(!(b in M))if(M[b]=!1,d&&(e=b.match(a)))M[b]=e[1]*P[e[2]];else try{M[b]=new Function("e",c(b))(P)}catch(f){}return M[b]}}(),_=function(a,b){return a.w?(a.cWidth=s.calcListLength(b||"100vw"),a.res=a.w/a.cWidth):a.res=a.d,a},aa=function(a){var c,d,e,f=a||{};if(f.elements&&1===f.elements.nodeType&&("IMG"===f.elements.nodeName.toUpperCase()?f.elements=[f.elements]:(f.context=f.elements,f.elements=null)),c=f.elements||s.qsa(f.context||b,f.reevaluate||f.reselect?s.sel:s.selShort),e=c.length){for(s.setupRun(f),R=!0,d=0;e>d;d++)s.fillImg(c[d],f);s.teardownRun(f)}};o=a.console&&console.warn?function(a){console.warn(a)}:t,F in u||(F="src"),z["image/jpeg"]=!0,z["image/gif"]=!0,z["image/png"]=!0,z["image/svg+xml"]=b.implementation.hasFeature("http://wwwindow.w3.org/TR/SVG11/feature#Image","1.1"),s.ns=("pf"+(new Date).getTime()).substr(0,9),s.supSrcset="srcset"in u,s.supSizes="sizes"in u,s.supPicture=!!a.HTMLPictureElement,s.supSrcset&&s.supPicture&&!s.supSizes&&!function(a){u.srcset="data:,a",a.src="data:,a",s.supSrcset=u.complete===a.complete,s.supPicture=s.supSrcset&&s.supPicture}(b.createElement("img")),s.selShort="picture>img,img[srcset]",s.sel=s.selShort,s.cfg=A,s.supSrcset&&(s.sel+=",img["+C+"]"),s.DPR=O||1,s.u=P,s.types=z,q=s.supSrcset&&!s.supSizes,s.setSize=t,s.makeUrl=Z(function(a){return Q.href=a,Q.href}),s.qsa=function(a,b){return a.querySelectorAll(b)},s.matchesMedia=function(){return a.matchMedia&&(matchMedia("(min-width: 0.1em)")||{}).matches?s.matchesMedia=function(a){return!a||matchMedia(a).matches}:s.matchesMedia=s.mMQ,s.matchesMedia.apply(this,arguments)},s.mMQ=function(a){return a?$(a):!0},s.calcLength=function(a){var b=$(a,!0)||!1;return 0>b&&(b=!1),b},s.supportsType=function(a){return a?z[a]:!0},s.parseSize=Z(function(a){var b=(a||"").match(H);return{media:b&&b[1],length:b&&b[2]}}),s.parseSet=function(a){return a.cands||(a.cands=m(a.srcset,a)),a.cands},s.getEmValue=function(){var a;if(!p&&(a=b.body)){var c=b.createElement("div"),d=y.style.cssText,e=a.style.cssText;c.style.cssText=J,y.style.cssText=K,a.style.cssText=K,a.appendChild(c),p=c.offsetWidth,a.removeChild(c),p=parseFloat(p,10),y.style.cssText=d,a.style.cssText=e}return p||16},s.calcListLength=function(a){if(!(a in N)||A.uT){var b=s.calcLength(n(a));N[a]=b?b:P.width}return N[a]},s.setRes=function(a){var b;if(a){b=s.parseSet(a);for(var c=0,d=b.length;d>c;c++)_(b[c],a.sizes)}return b},s.setRes.res=_,s.applySetCandidate=function(a,b){if(a.length){var c,d,e,f,h,k,l,m,n,o=b[s.ns],p=s.DPR;if(k=o.curSrc||b[F],l=o.curCan||j(b,k,a[0].set),l&&l.set===a[0].set&&(n=E&&!b.complete&&l.res-.1>p,n||(l.cached=!0,l.res>=p&&(h=l))),!h)for(a.sort(i),f=a.length,h=a[f-1],d=0;f>d;d++)if(c=a[d],c.res>=p){e=d-1,h=a[e]&&(n||k!==s.makeUrl(c.url))&&g(a[e].res,c.res,p,a[e].cached)?a[e]:c;break}h&&(m=s.makeUrl(h.url),o.curSrc=m,o.curCan=h,m!==k&&s.setSrc(b,h),s.setSize(b))}},s.setSrc=function(a,b){var c;a.src=b.url,"image/svg+xml"===b.set.type&&(c=a.style.width,a.style.width=a.offsetWidth+1+"px",a.offsetWidth+1&&(a.style.width=c))},s.getSet=function(a){var b,c,d,e=!1,f=a[s.ns].sets;for(b=0;b<f.length&&!e;b++)if(c=f[b],c.srcset&&s.matchesMedia(c.media)&&(d=s.supportsType(c.type))){"pending"===d&&(c=d),e=c;break}return e},s.parseSets=function(a,b,d){var e,f,g,h,i=b&&"PICTURE"===b.nodeName.toUpperCase(),j=a[s.ns];(j.src===c||d.src)&&(j.src=v.call(a,"src"),j.src?w.call(a,B,j.src):x.call(a,B)),(j.srcset===c||d.srcset||!s.supSrcset||a.srcset)&&(e=v.call(a,"srcset"),j.srcset=e,h=!0),j.sets=[],i&&(j.pic=!0,l(b,j.sets)),j.srcset?(f={srcset:j.srcset,sizes:v.call(a,"sizes")},j.sets.push(f),g=(q||j.src)&&G.test(j.srcset||""),g||!j.src||k(j.src,f)||f.has1x||(f.srcset+=", "+j.src,f.cands.push({url:j.src,d:1,set:f}))):j.src&&j.sets.push({srcset:j.src,sizes:null}),j.curCan=null,j.curSrc=c,j.supported=!(i||f&&!s.supSrcset||g),h&&s.supSrcset&&!j.supported&&(e?(w.call(a,C,e),a.srcset=""):x.call(a,C)),j.supported&&!j.srcset&&(!j.src&&a.src||a.src!==s.makeUrl(j.src))&&(null===j.src?a.removeAttribute("src"):a.src=j.src),j.parsed=!0},s.fillImg=function(a,b){var c,d=b.reselect||b.reevaluate;a[s.ns]||(a[s.ns]={}),c=a[s.ns],(d||c.evaled!==r)&&((!c.parsed||b.reevaluate)&&s.parseSets(a,a.parentNode,b),c.supported?c.evaled=r:h(a))},s.setupRun=function(){(!R||L||O!==a.devicePixelRatio)&&f()},s.supPicture?(aa=t,s.fillImg=t):!function(){var c,d=a.attachEvent?/d$|^c/:/d$|^c|^i/,e=function(){var a=b.readyState||"";f=setTimeout(e,"loading"===a?200:999),b.body&&(s.fillImgs(),c=c||d.test(a),c&&clearTimeout(f))},f=setTimeout(e,b.body?9:99),g=function(a,b){var c,d,e=function(){var f=new Date-d;b>f?c=setTimeout(e,b-f):(c=null,a())};return function(){d=new Date,c||(c=setTimeout(e,b))}},h=y.clientHeight,i=function(){L=Math.max(a.innerWidth||0,y.clientWidth)!==P.width||y.clientHeight!==h,h=y.clientHeight,L&&s.fillImgs()};Y(a,"resize",g(i,99)),Y(b,"readystatechange",e)}(),s.picturefill=aa,s.fillImgs=aa,s.teardownRun=t,aa._=s,a.picturefillCFG={pf:s,push:function(a){var b=a.shift();"function"==typeof s[b]?s[b].apply(s,a):(A[b]=a[0],R&&s.fillImgs({reselect:!0}))}};for(;I&&I.length;)a.picturefillCFG.push(I.shift());a.picturefill=aa,"object"==typeof module&&"object"==typeof module.exports?module.exports=aa:"function"==typeof define&&define.amd&&define("picturefill",function(){return aa}),s.supPicture||(z["image/webp"]=e("image/webp","data:image/webp;base64,UklGRkoAAABXRUJQVlA4WAoAAAAQAAAAAAAAAAAAQUxQSAwAAAABBxAR/Q9ERP8DAABWUDggGAAAADABAJ0BKgEAAQADADQlpAADcAD++/1QAA=="))}(window,document);

;(function(a){a.fn.fitVids=function(b){var c={customSelector:null};if(!document.getElementById("fit-vids-style")){var f=document.createElement("div"),d=document.getElementsByTagName("base")[0]||document.getElementsByTagName("script")[0],e="&shy;<style>.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}</style>";f.className="fit-vids-style";f.id="fit-vids-style";f.style.display="none";f.innerHTML=e;d.parentNode.insertBefore(f,d)}if(b){a.extend(c,b)}return this.each(function(){var g=["iframe[src*='player.vimeo.com']","iframe[src*='youtube.com']","iframe[src*='youtube-nocookie.com']","iframe[src*='kickstarter.com'][src*='video.html']","object","embed"];if(c.customSelector){g.push(c.customSelector)}var h=a(this).find(g.join(","));h=h.not("object object");h.each(function(){var m=a(this);if(this.tagName.toLowerCase()==="embed"&&m.parent("object").length||m.parent(".fluid-width-video-wrapper").length){return}var i=(this.tagName.toLowerCase()==="object"||(m.attr("height")&&!isNaN(parseInt(m.attr("height"),10))))?parseInt(m.attr("height"),10):m.height(),j=!isNaN(parseInt(m.attr("width"),10))?parseInt(m.attr("width"),10):m.width(),k=i/j;if(!m.attr("id")){var l="fitvid"+Math.floor(Math.random()*999999);m.attr("id",l)}m.wrap('<div class="fluid-width-video-wrapper"></div>').parent(".fluid-width-video-wrapper").css("padding-top",(k*100)+"%");m.removeAttr("height").removeAttr("width")})})}})(window.jQuery||window.Zepto);



/*!
 * JavaScript Custom Forms
 *
 * Copyright 2014-2015 PSD2HTML - http://psd2html.com/jcf
 * Released under the MIT license (LICENSE.txt)
 *
 * Version: 1.1.3
 */
;(function(root, factory) {

  'use strict';
  if (typeof define === 'function' && define.amd) {
    define(['jquery'], factory);
  } else if (typeof exports === 'object') {
    module.exports = factory(require('jquery'));
  } else {
    root.jcf = factory(jQuery);
  }
}(this, function($) {

  'use strict';

  // define version
  var version = '1.1.3';

  // private variables
  var customInstances = [];

  // default global options
  var commonOptions = {
    optionsKey: 'jcf',
    dataKey: 'jcf-instance',
    rtlClass: 'jcf-rtl',
    focusClass: 'jcf-focus',
    pressedClass: 'jcf-pressed',
    disabledClass: 'jcf-disabled',
    hiddenClass: 'jcf-hidden',
    resetAppearanceClass: 'jcf-reset-appearance',
    unselectableClass: 'jcf-unselectable'
  };

  // detect device type
  var isTouchDevice = ('ontouchstart' in window) || window.DocumentTouch && document instanceof window.DocumentTouch,
    isWinPhoneDevice = /Windows Phone/.test(navigator.userAgent);
  commonOptions.isMobileDevice = !!(isTouchDevice || isWinPhoneDevice);

  var isIOS = /(iPad|iPhone).*OS ([0-9_]*) .*/.exec(navigator.userAgent);
  if(isIOS) isIOS = parseFloat(isIOS[2].replace(/_/g, '.'));
  commonOptions.ios = isIOS;

  // create global stylesheet if custom forms are used
  var createStyleSheet = function() {
    var styleTag = $('<style>').appendTo('head'),
      styleSheet = styleTag.prop('sheet') || styleTag.prop('styleSheet');

    // crossbrowser style handling
    var addCSSRule = function(selector, rules, index) {
      if (styleSheet.insertRule) {
        styleSheet.insertRule(selector + '{' + rules + '}', index);
      } else {
        styleSheet.addRule(selector, rules, index);
      }
    };

    // add special rules
    addCSSRule('.' + commonOptions.hiddenClass, 'position:absolute !important;left:-9999px !important;height:1px !important;width:1px !important;margin:0 !important;border-width:0 !important;-webkit-appearance:none;-moz-appearance:none;appearance:none');
    addCSSRule('.' + commonOptions.rtlClass + ' .' + commonOptions.hiddenClass, 'right:-9999px !important; left: auto !important');
    addCSSRule('.' + commonOptions.unselectableClass, '-webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; -webkit-tap-highlight-color: rgba(0,0,0,0);');
    addCSSRule('.' + commonOptions.resetAppearanceClass, 'background: none; border: none; -webkit-appearance: none; appearance: none; opacity: 0; filter: alpha(opacity=0);');

    // detect rtl pages
    var html = $('html'), body = $('body');
    if (html.css('direction') === 'rtl' || body.css('direction') === 'rtl') {
      html.addClass(commonOptions.rtlClass);
    }

    // handle form reset event
    html.on('reset', function() {
      setTimeout(function() {
        api.refreshAll();
      }, 0);
    });

    // mark stylesheet as created
    commonOptions.styleSheetCreated = true;
  };

  // simplified pointer events handler
  (function() {
    var pointerEventsSupported = navigator.pointerEnabled || navigator.msPointerEnabled,
      touchEventsSupported = ('ontouchstart' in window) || window.DocumentTouch && document instanceof window.DocumentTouch,
      eventList, eventMap = {}, eventPrefix = 'jcf-';

    // detect events to attach
    if (pointerEventsSupported) {
      eventList = {
        pointerover: navigator.pointerEnabled ? 'pointerover' : 'MSPointerOver',
        pointerdown: navigator.pointerEnabled ? 'pointerdown' : 'MSPointerDown',
        pointermove: navigator.pointerEnabled ? 'pointermove' : 'MSPointerMove',
        pointerup: navigator.pointerEnabled ? 'pointerup' : 'MSPointerUp'
      };
    } else {
      eventList = {
        pointerover: 'mouseover',
        pointerdown: 'mousedown' + (touchEventsSupported ? ' touchstart' : ''),
        pointermove: 'mousemove' + (touchEventsSupported ? ' touchmove' : ''),
        pointerup: 'mouseup' + (touchEventsSupported ? ' touchend' : '')
      };
    }

    // create event map
    $.each(eventList, function(targetEventName, fakeEventList) {
      $.each(fakeEventList.split(' '), function(index, fakeEventName) {
        eventMap[fakeEventName] = targetEventName;
      });
    });

    // jQuery event hooks
    $.each(eventList, function(eventName, eventHandlers) {
      eventHandlers = eventHandlers.split(' ');
      $.event.special[eventPrefix + eventName] = {
        setup: function() {
          var self = this;
          $.each(eventHandlers, function(index, fallbackEvent) {
            if (self.addEventListener) self.addEventListener(fallbackEvent, fixEvent, commonOptions.isMobileDevice ? {passive: false} : false);
            else self['on' + fallbackEvent] = fixEvent;
          });
        },
        teardown: function() {
          var self = this;
          $.each(eventHandlers, function(index, fallbackEvent) {
            if (self.addEventListener) self.removeEventListener(fallbackEvent, fixEvent, commonOptions.isMobileDevice ? {passive: false} : false);
            else self['on' + fallbackEvent] = null;
          });
        }
      };
    });

    // check that mouse event are not simulated by mobile browsers
    var lastTouch = null;
    var mouseEventSimulated = function(e) {
      var dx = Math.abs(e.pageX - lastTouch.x),
        dy = Math.abs(e.pageY - lastTouch.y),
        rangeDistance = 25;

      if (dx <= rangeDistance && dy <= rangeDistance) {
        return true;
      }
    };

    // normalize event
    var fixEvent = function(e) {
      var origEvent = e || window.event,
        touchEventData = null,
        targetEventName = eventMap[origEvent.type];

      e = $.event.fix(origEvent);
      e.type = eventPrefix + targetEventName;

      if (origEvent.pointerType) {
        switch (origEvent.pointerType) {
          case 2: e.pointerType = 'touch'; break;
          case 3: e.pointerType = 'pen'; break;
          case 4: e.pointerType = 'mouse'; break;
          default: e.pointerType = origEvent.pointerType;
        }
      } else {
        e.pointerType = origEvent.type.substr(0, 5); // "mouse" or "touch" word length
      }

      if (!e.pageX && !e.pageY) {
        touchEventData = origEvent.changedTouches ? origEvent.changedTouches[0] : origEvent;
        e.pageX = touchEventData.pageX;
        e.pageY = touchEventData.pageY;
      }

      if (origEvent.type === 'touchend') {
        lastTouch = { x: e.pageX, y: e.pageY };
      }
      if (e.pointerType === 'mouse' && lastTouch && mouseEventSimulated(e)) {
        return;
      } else {
        return ($.event.dispatch || $.event.handle).call(this, e);
      }
    };
  }());

  // custom mousewheel/trackpad handler
  (function() {
    var wheelEvents = ('onwheel' in document || document.documentMode >= 9 ? 'wheel' : 'mousewheel DOMMouseScroll').split(' '),
      shimEventName = 'jcf-mousewheel';

    $.event.special[shimEventName] = {
      setup: function() {
        var self = this;
        $.each(wheelEvents, function(index, fallbackEvent) {
          if (self.addEventListener) self.addEventListener(fallbackEvent, fixEvent, false);
          else self['on' + fallbackEvent] = fixEvent;
        });
      },
      teardown: function() {
        var self = this;
        $.each(wheelEvents, function(index, fallbackEvent) {
          if (self.addEventListener) self.removeEventListener(fallbackEvent, fixEvent, false);
          else self['on' + fallbackEvent] = null;
        });
      }
    };

    var fixEvent = function(e) {
      var origEvent = e || window.event;
      e = $.event.fix(origEvent);
      e.type = shimEventName;

      // old wheel events handler
      if ('detail'      in origEvent) { e.deltaY = -origEvent.detail;      }
      if ('wheelDelta'  in origEvent) { e.deltaY = -origEvent.wheelDelta;  }
      if ('wheelDeltaY' in origEvent) { e.deltaY = -origEvent.wheelDeltaY; }
      if ('wheelDeltaX' in origEvent) { e.deltaX = -origEvent.wheelDeltaX; }

      // modern wheel event handler
      if ('deltaY' in origEvent) {
        e.deltaY = origEvent.deltaY;
      }
      if ('deltaX' in origEvent) {
        e.deltaX = origEvent.deltaX;
      }

      // handle deltaMode for mouse wheel
      e.delta = e.deltaY || e.deltaX;
      if (origEvent.deltaMode === 1) {
        var lineHeight = 16;
        e.delta *= lineHeight;
        e.deltaY *= lineHeight;
        e.deltaX *= lineHeight;
      }

      return ($.event.dispatch || $.event.handle).call(this, e);
    };
  }());

  // extra module methods
  var moduleMixin = {
    // provide function for firing native events
    fireNativeEvent: function(elements, eventName) {
      $(elements).each(function() {
        var element = this, eventObject;
        if (element.dispatchEvent) {
          eventObject = document.createEvent('HTMLEvents');
          eventObject.initEvent(eventName, true, true);
          element.dispatchEvent(eventObject);
        } else if (document.createEventObject) {
          eventObject = document.createEventObject();
          eventObject.target = element;
          element.fireEvent('on' + eventName, eventObject);
        }
      });
    },
    // bind event handlers for module instance (functions beggining with "on")
    bindHandlers: function() {
      var self = this;
      $.each(self, function(propName, propValue) {
        if (propName.indexOf('on') === 0 && $.isFunction(propValue)) {
          // dont use $.proxy here because it doesn't create unique handler
          self[propName] = function() {
            return propValue.apply(self, arguments);
          };
        }
      });
    }
  };

  // public API
  var api = {
    version: version,
    modules: {},
    getOptions: function() {
      return $.extend({}, commonOptions);
    },
    setOptions: function(moduleName, moduleOptions) {
      if (arguments.length > 1) {
        // set module options
        if (this.modules[moduleName]) {
          $.extend(this.modules[moduleName].prototype.options, moduleOptions);
        }
      } else {
        // set common options
        $.extend(commonOptions, moduleName);
      }
    },
    addModule: function(proto) {
      // add module to list
      var Module = function(options) {
        // save instance to collection
        if (!options.element.data(commonOptions.dataKey)) {
          options.element.data(commonOptions.dataKey, this);
        }
        customInstances.push(this);

        // save options
        this.options = $.extend({}, commonOptions, this.options, getInlineOptions(options.element), options);

        // bind event handlers to instance
        this.bindHandlers();

        // call constructor
        this.init.apply(this, arguments);
      };

      // parse options from HTML attribute
      var getInlineOptions = function(element) {
        var dataOptions = element.data(commonOptions.optionsKey),
          attrOptions = element.attr(commonOptions.optionsKey);

        if (dataOptions) {
          return dataOptions;
        } else if (attrOptions) {
          try {
            return $.parseJSON(attrOptions);
          } catch (e) {
            // ignore invalid attributes
          }
        }
      };

      // set proto as prototype for new module
      Module.prototype = proto;

      // add mixin methods to module proto
      $.extend(proto, moduleMixin);
      if (proto.plugins) {
        $.each(proto.plugins, function(pluginName, plugin) {
          $.extend(plugin.prototype, moduleMixin);
        });
      }

      // override destroy method
      var originalDestroy = Module.prototype.destroy;
      Module.prototype.destroy = function() {
        this.options.element.removeData(this.options.dataKey);

        for (var i = customInstances.length - 1; i >= 0; i--) {
          if (customInstances[i] === this) {
            customInstances.splice(i, 1);
            break;
          }
        }

        if (originalDestroy) {
          originalDestroy.apply(this, arguments);
        }
      };

      // save module to list
      this.modules[proto.name] = Module;
    },
    getInstance: function(element) {
      return $(element).data(commonOptions.dataKey);
    },
    replace: function(elements, moduleName, customOptions) {
      var self = this,
        instance;

      if (!commonOptions.styleSheetCreated) {
        createStyleSheet();
      }

      $(elements).each(function() {
        var moduleOptions,
          element = $(this);

        instance = element.data(commonOptions.dataKey);
        if (instance) {
          instance.refresh();
        } else {
          if (!moduleName) {
            $.each(self.modules, function(currentModuleName, module) {
              if (module.prototype.matchElement.call(module.prototype, element)) {
                moduleName = currentModuleName;
                return false;
              }
            });
          }
          if (moduleName) {
            moduleOptions = $.extend({ element: element }, customOptions);
            instance = new self.modules[moduleName](moduleOptions);
          }
        }
      });
      return instance;
    },
    refresh: function(elements) {
      $(elements).each(function() {
        var instance = $(this).data(commonOptions.dataKey);
        if (instance) {
          instance.refresh();
        }
      });
    },
    destroy: function(elements) {
      $(elements).each(function() {
        var instance = $(this).data(commonOptions.dataKey);
        if (instance) {
          instance.destroy();
        }
      });
    },
    replaceAll: function(context) {
      var self = this;
      $.each(this.modules, function(moduleName, module) {
        $(module.prototype.selector, context).each(function() {
          if (this.className.indexOf('jcf-ignore') < 0) {
            self.replace(this, moduleName);
          }
        });
      });
    },
    refreshAll: function(context) {
      if (context) {
        $.each(this.modules, function(moduleName, module) {
          $(module.prototype.selector, context).each(function() {
            var instance = $(this).data(commonOptions.dataKey);
            if (instance) {
              instance.refresh();
            }
          });
        });
      } else {
        for (var i = customInstances.length - 1; i >= 0; i--) {
          customInstances[i].refresh();
        }
      }
    },
    destroyAll: function(context) {
      if (context) {
        $.each(this.modules, function(moduleName, module) {
          $(module.prototype.selector, context).each(function(index, element) {
            var instance = $(element).data(commonOptions.dataKey);
            if (instance) {
              instance.destroy();
            }
          });
        });
      } else {
        while (customInstances.length) {
          customInstances[0].destroy();
        }
      }
    }
  };

  // always export API to the global window object
  window.jcf = api;

  return api;
}));

 /*!
 * JavaScript Custom Forms : Scrollbar Module
 *
 * Copyright 2014-2015 PSD2HTML - http://psd2html.com/jcf
 * Released under the MIT license (LICENSE.txt)
 *
 * Version: 1.1.3
 */
;(function($, window) {

  'use strict';

  jcf.addModule({
    name: 'Scrollable',
    selector: '.jcf-scrollable',
    plugins: {
      ScrollBar: ScrollBar
    },
    options: {
      mouseWheelStep: 150,
      handleResize: true,
      alwaysShowScrollbars: false,
      alwaysPreventMouseWheel: false,
      scrollAreaStructure: '<div class="jcf-scrollable-wrapper"></div>'
    },
    matchElement: function(element) {
      return element.is('.jcf-scrollable');
    },
    init: function() {
      this.initStructure();
      this.attachEvents();
      this.rebuildScrollbars();
    },
    initStructure: function() {
      // prepare structure
      this.doc = $(document);
      this.win = $(window);
      this.realElement = $(this.options.element);
      this.scrollWrapper = $(this.options.scrollAreaStructure).insertAfter(this.realElement);

      // set initial styles
      this.scrollWrapper.css('position', 'relative');
      this.realElement.css('overflow', 'hidden');
      this.vBarEdge = 0;
    },
    attachEvents: function() {
      // create scrollbars
      var self = this;
      this.vBar = new ScrollBar({
        holder: this.scrollWrapper,
        vertical: true,
        onScroll: function(scrollTop) {
          self.realElement.scrollTop(scrollTop);
        }
      });
      this.hBar = new ScrollBar({
        holder: this.scrollWrapper,
        vertical: false,
        onScroll: function(scrollLeft) {
          self.realElement.scrollLeft(scrollLeft);
        }
      });

      // add event handlers
      this.realElement.on('scroll', this.onScroll);
      if (this.options.handleResize) {
        this.win.on('resize orientationchange load', this.onResize);
      }

      // add pointer/wheel event handlers
      this.realElement.on('jcf-mousewheel', this.onMouseWheel);
      this.realElement.on('jcf-pointerdown', this.onTouchBody);
    },
    onScroll: function() {
      this.redrawScrollbars();
    },
    onResize: function() {
      // do not rebuild scrollbars if form field is in focus
      if (!$(document.activeElement).is(':input')) {
        this.rebuildScrollbars();
      }
    },
    onTouchBody: function(e) {
      if (e.pointerType === 'touch') {
        this.touchData = {
          scrollTop: this.realElement.scrollTop(),
          scrollLeft: this.realElement.scrollLeft(),
          left: e.pageX,
          top: e.pageY
        };
        this.doc.on({
          'jcf-pointermove': this.onMoveBody,
          'jcf-pointerup': this.onReleaseBody
        });
      }
    },
    onMoveBody: function(e) {
      var targetScrollTop,
        targetScrollLeft,
        verticalScrollAllowed = this.verticalScrollActive,
        horizontalScrollAllowed = this.horizontalScrollActive;

      if (e.pointerType === 'touch') {
        targetScrollTop = this.touchData.scrollTop - e.pageY + this.touchData.top;
        targetScrollLeft = this.touchData.scrollLeft - e.pageX + this.touchData.left;

        // check that scrolling is ended and release outer scrolling
        if (this.verticalScrollActive && (targetScrollTop < 0 || targetScrollTop > this.vBar.maxValue)) {
          verticalScrollAllowed = false;
        }
        if (this.horizontalScrollActive && (targetScrollLeft < 0 || targetScrollLeft > this.hBar.maxValue)) {
          horizontalScrollAllowed = false;
        }

        this.realElement.scrollTop(targetScrollTop);
        this.realElement.scrollLeft(targetScrollLeft);

        if (verticalScrollAllowed || horizontalScrollAllowed) {
          e.preventDefault();
        } else {
          this.onReleaseBody(e);
        }
      }
    },
    onReleaseBody: function(e) {
      if (e.pointerType === 'touch') {
        delete this.touchData;
        this.doc.off({
          'jcf-pointermove': this.onMoveBody,
          'jcf-pointerup': this.onReleaseBody
        });
      }
    },
    onMouseWheel: function(e) {
      var currentScrollTop = this.realElement.scrollTop(),
        currentScrollLeft = this.realElement.scrollLeft(),
        maxScrollTop = this.realElement.prop('scrollHeight') - this.embeddedDimensions.innerHeight,
        maxScrollLeft = this.realElement.prop('scrollWidth') - this.embeddedDimensions.innerWidth,
        extraLeft, extraTop, preventFlag;

      // check edge cases
      if (!this.options.alwaysPreventMouseWheel) {
        if (this.verticalScrollActive && e.deltaY) {
          if (!(currentScrollTop <= 0 && e.deltaY < 0) && !(currentScrollTop >= maxScrollTop && e.deltaY > 0)) {
            preventFlag = true;
          }
        }
        if (this.horizontalScrollActive && e.deltaX) {
          if (!(currentScrollLeft <= 0 && e.deltaX < 0) && !(currentScrollLeft >= maxScrollLeft && e.deltaX > 0)) {
            preventFlag = true;
          }
        }
        if (!this.verticalScrollActive && !this.horizontalScrollActive) {
          return;
        }
      }

      // prevent default action and scroll item
      if (preventFlag || this.options.alwaysPreventMouseWheel) {
        e.preventDefault();
      } else {
        return;
      }

      extraLeft = e.deltaX / 100 * this.options.mouseWheelStep;
      extraTop = e.deltaY / 100 * this.options.mouseWheelStep;

      this.realElement.scrollTop(currentScrollTop + extraTop);
      this.realElement.scrollLeft(currentScrollLeft + extraLeft);
    },
    setScrollBarEdge: function(edgeSize) {
      this.vBarEdge = edgeSize || 0;
      this.redrawScrollbars();
    },
    saveElementDimensions: function() {
      this.savedDimensions = {
        top: this.realElement.width(),
        left: this.realElement.height()
      };
      return this;
    },
    restoreElementDimensions: function() {
      if (this.savedDimensions) {
        this.realElement.css({
          width: this.savedDimensions.width,
          height: this.savedDimensions.height
        });
      }
      return this;
    },
    saveScrollOffsets: function() {
      this.savedOffsets = {
        top: this.realElement.scrollTop(),
        left: this.realElement.scrollLeft()
      };
      return this;
    },
    restoreScrollOffsets: function() {
      if (this.savedOffsets) {
        this.realElement.scrollTop(this.savedOffsets.top);
        this.realElement.scrollLeft(this.savedOffsets.left);
      }
      return this;
    },
    getContainerDimensions: function() {
      // save current styles
      var desiredDimensions,
        currentStyles,
        currentHeight,
        currentWidth;

      if (this.isModifiedStyles) {
        desiredDimensions = {
          width: this.realElement.innerWidth() + this.vBar.getThickness(),
          height: this.realElement.innerHeight() + this.hBar.getThickness()
        };
      } else {
        // unwrap real element and measure it according to CSS
        this.saveElementDimensions().saveScrollOffsets();
        this.realElement.insertAfter(this.scrollWrapper);
        this.scrollWrapper.detach();

        // measure element
        currentStyles = this.realElement.prop('style');
        currentWidth = parseFloat(currentStyles.width);
        currentHeight = parseFloat(currentStyles.height);

        // reset styles if needed
        if (this.embeddedDimensions && currentWidth && currentHeight) {
          this.isModifiedStyles |= (currentWidth !== this.embeddedDimensions.width || currentHeight !== this.embeddedDimensions.height);
          this.realElement.css({
            overflow: '',
            width: '',
            height: ''
          });
        }

        // calculate desired dimensions for real element
        desiredDimensions = {
          width: this.realElement.outerWidth(),
          height: this.realElement.outerHeight()
        };

        // restore structure and original scroll offsets
        this.scrollWrapper.insertAfter(this.realElement);
        this.realElement.css('overflow', 'hidden').prependTo(this.scrollWrapper);
        this.restoreElementDimensions().restoreScrollOffsets();
      }

      return desiredDimensions;
    },
    getEmbeddedDimensions: function(dimensions) {
      // handle scrollbars cropping
      var fakeBarWidth = this.vBar.getThickness(),
        fakeBarHeight = this.hBar.getThickness(),
        paddingWidth = this.realElement.outerWidth() - this.realElement.width(),
        paddingHeight = this.realElement.outerHeight() - this.realElement.height(),
        resultDimensions;

      if (this.options.alwaysShowScrollbars) {
        // simply return dimensions without custom scrollbars
        this.verticalScrollActive = true;
        this.horizontalScrollActive = true;
        resultDimensions = {
          innerWidth: dimensions.width - fakeBarWidth,
          innerHeight: dimensions.height - fakeBarHeight
        };
      } else {
        // detect when to display each scrollbar
        this.saveElementDimensions();
        this.verticalScrollActive = false;
        this.horizontalScrollActive = false;

        // fill container with full size
        this.realElement.css({
          width: dimensions.width - paddingWidth,
          height: dimensions.height - paddingHeight
        });

        this.horizontalScrollActive = this.realElement.prop('scrollWidth') > this.containerDimensions.width;
        this.verticalScrollActive = this.realElement.prop('scrollHeight') > this.containerDimensions.height;

        this.restoreElementDimensions();
        resultDimensions = {
          innerWidth: dimensions.width - (this.verticalScrollActive ? fakeBarWidth : 0),
          innerHeight: dimensions.height - (this.horizontalScrollActive ? fakeBarHeight : 0)
        };
      }
      $.extend(resultDimensions, {
        width: resultDimensions.innerWidth - paddingWidth,
        height: resultDimensions.innerHeight - paddingHeight
      });
      return resultDimensions;
    },
    rebuildScrollbars: function() {
      // resize wrapper according to real element styles
      this.containerDimensions = this.getContainerDimensions();
      this.embeddedDimensions = this.getEmbeddedDimensions(this.containerDimensions);

      // resize wrapper to desired dimensions
      this.scrollWrapper.css({
        width: this.containerDimensions.width,
        height: this.containerDimensions.height
      });

      // resize element inside wrapper excluding scrollbar size
      this.realElement.css({
        overflow: 'hidden',
        width: this.embeddedDimensions.width,
        height: this.embeddedDimensions.height
      });

      // redraw scrollbar offset
      this.redrawScrollbars();
    },
    redrawScrollbars: function() {
      var viewSize, maxScrollValue;

      // redraw vertical scrollbar
      if (this.verticalScrollActive) {
        viewSize = this.vBarEdge ? this.containerDimensions.height - this.vBarEdge : this.embeddedDimensions.innerHeight;
        maxScrollValue = Math.max(this.realElement.prop('offsetHeight'), this.realElement.prop('scrollHeight')) - this.vBarEdge;

        this.vBar.show().setMaxValue(maxScrollValue - viewSize).setRatio(viewSize / maxScrollValue).setSize(viewSize);
        this.vBar.setValue(this.realElement.scrollTop());
      } else {
        this.vBar.hide();
      }

      // redraw horizontal scrollbar
      if (this.horizontalScrollActive) {
        viewSize = this.embeddedDimensions.innerWidth;
        maxScrollValue = this.realElement.prop('scrollWidth');

        if (maxScrollValue === viewSize) {
          this.horizontalScrollActive = false;
        }
        this.hBar.show().setMaxValue(maxScrollValue - viewSize).setRatio(viewSize / maxScrollValue).setSize(viewSize);
        this.hBar.setValue(this.realElement.scrollLeft());
      } else {
        this.hBar.hide();
      }

      // set "touch-action" style rule
      var touchAction = '';
      if (this.verticalScrollActive && this.horizontalScrollActive) {
        touchAction = 'none';
      } else if (this.verticalScrollActive) {
        touchAction = 'pan-x';
      } else if (this.horizontalScrollActive) {
        touchAction = 'pan-y';
      }
      // this.realElement.css('touchAction', touchAction);
    },
    refresh: function() {
      this.rebuildScrollbars();
    },
    destroy: function() {
      // remove event listeners
      this.win.off('resize orientationchange load', this.onResize);
      this.realElement.off({
        'jcf-mousewheel': this.onMouseWheel,
        'jcf-pointerdown': this.onTouchBody
      });
      this.doc.off({
        'jcf-pointermove': this.onMoveBody,
        'jcf-pointerup': this.onReleaseBody
      });

      // restore structure
      this.saveScrollOffsets();
      this.vBar.destroy();
      this.hBar.destroy();
      this.realElement.insertAfter(this.scrollWrapper).css({
        touchAction: '',
        overflow: '',
        width: '',
        height: ''
      });
      this.scrollWrapper.remove();
      this.restoreScrollOffsets();
    }
  });

  // custom scrollbar
  function ScrollBar(options) {
    this.options = $.extend({
      holder: null,
      vertical: true,
      inactiveClass: 'jcf-inactive',
      verticalClass: 'jcf-scrollbar-vertical',
      horizontalClass: 'jcf-scrollbar-horizontal',
      scrollbarStructure: '<div class="jcf-scrollbar"><div class="jcf-scrollbar-dec"><i class="icon-shevron-left"></i></div><div class="jcf-scrollbar-slider"><div class="jcf-scrollbar-handle"></div></div><div class="jcf-scrollbar-inc"><i class="icon-shevron-right"></i></div></div>',
      btnDecSelector: '.jcf-scrollbar-dec',
      btnIncSelector: '.jcf-scrollbar-inc',
      sliderSelector: '.jcf-scrollbar-slider',
      handleSelector: '.jcf-scrollbar-handle',
      scrollInterval: 300,
      scrollStep: 400 // px/sec
    }, options);
    this.init();
  }
  $.extend(ScrollBar.prototype, {
    init: function() {
      this.initStructure();
      this.attachEvents();
    },
    initStructure: function() {
      // define proporties
      this.doc = $(document);
      this.isVertical = !!this.options.vertical;
      this.sizeProperty = this.isVertical ? 'height' : 'width';
      this.fullSizeProperty = this.isVertical ? 'outerHeight' : 'outerWidth';
      this.invertedSizeProperty = this.isVertical ? 'width' : 'height';
      this.thicknessMeasureMethod = 'outer' + this.invertedSizeProperty.charAt(0).toUpperCase() + this.invertedSizeProperty.substr(1);
      this.offsetProperty = this.isVertical ? 'top' : 'left';
      this.offsetEventProperty = this.isVertical ? 'pageY' : 'pageX';

      // initialize variables
      this.value = this.options.value || 0;
      this.maxValue = this.options.maxValue || 0;
      this.currentSliderSize = 0;
      this.handleSize = 0;

      // find elements
      this.holder = $(this.options.holder);
      this.scrollbar = $(this.options.scrollbarStructure).appendTo(this.holder);
      this.btnDec = this.scrollbar.find(this.options.btnDecSelector);
      this.btnInc = this.scrollbar.find(this.options.btnIncSelector);
      this.slider = this.scrollbar.find(this.options.sliderSelector);
      this.handle = this.slider.find(this.options.handleSelector);

      // set initial styles
      this.scrollbar.addClass(this.isVertical ? this.options.verticalClass : this.options.horizontalClass).css({
        touchAction: this.isVertical ? 'pan-x' : 'pan-y',
        position: 'absolute'
      });
      this.slider.css({
        position: 'relative'
      });
      this.handle.css({
        touchAction: 'none',
        position: 'absolute'
      });
    },
    attachEvents: function() {
      this.bindHandlers();
      this.handle.on('jcf-pointerdown', this.onHandlePress);
      this.slider.add(this.btnDec).add(this.btnInc).on('jcf-pointerdown', this.onButtonPress);
    },
    onHandlePress: function(e) {
      if (e.pointerType === 'mouse' && e.button > 1) {
        return;
      } else {
        e.preventDefault();
        this.handleDragActive = true;
        this.sliderOffset = this.slider.offset()[this.offsetProperty];
        this.innerHandleOffset = e[this.offsetEventProperty] - this.handle.offset()[this.offsetProperty];

        this.doc.on('jcf-pointermove', this.onHandleDrag);
        this.doc.on('jcf-pointerup', this.onHandleRelease);
      }
    },
    onHandleDrag: function(e) {
      e.preventDefault();
      this.calcOffset = e[this.offsetEventProperty] - this.sliderOffset - this.innerHandleOffset;
      this.setValue(this.calcOffset / (this.currentSliderSize - this.handleSize) * this.maxValue);
      this.triggerScrollEvent(this.value);
    },
    onHandleRelease: function() {
      this.handleDragActive = false;
      this.doc.off('jcf-pointermove', this.onHandleDrag);
      this.doc.off('jcf-pointerup', this.onHandleRelease);
    },
    onButtonPress: function(e) {
      var direction, clickOffset;
      if (e.pointerType === 'mouse' && e.button > 1) {
        return;
      } else {
        e.preventDefault();
        if (!this.handleDragActive) {
          if (this.slider.is(e.currentTarget)) {
            // slider pressed
            direction = this.handle.offset()[this.offsetProperty] > e[this.offsetEventProperty] ? -1 : 1;
            clickOffset = e[this.offsetEventProperty] - this.slider.offset()[this.offsetProperty];
            this.startPageScrolling(direction, clickOffset);
          } else {
            // scrollbar buttons pressed
            direction = this.btnDec.is(e.currentTarget) ? -1 : 1;
            this.startSmoothScrolling(direction);
          }
          this.doc.on('jcf-pointerup', this.onButtonRelease);
        }
      }
    },
    onButtonRelease: function() {
      this.stopPageScrolling();
      this.stopSmoothScrolling();
      this.doc.off('jcf-pointerup', this.onButtonRelease);
    },
    startPageScrolling: function(direction, clickOffset) {
      var self = this,
        stepValue = direction * self.currentSize;

      // limit checker
      var isFinishedScrolling = function() {
        var handleTop = (self.value / self.maxValue) * (self.currentSliderSize - self.handleSize);

        if (direction > 0) {
          return handleTop + self.handleSize >= clickOffset;
        } else {
          return handleTop <= clickOffset;
        }
      };

      // scroll by page when track is pressed
      var doPageScroll = function() {
        self.value += stepValue;
        self.setValue(self.value);
        self.triggerScrollEvent(self.value);

        if (isFinishedScrolling()) {
          clearInterval(self.pageScrollTimer);
        }
      };

      // start scrolling
      this.pageScrollTimer = setInterval(doPageScroll, this.options.scrollInterval);
      doPageScroll();
    },
    stopPageScrolling: function() {
      clearInterval(this.pageScrollTimer);
    },
    startSmoothScrolling: function(direction) {
      var self = this, dt;
      this.stopSmoothScrolling();

      // simple animation functions
      var raf = window.requestAnimationFrame || function(func) {
        setTimeout(func, 16);
      };
      var getTimestamp = function() {
        return Date.now ? Date.now() : new Date().getTime();
      };

      // set animation limit
      var isFinishedScrolling = function() {
        if (direction > 0) {
          return self.value >= self.maxValue;
        } else {
          return self.value <= 0;
        }
      };

      // animation step
      var doScrollAnimation = function() {
        var stepValue = (getTimestamp() - dt) / 1000 * self.options.scrollStep;

        if (self.smoothScrollActive) {
          self.value += stepValue * direction;
          self.setValue(self.value);
          self.triggerScrollEvent(self.value);

          if (!isFinishedScrolling()) {
            dt = getTimestamp();
            raf(doScrollAnimation);
          }
        }
      };

      // start animation
      self.smoothScrollActive = true;
      dt = getTimestamp();
      raf(doScrollAnimation);
    },
    stopSmoothScrolling: function() {
      this.smoothScrollActive = false;
    },
    triggerScrollEvent: function(scrollValue) {
      if (this.options.onScroll) {
        this.options.onScroll(scrollValue);
      }
    },
    getThickness: function() {
      return this.scrollbar[this.thicknessMeasureMethod]();
    },
    setSize: function(size) {
      // resize scrollbar
      var btnDecSize = this.btnDec[this.fullSizeProperty](),
        btnIncSize = this.btnInc[this.fullSizeProperty]();

      // resize slider
      this.currentSize = size;
      this.currentSliderSize = size - btnDecSize - btnIncSize;
      this.scrollbar.css(this.sizeProperty, size);
      this.slider.css(this.sizeProperty, this.currentSliderSize);
      this.currentSliderSize = this.slider[this.sizeProperty]();

      // resize handle
      this.handleSize = Math.round(this.currentSliderSize * this.ratio);
      this.handle.css(this.sizeProperty, this.handleSize);
      this.handleSize = this.handle[this.fullSizeProperty]();

      return this;
    },
    setRatio: function(ratio) {
      this.ratio = ratio;
      return this;
    },
    setMaxValue: function(maxValue) {
      this.maxValue = maxValue;
      this.setValue(Math.min(this.value, this.maxValue));
      return this;
    },
    setValue: function(value) {
      this.value = value;
      if (this.value < 0) {
        this.value = 0;
      } else if (this.value > this.maxValue) {
        this.value = this.maxValue;
      }
      this.refresh();
    },
    setPosition: function(styles) {
      this.scrollbar.css(styles);
      return this;
    },
    hide: function() {
      this.scrollbar.detach();
      return this;
    },
    show: function() {
      this.scrollbar.appendTo(this.holder);
      return this;
    },
    refresh: function() {
      // recalculate handle position
      if (this.value === 0 || this.maxValue === 0) {
        this.calcOffset = 0;
      } else {
        this.calcOffset = (this.value / this.maxValue) * (this.currentSliderSize - this.handleSize);
      }
      this.handle.css(this.offsetProperty, this.calcOffset);

      // toggle inactive classes
      this.btnDec.toggleClass(this.options.inactiveClass, this.value === 0);
      this.btnInc.toggleClass(this.options.inactiveClass, this.value === this.maxValue);
      this.scrollbar.toggleClass(this.options.inactiveClass, this.maxValue === 0);
    },
    destroy: function() {
      // remove event handlers and scrollbar block itself
      this.btnDec.add(this.btnInc).off('jcf-pointerdown', this.onButtonPress);
      this.handle.off('jcf-pointerdown', this.onHandlePress);
      this.doc.off('jcf-pointermove', this.onHandleDrag);
      this.doc.off('jcf-pointerup', this.onHandleRelease);
      this.doc.off('jcf-pointerup', this.onButtonRelease);
      this.stopSmoothScrolling();
      this.stopPageScrolling();
      this.scrollbar.remove();
    }
  });

}(jQuery, this));


/*
 * Responsive Layout helper
 */
ResponsiveHelper = (function($){
  // init variables
  var handlers = [],
    prevWinWidth,
    win = $(window),
    nativeMatchMedia = false;

  // detect match media support
  if(window.matchMedia) {
    if(window.Window && window.matchMedia === Window.prototype.matchMedia) {
      nativeMatchMedia = true;
    } else if(window.matchMedia.toString().indexOf('native') > -1) {
      nativeMatchMedia = true;
    }
  }

  // prepare resize handler
  function resizeHandler() {
    var winWidth = win.width();
    if(winWidth !== prevWinWidth) {
      prevWinWidth = winWidth;

      // loop through range groups
      $.each(handlers, function(index, rangeObject){
        // disable current active area if needed
        $.each(rangeObject.data, function(property, item) {
          if(item.currentActive && !matchRange(item.range[0], item.range[1])) {
            item.currentActive = false;
            if(typeof item.disableCallback === 'function') {
              item.disableCallback();
            }
          }
        });

        // enable areas that match current width
        $.each(rangeObject.data, function(property, item) {
          if(!item.currentActive && matchRange(item.range[0], item.range[1])) {
            // make callback
            item.currentActive = true;
            if(typeof item.enableCallback === 'function') {
              item.enableCallback();
            }
          }
        });
      });
    }
  }
  win.bind('load resize orientationchange', resizeHandler);

  // test range
  function matchRange(r1, r2) {
    var mediaQueryString = '';
    if(r1 > 0) {
      mediaQueryString += '(min-width: ' + r1 + 'px)';
    }
    if(r2 < Infinity) {
      mediaQueryString += (mediaQueryString ? ' and ' : '') + '(max-width: ' + r2 + 'px)';
    }
    return matchQuery(mediaQueryString, r1, r2);
  }

  // media query function
  function matchQuery(query, r1, r2) {
    if(window.matchMedia && nativeMatchMedia) {
      return matchMedia(query).matches;
    } else if(window.styleMedia) {
      return styleMedia.matchMedium(query);
    } else if(window.media) {
      return media.matchMedium(query);
    } else {
      return prevWinWidth >= r1 && prevWinWidth <= r2;
    }
  }

  // range parser
  function parseRange(rangeStr) {
    var rangeData = rangeStr.split('..');
    var x1 = parseInt(rangeData[0], 10) || -Infinity;
    var x2 = parseInt(rangeData[1], 10) || Infinity;
    return [x1, x2].sort(function(a, b){
      return a - b;
    });
  }

  // export public functions
  return {
    addRange: function(ranges) {
      // parse data and add items to collection
      var result = {data:{}};
      $.each(ranges, function(property, data){
        result.data[property] = {
          range: parseRange(property),
          enableCallback: data.on,
          disableCallback: data.off
        };
      });
      handlers.push(result);

      // call resizeHandler to recalculate all events
      prevWinWidth = null;
      resizeHandler();
    }
  };
}(jQuery));

/*! jQuery UI - v1.12.1 - 2017-05-01
* http://jqueryui.com
* Includes: widget.js, position.js, keycode.js, unique-id.js, widgets/autocomplete.js, widgets/menu.js
* Copyright jQuery Foundation and other contributors; Licensed MIT */

(function(t){"function"==typeof define&&define.amd?define(["jquery"],t):t(jQuery)})(function(t){t.ui=t.ui||{},t.ui.version="1.12.1";var e=0,i=Array.prototype.slice;t.cleanData=function(e){return function(i){var s,n,o;for(o=0;null!=(n=i[o]);o++)try{s=t._data(n,"events"),s&&s.remove&&t(n).triggerHandler("remove")}catch(a){}e(i)}}(t.cleanData),t.widget=function(e,i,s){var n,o,a,r={},h=e.split(".")[0];e=e.split(".")[1];var l=h+"-"+e;return s||(s=i,i=t.Widget),t.isArray(s)&&(s=t.extend.apply(null,[{}].concat(s))),t.expr[":"][l.toLowerCase()]=function(e){return!!t.data(e,l)},t[h]=t[h]||{},n=t[h][e],o=t[h][e]=function(t,e){return this._createWidget?(arguments.length&&this._createWidget(t,e),void 0):new o(t,e)},t.extend(o,n,{version:s.version,_proto:t.extend({},s),_childConstructors:[]}),a=new i,a.options=t.widget.extend({},a.options),t.each(s,function(e,s){return t.isFunction(s)?(r[e]=function(){function t(){return i.prototype[e].apply(this,arguments)}function n(t){return i.prototype[e].apply(this,t)}return function(){var e,i=this._super,o=this._superApply;return this._super=t,this._superApply=n,e=s.apply(this,arguments),this._super=i,this._superApply=o,e}}(),void 0):(r[e]=s,void 0)}),o.prototype=t.widget.extend(a,{widgetEventPrefix:n?a.widgetEventPrefix||e:e},r,{constructor:o,namespace:h,widgetName:e,widgetFullName:l}),n?(t.each(n._childConstructors,function(e,i){var s=i.prototype;t.widget(s.namespace+"."+s.widgetName,o,i._proto)}),delete n._childConstructors):i._childConstructors.push(o),t.widget.bridge(e,o),o},t.widget.extend=function(e){for(var s,n,o=i.call(arguments,1),a=0,r=o.length;r>a;a++)for(s in o[a])n=o[a][s],o[a].hasOwnProperty(s)&&void 0!==n&&(e[s]=t.isPlainObject(n)?t.isPlainObject(e[s])?t.widget.extend({},e[s],n):t.widget.extend({},n):n);return e},t.widget.bridge=function(e,s){var n=s.prototype.widgetFullName||e;t.fn[e]=function(o){var a="string"==typeof o,r=i.call(arguments,1),h=this;return a?this.length||"instance"!==o?this.each(function(){var i,s=t.data(this,n);return"instance"===o?(h=s,!1):s?t.isFunction(s[o])&&"_"!==o.charAt(0)?(i=s[o].apply(s,r),i!==s&&void 0!==i?(h=i&&i.jquery?h.pushStack(i.get()):i,!1):void 0):t.error("no such method '"+o+"' for "+e+" widget instance"):t.error("cannot call methods on "+e+" prior to initialization; "+"attempted to call method '"+o+"'")}):h=void 0:(r.length&&(o=t.widget.extend.apply(null,[o].concat(r))),this.each(function(){var e=t.data(this,n);e?(e.option(o||{}),e._init&&e._init()):t.data(this,n,new s(o,this))})),h}},t.Widget=function(){},t.Widget._childConstructors=[],t.Widget.prototype={widgetName:"widget",widgetEventPrefix:"",defaultElement:"<div>",options:{classes:{},disabled:!1,create:null},_createWidget:function(i,s){s=t(s||this.defaultElement||this)[0],this.element=t(s),this.uuid=e++,this.eventNamespace="."+this.widgetName+this.uuid,this.bindings=t(),this.hoverable=t(),this.focusable=t(),this.classesElementLookup={},s!==this&&(t.data(s,this.widgetFullName,this),this._on(!0,this.element,{remove:function(t){t.target===s&&this.destroy()}}),this.document=t(s.style?s.ownerDocument:s.document||s),this.window=t(this.document[0].defaultView||this.document[0].parentWindow)),this.options=t.widget.extend({},this.options,this._getCreateOptions(),i),this._create(),this.options.disabled&&this._setOptionDisabled(this.options.disabled),this._trigger("create",null,this._getCreateEventData()),this._init()},_getCreateOptions:function(){return{}},_getCreateEventData:t.noop,_create:t.noop,_init:t.noop,destroy:function(){var e=this;this._destroy(),t.each(this.classesElementLookup,function(t,i){e._removeClass(i,t)}),this.element.off(this.eventNamespace).removeData(this.widgetFullName),this.widget().off(this.eventNamespace).removeAttr("aria-disabled"),this.bindings.off(this.eventNamespace)},_destroy:t.noop,widget:function(){return this.element},option:function(e,i){var s,n,o,a=e;if(0===arguments.length)return t.widget.extend({},this.options);if("string"==typeof e)if(a={},s=e.split("."),e=s.shift(),s.length){for(n=a[e]=t.widget.extend({},this.options[e]),o=0;s.length-1>o;o++)n[s[o]]=n[s[o]]||{},n=n[s[o]];if(e=s.pop(),1===arguments.length)return void 0===n[e]?null:n[e];n[e]=i}else{if(1===arguments.length)return void 0===this.options[e]?null:this.options[e];a[e]=i}return this._setOptions(a),this},_setOptions:function(t){var e;for(e in t)this._setOption(e,t[e]);return this},_setOption:function(t,e){return"classes"===t&&this._setOptionClasses(e),this.options[t]=e,"disabled"===t&&this._setOptionDisabled(e),this},_setOptionClasses:function(e){var i,s,n;for(i in e)n=this.classesElementLookup[i],e[i]!==this.options.classes[i]&&n&&n.length&&(s=t(n.get()),this._removeClass(n,i),s.addClass(this._classes({element:s,keys:i,classes:e,add:!0})))},_setOptionDisabled:function(t){this._toggleClass(this.widget(),this.widgetFullName+"-disabled",null,!!t),t&&(this._removeClass(this.hoverable,null,"ui-state-hover"),this._removeClass(this.focusable,null,"ui-state-focus"))},enable:function(){return this._setOptions({disabled:!1})},disable:function(){return this._setOptions({disabled:!0})},_classes:function(e){function i(i,o){var a,r;for(r=0;i.length>r;r++)a=n.classesElementLookup[i[r]]||t(),a=e.add?t(t.unique(a.get().concat(e.element.get()))):t(a.not(e.element).get()),n.classesElementLookup[i[r]]=a,s.push(i[r]),o&&e.classes[i[r]]&&s.push(e.classes[i[r]])}var s=[],n=this;return e=t.extend({element:this.element,classes:this.options.classes||{}},e),this._on(e.element,{remove:"_untrackClassesElement"}),e.keys&&i(e.keys.match(/\S+/g)||[],!0),e.extra&&i(e.extra.match(/\S+/g)||[]),s.join(" ")},_untrackClassesElement:function(e){var i=this;t.each(i.classesElementLookup,function(s,n){-1!==t.inArray(e.target,n)&&(i.classesElementLookup[s]=t(n.not(e.target).get()))})},_removeClass:function(t,e,i){return this._toggleClass(t,e,i,!1)},_addClass:function(t,e,i){return this._toggleClass(t,e,i,!0)},_toggleClass:function(t,e,i,s){s="boolean"==typeof s?s:i;var n="string"==typeof t||null===t,o={extra:n?e:i,keys:n?t:e,element:n?this.element:t,add:s};return o.element.toggleClass(this._classes(o),s),this},_on:function(e,i,s){var n,o=this;"boolean"!=typeof e&&(s=i,i=e,e=!1),s?(i=n=t(i),this.bindings=this.bindings.add(i)):(s=i,i=this.element,n=this.widget()),t.each(s,function(s,a){function r(){return e||o.options.disabled!==!0&&!t(this).hasClass("ui-state-disabled")?("string"==typeof a?o[a]:a).apply(o,arguments):void 0}"string"!=typeof a&&(r.guid=a.guid=a.guid||r.guid||t.guid++);var h=s.match(/^([\w:-]*)\s*(.*)$/),l=h[1]+o.eventNamespace,c=h[2];c?n.on(l,c,r):i.on(l,r)})},_off:function(e,i){i=(i||"").split(" ").join(this.eventNamespace+" ")+this.eventNamespace,e.off(i).off(i),this.bindings=t(this.bindings.not(e).get()),this.focusable=t(this.focusable.not(e).get()),this.hoverable=t(this.hoverable.not(e).get())},_delay:function(t,e){function i(){return("string"==typeof t?s[t]:t).apply(s,arguments)}var s=this;return setTimeout(i,e||0)},_hoverable:function(e){this.hoverable=this.hoverable.add(e),this._on(e,{mouseenter:function(e){this._addClass(t(e.currentTarget),null,"ui-state-hover")},mouseleave:function(e){this._removeClass(t(e.currentTarget),null,"ui-state-hover")}})},_focusable:function(e){this.focusable=this.focusable.add(e),this._on(e,{focusin:function(e){this._addClass(t(e.currentTarget),null,"ui-state-focus")},focusout:function(e){this._removeClass(t(e.currentTarget),null,"ui-state-focus")}})},_trigger:function(e,i,s){var n,o,a=this.options[e];if(s=s||{},i=t.Event(i),i.type=(e===this.widgetEventPrefix?e:this.widgetEventPrefix+e).toLowerCase(),i.target=this.element[0],o=i.originalEvent)for(n in o)n in i||(i[n]=o[n]);return this.element.trigger(i,s),!(t.isFunction(a)&&a.apply(this.element[0],[i].concat(s))===!1||i.isDefaultPrevented())}},t.each({show:"fadeIn",hide:"fadeOut"},function(e,i){t.Widget.prototype["_"+e]=function(s,n,o){"string"==typeof n&&(n={effect:n});var a,r=n?n===!0||"number"==typeof n?i:n.effect||i:e;n=n||{},"number"==typeof n&&(n={duration:n}),a=!t.isEmptyObject(n),n.complete=o,n.delay&&s.delay(n.delay),a&&t.effects&&t.effects.effect[r]?s[e](n):r!==e&&s[r]?s[r](n.duration,n.easing,o):s.queue(function(i){t(this)[e](),o&&o.call(s[0]),i()})}}),t.widget,function(){function e(t,e,i){return[parseFloat(t[0])*(u.test(t[0])?e/100:1),parseFloat(t[1])*(u.test(t[1])?i/100:1)]}function i(e,i){return parseInt(t.css(e,i),10)||0}function s(e){var i=e[0];return 9===i.nodeType?{width:e.width(),height:e.height(),offset:{top:0,left:0}}:t.isWindow(i)?{width:e.width(),height:e.height(),offset:{top:e.scrollTop(),left:e.scrollLeft()}}:i.preventDefault?{width:0,height:0,offset:{top:i.pageY,left:i.pageX}}:{width:e.outerWidth(),height:e.outerHeight(),offset:e.offset()}}var n,o=Math.max,a=Math.abs,r=/left|center|right/,h=/top|center|bottom/,l=/[\+\-]\d+(\.[\d]+)?%?/,c=/^\w+/,u=/%$/,d=t.fn.position;t.position={scrollbarWidth:function(){if(void 0!==n)return n;var e,i,s=t("<div style='display:block;position:absolute;width:50px;height:50px;overflow:hidden;'><div style='height:100px;width:auto;'></div></div>"),o=s.children()[0];return t("body").append(s),e=o.offsetWidth,s.css("overflow","scroll"),i=o.offsetWidth,e===i&&(i=s[0].clientWidth),s.remove(),n=e-i},getScrollInfo:function(e){var i=e.isWindow||e.isDocument?"":e.element.css("overflow-x"),s=e.isWindow||e.isDocument?"":e.element.css("overflow-y"),n="scroll"===i||"auto"===i&&e.width<e.element[0].scrollWidth,o="scroll"===s||"auto"===s&&e.height<e.element[0].scrollHeight;return{width:o?t.position.scrollbarWidth():0,height:n?t.position.scrollbarWidth():0}},getWithinInfo:function(e){var i=t(e||window),s=t.isWindow(i[0]),n=!!i[0]&&9===i[0].nodeType,o=!s&&!n;return{element:i,isWindow:s,isDocument:n,offset:o?t(e).offset():{left:0,top:0},scrollLeft:i.scrollLeft(),scrollTop:i.scrollTop(),width:i.outerWidth(),height:i.outerHeight()}}},t.fn.position=function(n){if(!n||!n.of)return d.apply(this,arguments);n=t.extend({},n);var u,p,f,g,m,_,v=t(n.of),b=t.position.getWithinInfo(n.within),y=t.position.getScrollInfo(b),w=(n.collision||"flip").split(" "),k={};return _=s(v),v[0].preventDefault&&(n.at="left top"),p=_.width,f=_.height,g=_.offset,m=t.extend({},g),t.each(["my","at"],function(){var t,e,i=(n[this]||"").split(" ");1===i.length&&(i=r.test(i[0])?i.concat(["center"]):h.test(i[0])?["center"].concat(i):["center","center"]),i[0]=r.test(i[0])?i[0]:"center",i[1]=h.test(i[1])?i[1]:"center",t=l.exec(i[0]),e=l.exec(i[1]),k[this]=[t?t[0]:0,e?e[0]:0],n[this]=[c.exec(i[0])[0],c.exec(i[1])[0]]}),1===w.length&&(w[1]=w[0]),"right"===n.at[0]?m.left+=p:"center"===n.at[0]&&(m.left+=p/2),"bottom"===n.at[1]?m.top+=f:"center"===n.at[1]&&(m.top+=f/2),u=e(k.at,p,f),m.left+=u[0],m.top+=u[1],this.each(function(){var s,r,h=t(this),l=h.outerWidth(),c=h.outerHeight(),d=i(this,"marginLeft"),_=i(this,"marginTop"),x=l+d+i(this,"marginRight")+y.width,C=c+_+i(this,"marginBottom")+y.height,D=t.extend({},m),T=e(k.my,h.outerWidth(),h.outerHeight());"right"===n.my[0]?D.left-=l:"center"===n.my[0]&&(D.left-=l/2),"bottom"===n.my[1]?D.top-=c:"center"===n.my[1]&&(D.top-=c/2),D.left+=T[0],D.top+=T[1],s={marginLeft:d,marginTop:_},t.each(["left","top"],function(e,i){t.ui.position[w[e]]&&t.ui.position[w[e]][i](D,{targetWidth:p,targetHeight:f,elemWidth:l,elemHeight:c,collisionPosition:s,collisionWidth:x,collisionHeight:C,offset:[u[0]+T[0],u[1]+T[1]],my:n.my,at:n.at,within:b,elem:h})}),n.using&&(r=function(t){var e=g.left-D.left,i=e+p-l,s=g.top-D.top,r=s+f-c,u={target:{element:v,left:g.left,top:g.top,width:p,height:f},element:{element:h,left:D.left,top:D.top,width:l,height:c},horizontal:0>i?"left":e>0?"right":"center",vertical:0>r?"top":s>0?"bottom":"middle"};l>p&&p>a(e+i)&&(u.horizontal="center"),c>f&&f>a(s+r)&&(u.vertical="middle"),u.important=o(a(e),a(i))>o(a(s),a(r))?"horizontal":"vertical",n.using.call(this,t,u)}),h.offset(t.extend(D,{using:r}))})},t.ui.position={fit:{left:function(t,e){var i,s=e.within,n=s.isWindow?s.scrollLeft:s.offset.left,a=s.width,r=t.left-e.collisionPosition.marginLeft,h=n-r,l=r+e.collisionWidth-a-n;e.collisionWidth>a?h>0&&0>=l?(i=t.left+h+e.collisionWidth-a-n,t.left+=h-i):t.left=l>0&&0>=h?n:h>l?n+a-e.collisionWidth:n:h>0?t.left+=h:l>0?t.left-=l:t.left=o(t.left-r,t.left)},top:function(t,e){var i,s=e.within,n=s.isWindow?s.scrollTop:s.offset.top,a=e.within.height,r=t.top-e.collisionPosition.marginTop,h=n-r,l=r+e.collisionHeight-a-n;e.collisionHeight>a?h>0&&0>=l?(i=t.top+h+e.collisionHeight-a-n,t.top+=h-i):t.top=l>0&&0>=h?n:h>l?n+a-e.collisionHeight:n:h>0?t.top+=h:l>0?t.top-=l:t.top=o(t.top-r,t.top)}},flip:{left:function(t,e){var i,s,n=e.within,o=n.offset.left+n.scrollLeft,r=n.width,h=n.isWindow?n.scrollLeft:n.offset.left,l=t.left-e.collisionPosition.marginLeft,c=l-h,u=l+e.collisionWidth-r-h,d="left"===e.my[0]?-e.elemWidth:"right"===e.my[0]?e.elemWidth:0,p="left"===e.at[0]?e.targetWidth:"right"===e.at[0]?-e.targetWidth:0,f=-2*e.offset[0];0>c?(i=t.left+d+p+f+e.collisionWidth-r-o,(0>i||a(c)>i)&&(t.left+=d+p+f)):u>0&&(s=t.left-e.collisionPosition.marginLeft+d+p+f-h,(s>0||u>a(s))&&(t.left+=d+p+f))},top:function(t,e){var i,s,n=e.within,o=n.offset.top+n.scrollTop,r=n.height,h=n.isWindow?n.scrollTop:n.offset.top,l=t.top-e.collisionPosition.marginTop,c=l-h,u=l+e.collisionHeight-r-h,d="top"===e.my[1],p=d?-e.elemHeight:"bottom"===e.my[1]?e.elemHeight:0,f="top"===e.at[1]?e.targetHeight:"bottom"===e.at[1]?-e.targetHeight:0,g=-2*e.offset[1];0>c?(s=t.top+p+f+g+e.collisionHeight-r-o,(0>s||a(c)>s)&&(t.top+=p+f+g)):u>0&&(i=t.top-e.collisionPosition.marginTop+p+f+g-h,(i>0||u>a(i))&&(t.top+=p+f+g))}},flipfit:{left:function(){t.ui.position.flip.left.apply(this,arguments),t.ui.position.fit.left.apply(this,arguments)},top:function(){t.ui.position.flip.top.apply(this,arguments),t.ui.position.fit.top.apply(this,arguments)}}}}(),t.ui.position,t.ui.keyCode={BACKSPACE:8,COMMA:188,DELETE:46,DOWN:40,END:35,ENTER:13,ESCAPE:27,HOME:36,LEFT:37,PAGE_DOWN:34,PAGE_UP:33,PERIOD:190,RIGHT:39,SPACE:32,TAB:9,UP:38},t.fn.extend({uniqueId:function(){var t=0;return function(){return this.each(function(){this.id||(this.id="ui-id-"+ ++t)})}}(),removeUniqueId:function(){return this.each(function(){/^ui-id-\d+$/.test(this.id)&&t(this).removeAttr("id")})}}),t.ui.safeActiveElement=function(t){var e;try{e=t.activeElement}catch(i){e=t.body}return e||(e=t.body),e.nodeName||(e=t.body),e},t.widget("ui.menu",{version:"1.12.1",defaultElement:"<ul>",delay:300,options:{icons:{submenu:"ui-icon-caret-1-e"},items:"> *",menus:"ul",position:{my:"left top",at:"right top"},role:"menu",blur:null,focus:null,select:null},_create:function(){this.activeMenu=this.element,this.mouseHandled=!1,this.element.uniqueId().attr({role:this.options.role,tabIndex:0}),this._addClass("ui-menu","ui-widget ui-widget-content"),this._on({"mousedown .ui-menu-item":function(t){t.preventDefault()},"click .ui-menu-item":function(e){var i=t(e.target),s=t(t.ui.safeActiveElement(this.document[0]));!this.mouseHandled&&i.not(".ui-state-disabled").length&&(this.select(e),e.isPropagationStopped()||(this.mouseHandled=!0),i.has(".ui-menu").length?this.expand(e):!this.element.is(":focus")&&s.closest(".ui-menu").length&&(this.element.trigger("focus",[!0]),this.active&&1===this.active.parents(".ui-menu").length&&clearTimeout(this.timer)))},"mouseenter .ui-menu-item":function(e){if(!this.previousFilter){var i=t(e.target).closest(".ui-menu-item"),s=t(e.currentTarget);i[0]===s[0]&&(this._removeClass(s.siblings().children(".ui-state-active"),null,"ui-state-active"),this.focus(e,s))}},mouseleave:"collapseAll","mouseleave .ui-menu":"collapseAll",focus:function(t,e){var i=this.active||this.element.find(this.options.items).eq(0);e||this.focus(t,i)},blur:function(e){this._delay(function(){var i=!t.contains(this.element[0],t.ui.safeActiveElement(this.document[0]));i&&this.collapseAll(e)})},keydown:"_keydown"}),this.refresh(),this._on(this.document,{click:function(t){this._closeOnDocumentClick(t)&&this.collapseAll(t),this.mouseHandled=!1}})},_destroy:function(){var e=this.element.find(".ui-menu-item").removeAttr("role aria-disabled"),i=e.children(".ui-menu-item-wrapper").removeUniqueId().removeAttr("tabIndex role aria-haspopup");this.element.removeAttr("aria-activedescendant").find(".ui-menu").addBack().removeAttr("role aria-labelledby aria-expanded aria-hidden aria-disabled tabIndex").removeUniqueId().show(),i.children().each(function(){var e=t(this);e.data("ui-menu-submenu-caret")&&e.remove()})},_keydown:function(e){var i,s,n,o,a=!0;switch(e.keyCode){case t.ui.keyCode.PAGE_UP:this.previousPage(e);break;case t.ui.keyCode.PAGE_DOWN:this.nextPage(e);break;case t.ui.keyCode.HOME:this._move("first","first",e);break;case t.ui.keyCode.END:this._move("last","last",e);break;case t.ui.keyCode.UP:this.previous(e);break;case t.ui.keyCode.DOWN:this.next(e);break;case t.ui.keyCode.LEFT:this.collapse(e);break;case t.ui.keyCode.RIGHT:this.active&&!this.active.is(".ui-state-disabled")&&this.expand(e);break;case t.ui.keyCode.ENTER:case t.ui.keyCode.SPACE:this._activate(e);break;case t.ui.keyCode.ESCAPE:this.collapse(e);break;default:a=!1,s=this.previousFilter||"",o=!1,n=e.keyCode>=96&&105>=e.keyCode?""+(e.keyCode-96):String.fromCharCode(e.keyCode),clearTimeout(this.filterTimer),n===s?o=!0:n=s+n,i=this._filterMenuItems(n),i=o&&-1!==i.index(this.active.next())?this.active.nextAll(".ui-menu-item"):i,i.length||(n=String.fromCharCode(e.keyCode),i=this._filterMenuItems(n)),i.length?(this.focus(e,i),this.previousFilter=n,this.filterTimer=this._delay(function(){delete this.previousFilter},1e3)):delete this.previousFilter}a&&e.preventDefault()},_activate:function(t){this.active&&!this.active.is(".ui-state-disabled")&&(this.active.children("[aria-haspopup='true']").length?this.expand(t):this.select(t))},refresh:function(){var e,i,s,n,o,a=this,r=this.options.icons.submenu,h=this.element.find(this.options.menus);this._toggleClass("ui-menu-icons",null,!!this.element.find(".ui-icon").length),s=h.filter(":not(.ui-menu)").hide().attr({role:this.options.role,"aria-hidden":"true","aria-expanded":"false"}).each(function(){var e=t(this),i=e.prev(),s=t("<span>").data("ui-menu-submenu-caret",!0);a._addClass(s,"ui-menu-icon","ui-icon "+r),i.attr("aria-haspopup","true").prepend(s),e.attr("aria-labelledby",i.attr("id"))}),this._addClass(s,"ui-menu","ui-widget ui-widget-content ui-front"),e=h.add(this.element),i=e.find(this.options.items),i.not(".ui-menu-item").each(function(){var e=t(this);a._isDivider(e)&&a._addClass(e,"ui-menu-divider","ui-widget-content")}),n=i.not(".ui-menu-item, .ui-menu-divider"),o=n.children().not(".ui-menu").uniqueId().attr({tabIndex:-1,role:this._itemRole()}),this._addClass(n,"ui-menu-item")._addClass(o,"ui-menu-item-wrapper"),i.filter(".ui-state-disabled").attr("aria-disabled","true"),this.active&&!t.contains(this.element[0],this.active[0])&&this.blur()},_itemRole:function(){return{menu:"menuitem",listbox:"option"}[this.options.role]},_setOption:function(t,e){if("icons"===t){var i=this.element.find(".ui-menu-icon");this._removeClass(i,null,this.options.icons.submenu)._addClass(i,null,e.submenu)}this._super(t,e)},_setOptionDisabled:function(t){this._super(t),this.element.attr("aria-disabled",t+""),this._toggleClass(null,"ui-state-disabled",!!t)},focus:function(t,e){var i,s,n;this.blur(t,t&&"focus"===t.type),this._scrollIntoView(e),this.active=e.first(),s=this.active.children(".ui-menu-item-wrapper"),this._addClass(s,null,"ui-state-active"),this.options.role&&this.element.attr("aria-activedescendant",s.attr("id")),n=this.active.parent().closest(".ui-menu-item").children(".ui-menu-item-wrapper"),this._addClass(n,null,"ui-state-active"),t&&"keydown"===t.type?this._close():this.timer=this._delay(function(){this._close()},this.delay),i=e.children(".ui-menu"),i.length&&t&&/^mouse/.test(t.type)&&this._startOpening(i),this.activeMenu=e.parent(),this._trigger("focus",t,{item:e})},_scrollIntoView:function(e){var i,s,n,o,a,r;this._hasScroll()&&(i=parseFloat(t.css(this.activeMenu[0],"borderTopWidth"))||0,s=parseFloat(t.css(this.activeMenu[0],"paddingTop"))||0,n=e.offset().top-this.activeMenu.offset().top-i-s,o=this.activeMenu.scrollTop(),a=this.activeMenu.height(),r=e.outerHeight(),0>n?this.activeMenu.scrollTop(o+n):n+r>a&&this.activeMenu.scrollTop(o+n-a+r))},blur:function(t,e){e||clearTimeout(this.timer),this.active&&(this._removeClass(this.active.children(".ui-menu-item-wrapper"),null,"ui-state-active"),this._trigger("blur",t,{item:this.active}),this.active=null)},_startOpening:function(t){clearTimeout(this.timer),"true"===t.attr("aria-hidden")&&(this.timer=this._delay(function(){this._close(),this._open(t)},this.delay))},_open:function(e){var i=t.extend({of:this.active},this.options.position);clearTimeout(this.timer),this.element.find(".ui-menu").not(e.parents(".ui-menu")).hide().attr("aria-hidden","true"),e.show().removeAttr("aria-hidden").attr("aria-expanded","true").position(i)},collapseAll:function(e,i){clearTimeout(this.timer),this.timer=this._delay(function(){var s=i?this.element:t(e&&e.target).closest(this.element.find(".ui-menu"));s.length||(s=this.element),this._close(s),this.blur(e),this._removeClass(s.find(".ui-state-active"),null,"ui-state-active"),this.activeMenu=s},this.delay)},_close:function(t){t||(t=this.active?this.active.parent():this.element),t.find(".ui-menu").hide().attr("aria-hidden","true").attr("aria-expanded","false")},_closeOnDocumentClick:function(e){return!t(e.target).closest(".ui-menu").length},_isDivider:function(t){return!/[^\-\u2014\u2013\s]/.test(t.text())},collapse:function(t){var e=this.active&&this.active.parent().closest(".ui-menu-item",this.element);e&&e.length&&(this._close(),this.focus(t,e))},expand:function(t){var e=this.active&&this.active.children(".ui-menu ").find(this.options.items).first();e&&e.length&&(this._open(e.parent()),this._delay(function(){this.focus(t,e)}))},next:function(t){this._move("next","first",t)},previous:function(t){this._move("prev","last",t)},isFirstItem:function(){return this.active&&!this.active.prevAll(".ui-menu-item").length},isLastItem:function(){return this.active&&!this.active.nextAll(".ui-menu-item").length},_move:function(t,e,i){var s;this.active&&(s="first"===t||"last"===t?this.active["first"===t?"prevAll":"nextAll"](".ui-menu-item").eq(-1):this.active[t+"All"](".ui-menu-item").eq(0)),s&&s.length&&this.active||(s=this.activeMenu.find(this.options.items)[e]()),this.focus(i,s)},nextPage:function(e){var i,s,n;return this.active?(this.isLastItem()||(this._hasScroll()?(s=this.active.offset().top,n=this.element.height(),this.active.nextAll(".ui-menu-item").each(function(){return i=t(this),0>i.offset().top-s-n}),this.focus(e,i)):this.focus(e,this.activeMenu.find(this.options.items)[this.active?"last":"first"]())),void 0):(this.next(e),void 0)},previousPage:function(e){var i,s,n;return this.active?(this.isFirstItem()||(this._hasScroll()?(s=this.active.offset().top,n=this.element.height(),this.active.prevAll(".ui-menu-item").each(function(){return i=t(this),i.offset().top-s+n>0}),this.focus(e,i)):this.focus(e,this.activeMenu.find(this.options.items).first())),void 0):(this.next(e),void 0)},_hasScroll:function(){return this.element.outerHeight()<this.element.prop("scrollHeight")},select:function(e){this.active=this.active||t(e.target).closest(".ui-menu-item");var i={item:this.active};this.active.has(".ui-menu").length||this.collapseAll(e,!0),this._trigger("select",e,i)},_filterMenuItems:function(e){var i=e.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g,"\\$&"),s=RegExp("^"+i,"i");return this.activeMenu.find(this.options.items).filter(".ui-menu-item").filter(function(){return s.test(t.trim(t(this).children(".ui-menu-item-wrapper").text()))})}}),t.widget("ui.autocomplete",{version:"1.12.1",defaultElement:"<input>",options:{appendTo:null,autoFocus:!1,delay:300,minLength:1,position:{my:"left top",at:"left bottom",collision:"none"},source:null,change:null,close:null,focus:null,open:null,response:null,search:null,select:null},requestIndex:0,pending:0,_create:function(){var e,i,s,n=this.element[0].nodeName.toLowerCase(),o="textarea"===n,a="input"===n;this.isMultiLine=o||!a&&this._isContentEditable(this.element),this.valueMethod=this.element[o||a?"val":"text"],this.isNewMenu=!0,this._addClass("ui-autocomplete-input"),this.element.attr("autocomplete","off"),this._on(this.element,{keydown:function(n){if(this.element.prop("readOnly"))return e=!0,s=!0,i=!0,void 0;e=!1,s=!1,i=!1;var o=t.ui.keyCode;switch(n.keyCode){case o.PAGE_UP:e=!0,this._move("previousPage",n);break;case o.PAGE_DOWN:e=!0,this._move("nextPage",n);break;case o.UP:e=!0,this._keyEvent("previous",n);break;case o.DOWN:e=!0,this._keyEvent("next",n);break;case o.ENTER:this.menu.active&&(e=!0,n.preventDefault(),this.menu.select(n));break;case o.TAB:this.menu.active&&this.menu.select(n);break;case o.ESCAPE:this.menu.element.is(":visible")&&(this.isMultiLine||this._value(this.term),this.close(n),n.preventDefault());break;default:i=!0,this._searchTimeout(n)}},keypress:function(s){if(e)return e=!1,(!this.isMultiLine||this.menu.element.is(":visible"))&&s.preventDefault(),void 0;if(!i){var n=t.ui.keyCode;switch(s.keyCode){case n.PAGE_UP:this._move("previousPage",s);break;case n.PAGE_DOWN:this._move("nextPage",s);break;case n.UP:this._keyEvent("previous",s);break;case n.DOWN:this._keyEvent("next",s)}}},input:function(t){return s?(s=!1,t.preventDefault(),void 0):(this._searchTimeout(t),void 0)},focus:function(){this.selectedItem=null,this.previous=this._value()},blur:function(t){return this.cancelBlur?(delete this.cancelBlur,void 0):(clearTimeout(this.searching),this.close(t),this._change(t),void 0)}}),this._initSource(),this.menu=t("<ul>").appendTo(this._appendTo()).menu({role:null}).hide().menu("instance"),this._addClass(this.menu.element,"ui-autocomplete","ui-front"),this._on(this.menu.element,{mousedown:function(e){e.preventDefault(),this.cancelBlur=!0,this._delay(function(){delete this.cancelBlur,this.element[0]!==t.ui.safeActiveElement(this.document[0])&&this.element.trigger("focus")})},menufocus:function(e,i){var s,n;return this.isNewMenu&&(this.isNewMenu=!1,e.originalEvent&&/^mouse/.test(e.originalEvent.type))?(this.menu.blur(),this.document.one("mousemove",function(){t(e.target).trigger(e.originalEvent)}),void 0):(n=i.item.data("ui-autocomplete-item"),!1!==this._trigger("focus",e,{item:n})&&e.originalEvent&&/^key/.test(e.originalEvent.type)&&this._value(n.value),s=i.item.attr("aria-label")||n.value,s&&t.trim(s).length&&(this.liveRegion.children().hide(),t("<div>").text(s).appendTo(this.liveRegion)),void 0)},menuselect:function(e,i){var s=i.item.data("ui-autocomplete-item"),n=this.previous;this.element[0]!==t.ui.safeActiveElement(this.document[0])&&(this.element.trigger("focus"),this.previous=n,this._delay(function(){this.previous=n,this.selectedItem=s})),!1!==this._trigger("select",e,{item:s})&&this._value(s.value),this.term=this._value(),this.close(e),this.selectedItem=s}}),this.liveRegion=t("<div>",{role:"status","aria-live":"assertive","aria-relevant":"additions"}).appendTo(this.document[0].body),this._addClass(this.liveRegion,null,"ui-helper-hidden-accessible"),this._on(this.window,{beforeunload:function(){this.element.removeAttr("autocomplete")}})},_destroy:function(){clearTimeout(this.searching),this.element.removeAttr("autocomplete"),this.menu.element.remove(),this.liveRegion.remove()},_setOption:function(t,e){this._super(t,e),"source"===t&&this._initSource(),"appendTo"===t&&this.menu.element.appendTo(this._appendTo()),"disabled"===t&&e&&this.xhr&&this.xhr.abort()},_isEventTargetInWidget:function(e){var i=this.menu.element[0];return e.target===this.element[0]||e.target===i||t.contains(i,e.target)},_closeOnClickOutside:function(t){this._isEventTargetInWidget(t)||this.close()},_appendTo:function(){var e=this.options.appendTo;return e&&(e=e.jquery||e.nodeType?t(e):this.document.find(e).eq(0)),e&&e[0]||(e=this.element.closest(".ui-front, dialog")),e.length||(e=this.document[0].body),e},_initSource:function(){var e,i,s=this;t.isArray(this.options.source)?(e=this.options.source,this.source=function(i,s){s(t.ui.autocomplete.filter(e,i.term))}):"string"==typeof this.options.source?(i=this.options.source,this.source=function(e,n){s.xhr&&s.xhr.abort(),s.xhr=t.ajax({url:i,data:e,dataType:"json",success:function(t){n(t)},error:function(){n([])}})}):this.source=this.options.source},_searchTimeout:function(t){clearTimeout(this.searching),this.searching=this._delay(function(){var e=this.term===this._value(),i=this.menu.element.is(":visible"),s=t.altKey||t.ctrlKey||t.metaKey||t.shiftKey;(!e||e&&!i&&!s)&&(this.selectedItem=null,this.search(null,t))},this.options.delay)},search:function(t,e){return t=null!=t?t:this._value(),this.term=this._value(),t.length<this.options.minLength?this.close(e):this._trigger("search",e)!==!1?this._search(t):void 0},_search:function(t){this.pending++,this._addClass("ui-autocomplete-loading"),this.cancelSearch=!1,this.source({term:t},this._response())},_response:function(){var e=++this.requestIndex;return t.proxy(function(t){e===this.requestIndex&&this.__response(t),this.pending--,this.pending||this._removeClass("ui-autocomplete-loading")},this)},__response:function(t){t&&(t=this._normalize(t)),this._trigger("response",null,{content:t}),!this.options.disabled&&t&&t.length&&!this.cancelSearch?(this._suggest(t),this._trigger("open")):this._close()},close:function(t){this.cancelSearch=!0,this._close(t)},_close:function(t){this._off(this.document,"mousedown"),this.menu.element.is(":visible")&&(this.menu.element.hide(),this.menu.blur(),this.isNewMenu=!0,this._trigger("close",t))},_change:function(t){this.previous!==this._value()&&this._trigger("change",t,{item:this.selectedItem})},_normalize:function(e){return e.length&&e[0].label&&e[0].value?e:t.map(e,function(e){return"string"==typeof e?{label:e,value:e}:t.extend({},e,{label:e.label||e.value,value:e.value||e.label})})},_suggest:function(e){var i=this.menu.element.empty();this._renderMenu(i,e),this.isNewMenu=!0,this.menu.refresh(),i.show(),this._resizeMenu(),i.position(t.extend({of:this.element},this.options.position)),this.options.autoFocus&&this.menu.next(),this._on(this.document,{mousedown:"_closeOnClickOutside"})},_resizeMenu:function(){var t=this.menu.element;t.outerWidth(Math.max(t.width("").outerWidth()+1,this.element.outerWidth()))},_renderMenu:function(e,i){var s=this;t.each(i,function(t,i){s._renderItemData(e,i)})},_renderItemData:function(t,e){return this._renderItem(t,e).data("ui-autocomplete-item",e)},_renderItem:function(e,i){return t("<li>").append(t("<div>").text(i.label)).appendTo(e)},_move:function(t,e){return this.menu.element.is(":visible")?this.menu.isFirstItem()&&/^previous/.test(t)||this.menu.isLastItem()&&/^next/.test(t)?(this.isMultiLine||this._value(this.term),this.menu.blur(),void 0):(this.menu[t](e),void 0):(this.search(null,e),void 0)},widget:function(){return this.menu.element},_value:function(){return this.valueMethod.apply(this.element,arguments)},_keyEvent:function(t,e){(!this.isMultiLine||this.menu.element.is(":visible"))&&(this._move(t,e),e.preventDefault())},_isContentEditable:function(t){if(!t.length)return!1;var e=t.prop("contentEditable");return"inherit"===e?this._isContentEditable(t.parent()):"true"===e}}),t.extend(t.ui.autocomplete,{escapeRegex:function(t){return t.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g,"\\$&")},filter:function(e,i){var s=RegExp(t.ui.autocomplete.escapeRegex(i),"i");return t.grep(e,function(t){return s.test(t.label||t.value||t)})}}),t.widget("ui.autocomplete",t.ui.autocomplete,{options:{messages:{noResults:"No search results.",results:function(t){return t+(t>1?" results are":" result is")+" available, use up and down arrow keys to navigate."}}},__response:function(e){var i;this._superApply(arguments),this.options.disabled||this.cancelSearch||(i=e&&e.length?this.options.messages.results(e.length):this.options.messages.noResults,this.liveRegion.children().hide(),t("<div>").text(i).appendTo(this.liveRegion))}}),t.ui.autocomplete});
