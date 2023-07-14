'use strict';

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) {
    return typeof obj;
} : function (obj) {
    return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
};

var _createClass = function () {
    function defineProperties(target, props) {
        for (var i = 0; i < props.length; i++) {
            var descriptor = props[i];descriptor.enumerable = descriptor.enumerable || false;descriptor.configurable = true;if ("value" in descriptor) descriptor.writable = true;Object.defineProperty(target, descriptor.key, descriptor);
        }
    }return function (Constructor, protoProps, staticProps) {
        if (protoProps) defineProperties(Constructor.prototype, protoProps);if (staticProps) defineProperties(Constructor, staticProps);return Constructor;
    };
}();

function _classCallCheck(instance, Constructor) {
    if (!(instance instanceof Constructor)) {
        throw new TypeError("Cannot call a class as a function");
    }
}

/**
 *
 * @class SiteClass
 * @description Base class for working with a site page
 * @author Denis Khakimov <denisdude@gmail.com>
 * @date 19:31 05.07.2018
 *
 */
var SiteClass = function () {
    /**
     * Class constructor
     * @param win
     */
    function SiteClass(win) {
        _classCallCheck(this, SiteClass);

        this.win = win; // window object
        this.width = this.win.innerWidth;
        this.height = this.win.innerHeight;

        this.init();
        this.mode_of_log = this.LOG_MSG_DEFAULT;
        this.type_of_log = this.LOG_MSG_CONSOLE;
        this.debug = false;

        this.resize();
    }

    _createClass(SiteClass, [{
        key: 'isTablet',
        value: function isTablet() {
            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
                var ww = $(window).width() < window.screen.width ? $(window).width() : window.screen.width; //get proper width
                var mw = 640; // min width of site
                var tw = 1370;
                if (ww <= mw) {
                    //smaller than minimum size
                    return true;
                } else if (ww < tw) {
                    return true;
                }
            }
            return false;
        }
    }, {
        key: 'resize',
        value: function resize(e) {
            this.width = this.win.innerWidth;
            this.height = this.win.innerHeight;
            this._('Window\'s size: ' + this.width + 'px x ' + this.height + 'px');
        }
    }, {
        key: '_',
        value: function _(msg) {
            if (this.debug) this.log(msg, this.LOG_MSG_INFO);
        }

        /**
         * Removes spaces from `float` and retunrs float
         * @param number
         * @returns {number}
         */

    }, {
        key: 'clearFloat',
        value: function clearFloat(float) {
            var str = float;
            str = str.replace(' ', '');
            return parseFloat(str);
        }

        /**
         * Simple phone validation
         * @param phone
         * @returns {boolean}
         */

    }, {
        key: 'validatePhone',
        value: function validatePhone(phone) {
            //var re = /^[\d\-.+()\/ ]+$/ui;
            var re = /\+7 \([0-9]{3}\) [0-9]{3}\x2D[0-9]{2}\x2D[0-9]{2}/i;
            return re.test(phone);
        }

        /**
         * Simple name validation
         * @param name
         * @returns {boolean}
         */

    }, {
        key: 'validateName',
        value: function validateName(name) {
            var re = /[\t-\r A-Za-z\xA0\u017F\u0410-\u044F\u1680\u2000-\u200A\u2028\u2029\u202F\u205F\u212A\u3000\uFEFF]+/i;
            return re.test(name);
        }

        /**
         * Simple card validation
         * @param card
         * @returns {boolean}
         */

    }, {
        key: 'validateCard',
        value: function validateCard(card) {
            var re = /[0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4}/i;
            return re.test(card);
        }

        /**
         * Simple email validation
         * @param email
         * @returns {boolean}
         */

    }, {
        key: 'validateEmail',
        value: function validateEmail(email) {
            var re = /^(?:[\0-\x08\x0E-\x1F!-\x9F\xA1-\u167F\u1681-\u1FFF\u200B-\u2027\u202A-\u202E\u2030-\u205E\u2060-\u2FFF\u3001-\uD7FF\uE000-\uFEFE\uFF00-\uFFFF]|[\uD800-\uDBFF][\uDC00-\uDFFF]|[\uD800-\uDBFF](?![\uDC00-\uDFFF])|(?:[^\uD800-\uDBFF]|^)[\uDC00-\uDFFF])+@(?:[\0-\x08\x0E-\x1F!-\x9F\xA1-\u167F\u1681-\u1FFF\u200B-\u2027\u202A-\u202E\u2030-\u205E\u2060-\u2FFF\u3001-\uD7FF\uE000-\uFEFE\uFF00-\uFFFF]|[\uD800-\uDBFF][\uDC00-\uDFFF]|[\uD800-\uDBFF](?![\uDC00-\uDFFF])|(?:[^\uD800-\uDBFF]|^)[\uDC00-\uDFFF])+\.[A-Za-z\u017F\u0410-\u044F\u212A]{2,15}$/i;
            return re.test(email);
        }

        /**
         * Simple number validation
         * @param number
         * @returns {boolean}
         */

    }, {
        key: 'validateNumber',
        value: function validateNumber(number) {
            var re = /^[0-9]+$/i;
            return re.test(number);
        }

        /**
         * Works like the PHP function var_dump
         * @param variable
         * @param BR
         * @param tab
         * @param no_check
         * @returns {string}
         */

    }, {
        key: 'var_dump',
        value: function var_dump(variable, BR, tab, no_check) {
            var new_line = '\n',
                r = '';
            BR = BR || new_line;
            tab = tab || 1;
            no_check = no_check || false;
            for (var item in variable) {
                var temp = '';
                r += _typeof(variable[item]);
                temp = variable[item];
                if (_typeof(variable[item]) === 'object' && !no_check) {
                    var BR2 = BR;
                    for (var i = 0; i < tab; i++) {
                        BR2 += '\t';
                    }
                    temp = BR2 + '{' + BR2 + this.var_dump(variable[item], BR2, tab) + '}';
                }
                r += '[\'' + item + '\']: ' + temp + BR;
            }
            return r;
        }

        /**
         * Works like the PHP function number_format
         * @param number
         * @param decimals
         * @param dec_point
         * @param thousands_sep
         * @returns {*}
         */

    }, {
        key: 'number_format',
        value: function number_format(number, decimals, dec_point, thousands_sep) {
            var i = void 0,
                j = void 0,
                kw = void 0,
                kd = void 0,
                km = void 0;
            // clearing inputs
            decimals = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals;
            dec_point = dec_point === undefined ? ',' : dec_point;
            thousands_sep = thousands_sep === undefined ? '.' : thousands_sep;

            i = parseInt(number = (+number || 0).toFixed(decimals)) + '';

            if ((j = i.length) > 3) {
                j = j % 3;
            } else {
                j = 0;
            }

            km = j ? i.substr(0, j) + thousands_sep : '';
            kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
            kd = decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : '';

            return km + kw + kd;
        }

        /**
         * Adds the current page to favorites
         * @param a
         * @returns {boolean}
         */

    }, {
        key: 'addToFavorites',
        value: function addToFavorites(a) {
            var title = this.win.document.title,
                url = this.win.document.location;
            try {
                // Internet Explorer
                this.win.external.AddFavorite(url, title);
            } catch (e) {
                try {
                    // Mozilla
                    this.win.sidebar.addPanel(title, url, '');
                } catch (e) {
                    // Opera
                    if ((typeof opera === 'undefined' ? 'undefined' : _typeof(opera)) === 'object' || this.win.sidebar) {
                        a.rel = 'sidebar';
                        a.title = title;
                        a.url = url;
                        a.href = url;
                        return true;
                    } else {
                        // Unknown
                        alert('Please press CTRL+D to add the page to favorites');
                    }
                }
            }
            return true;
        }

        /**
         * Allows to input float numbers only
         * onkeypress="return site.onlyFloat(event)"
         * @param e
         * @returns {boolean}
         */

    }, {
        key: 'onlyFloat',
        value: function onlyFloat(e) {
            var key = typeof e.charCode === 'undefined' ? e.keyCode : e.charCode;
            if (e.ctrlKey || e.altKey || key < 32) return true;
            key = String.fromCharCode(key);
            return (/[\d.]/.test(key)
            );
        }

        /**
         * Allows to input letters and spaces only
         * onkeypress="return site.onlyLiterals(event)"
         * @param e
         * @returns {boolean}
         */

    }, {
        key: 'onlyLiterals',
        value: function onlyLiterals(e) {
            var key = typeof e.charCode === 'undefined' ? e.keyCode : e.charCode;
            if (e.ctrlKey || e.altKey || key < 32) return true;
            key = String.fromCharCode(key);
            return (/[a-zA-Zа-яА-Я ]/.test(key)
            );
        }

        /**
         * Allows to input decimal numbers only
         * onkeypress="return site.onlyNumbers(event)"
         * @param e
         * @returns {boolean}
         */

    }, {
        key: 'onlyNumbers',
        value: function onlyNumbers(e) {
            var key = typeof e.charCode === 'undefined' ? e.keyCode : e.charCode;
            if (e.ctrlKey || e.altKey || key < 32) return true;
            key = String.fromCharCode(key);
            return (/[\d]/.test(key)
            );
        }

        /**
         * Initializes class variables
         */

    }, {
        key: 'init',
        value: function init() {
            var _this = this;

            // types of log messages
            this.LOG_MSG_OK = 1;
            this.LOG_MSG_FAIL = 2;
            this.LOG_MSG_INFO = 3;
            this.LOG_MSG_DEFAULT = 0;

            // types of log outputs
            this.LOG_MSG_CONSOLE = 1;
            this.LOG_MSG_ALERT = 2;

            this.win.addEventListener('resize', function (e) {
                return _this.resize(e);
            });
        }

        /**
         * Outputs a msg into console or window
         * @param msg
         * @param mode
         * @param type
         */

    }, {
        key: 'log',
        value: function log(msg) {
            var mode = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : this.mode_of_log;
            var type = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : this.type_of_log;

            var styles = [];
            // styles console output
            switch (mode) {
                case this.LOG_MSG_OK:
                    styles.push('color: green;');
                    break;
                case this.LOG_MSG_FAIL:
                    styles.push('color: red;');
                    break;
                case this.LOG_MSG_INFO:
                    styles.push('color: blue;');
                    break;
                case this.LOG_MSG_DEFAULT:
                default:
                    break;
            }
            // echoes log message
            switch (type) {
                case this.LOG_MSG_CONSOLE:
                    console.log('%c' + msg, styles.join(';'));
                    break;
                case this.LOG_MSG_ALERT:
                    alert(msg);
                    break;
                case this.LOG_MSG_DEFAULT:
                default:
                    console.log(msg);
                    break;
            }
        }
    }]);

    return SiteClass;
}();
'use strict';

var site = new SiteClass(window);

$(document).ready(function () {

    $('.js--no-click').on('click', function (e) {
        e.preventDefault();
    });

    // site-sliders
    $('.js--site-slider').slick({
        dots: true,
        arrows: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 4000,
        speed: 750
        //,variableWidth: true
        //,centerMode: true
        , touchThreshold: 15
    });

    // site-article-sliders
    $('.js--site-article-slider').slick({
        dots: false,
        arrows: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 4000,
        speed: 750
        //,variableWidth: true
        //,centerMode: true
        , touchThreshold: 15
    });

    // site-carousels
    $('.js--site-carousel').slick({
        dots: false,
        arrows: true,
        slidesToShow: 6,
        slidesToScroll: 3,
        autoplay: true,
        autoplaySpeed: 4000,
        speed: 750
        //,variableWidth: true
        //,centerMode: true
        , touchThreshold: 15,
        responsive: [{
            breakpoint: 680,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 2
            }
        }]
    });
    $('.js--carousel-products').slick('slickSetOption', {
        slidesToShow: 4,
        responsive: [{
            breakpoint: 680,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        }]
    }, true);

    // site-tabs
    $('.js--tab-selector').on('click', function (e) {
        var a = $(this),
            tabId = a.attr('href'),
            tab = $(tabId);
        e.preventDefault();
        if (tab.length) {
            $('.js--tab-selector').removeClass('active');
            $('.js--site-tab-content').removeClass('active');
            a.addClass('active');
            tab.addClass('active');
        }
    });

    // styling select elements
    $('.selectpicker').selectpicker({
        style: 'site-select'
    });

    // js--site-filter
    $('body').on('click', '.js--site-filter .title', function (e) {
        var a = $(this),
            field = a.parents('.js--site-filter');

        e.preventDefault();
        field.toggleClass('active');
    });

    // tooltips
    // Just add the attribute:
    // data-tooltip="SOME TEXT"
    // to an element
    if ($('[data-tooltip]').length) {

        // Adds a tooltip icon into each TAG with data-tooltip attribute
        $('[data-tooltip]').each(function () {
            var cont = $(this),
                text = cont.data('tooltip'),
                html = [];
            html.push('<span class="site-tooltip-icon js--site-tooltip" title="' + text + '">?</span>');
            cont.append(html.join(''));
        });

        // Enables tooltip plugin for each tooltip icon
        $('.js--site-tooltip').tooltipster({
            theme: ['tooltipster-light', 'site-tooltip'],
            maxWidth: 280
        });
    }

    // set focus to form field on icon click
    $('.form-field .icon').on('click', function (e) {
        var icon = $(this),
            formField = icon.parents('.form-field'),
            input = formField.find('input');
        input.trigger('focus');
        e.preventDefault();
    });

    // bootstrap datepicker
    $('[data-datepicker]').datepicker({
        language: 'ru'
    });

    // product gallery
    $('[data-gallery]').on('click', function (e) {
        var a = $(this),
            mainImageId = a.data('main-image'),
            mainImage = null;
        e.preventDefault();
        if ($(mainImageId).length) {
            mainImage = $(mainImageId);
            mainImage.find('.image').attr('src', a.attr('href'));
        }
    });
    // product video
    $('[data-video]').magnificPopup({
        disableOn: 320,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });
    // popup content window
    $('[data-open-popup]').magnificPopup({
        type: 'inline',
        preloader: false,
        modal: true
    });
    $(document).on('click', '.js--popup-main-close', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
    });

    // jquery ui slider
    $('.js--slider').each(function () {
        var el = $(this),
            p = el.parents('.form-field'),
            min = parseFloat(el.data('min')),
            max = parseFloat(el.data('max')),
            fmin = p.find('input[data-min]'),
            fmax = p.find('input[data-max]'),
            minValue = parseFloat(fmin.val()),
            maxValue = parseFloat(fmax.val());

        //console.log(`fmin: ${minValue}, fmax: ${maxValue}`);
        el.slider({
            orientation: 'horizontal',
            range: true
            //,step: 1
            , min: min,
            max: max,
            values: [minValue, maxValue],
            create: function create(event, ui) {},
            stop: function stop(event, ui) {},
            start: function start(event, ui) {},
            slide: function slide(event, ui) {
                fmin.val(ui.values[0]);
                fmax.val(ui.values[1]);
                // и насильно вызываем событие `change`
                fmin.trigger('change');
                fmax.trigger('change');
            }
        });
    });

    // live-search form field begin
    if ($('.js--live-search').length) {
        // наводим красоту
        $(document).on('focusin', '.js--live-search :input', function (e) {
            var f = $(this),
                ff = f.parents('.js--live-search');
            ff.addClass('focus');
        });
        $(document).on('focusout', '.js--live-search :input', function (e) {
            var f = $(this),
                ff = f.parents('.js--live-search');
            ff.removeClass('focus');
        });

        // массив с ТЕСТОВЫМИ данными!
        var liveSearchTestData = ['Москва', 'Питер', 'Екатеринбург', 'Новосибирск', 'Бостон', 'Лондон', 'Иерусалим', 'Старый Оскол', 'Самара', 'Владивосток', 'Кемерово', 'Мытищи', 'Сочи', 'Минск', 'Париж', 'Нижний Новгород'];
        // ловим ввод текста
        $(document).on('input', '.js--live-search', function (e) {
            var ff = $(this),
                f = ff.find(':input'),
                fv = f.val(),
                dropdown = ff.find('.js--live-search-dropdown');

            // выходим, если запрос пустой менее 2 символов
            if (fv.length < 2) return false;
            dropdown.empty(); // чистим выпадающий список
            ff.addClass('searching'); // показываем анимацию поиска

            // тут можно заполнить массив liveSearchTestData актуальным списком городов
            // @TODO: ЗАПОЛНИ массив liveSearchTestData!

            // получаем результаты
            var results = liveSearchTestData.filter(function (value, index, arr) {
                if (value.toUpperCase().includes(fv.toUpperCase().trim())) return true;
            });

            // эмуляция паузы для поиска
            setTimeout(function () {
                var html = new Array();
                if (results.length) {
                    results.forEach(function (value, index, arr) {
                        html.push('<li><a href>' + value + '</a></li>');
                    });
                    dropdown.html(html.join(''));
                    ff.addClass('active'); // показываем список
                }
                // снимаем всю красоту с поля
                ff.removeClass('searching'); // и показываем список
            }, 1200);

            e.preventDefault();
            e.stopPropagation();
        });

        // клик на ссылке из выпадающего списка
        $('body').on('click', '.js--live-search a', function (e) {
            var a = $(this),
                ff = a.parents('.js--live-search'),
                f = ff.find(':input'),
                val = a.html();

            f.val(val);
            ff.removeClass('active');

            e.preventDefault();
        });
    }
    // live-search form field end


    // popup windows
    window.closePopups = function () {
        $('.js--site-popup-window').removeClass('active');
        $('.js--hide-when-popup-open').show();
        $('.js--mobile-header').removeClass('active');
        $('body').removeClass('modal-active');
        $('.js--site-popup-back').removeClass('active');
    };
    $('body').on('click', '.js--open-popup', function (e) {
        var a = $(this),
            href = a.attr('href'),
            back = $('.js--site-popup-back'),
            win = null;
        e.preventDefault();
        // in any case we should close all opened popups
        window.closePopups();
        if (a.hasClass('active')) {
            // closing window
            a.removeClass('active');
        } else {
            // opening window
            a.addClass('active');
            // if there's a window on the page...
            if ($(href).length) {
                win = $(href);
                // opening window
                $('.js--hide-when-popup-open').hide();
                $('.js--mobile-header').addClass('active');
                // pop up a back div
                back.addClass('active');
                setTimeout(function () {
                    // pop up the window
                    $('body').addClass('modal-active');
                    win.addClass('active');
                }, 300);
            }
        }
    });

    function scalePageViewport() {
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
            var ww = $(window).width() < window.screen.width ? $(window).width() : window.screen.width; //get proper width
            var ratio = 1; // calculate ratio
            if (ww <= 640) {
                //smaller than minimum size
                ratio = ww / 640; // recalculate ratio
                $('#site-viewport').attr('content', 'initial-scale=' + ratio + ', maximum-scale=' + ratio + ', minimum-scale=' + ratio + ', user-scalable=yes, viewport-fit=cover, width=device-width');
            } else if (ww <= 940) {
                //smaller than minimum size
                ratio = ww / 940; // recalculate ratio
                $('#site-viewport').attr('content', 'initial-scale=' + ratio + ', maximum-scale=' + ratio + ', minimum-scale=' + ratio + ', user-scalable=yes, viewport-fit=cover, width=device-width');
            } else {
                $('#site-viewport').attr('content', 'width=device-width, initial-scale=1');
            }
        } else {
            $('#site-viewport').attr('content', 'width=device-width, initial-scale=1');
        }
    }

    function windowResize(e) {
        var w = $(window).width(),
            h = $(window).height();

        // set viewport settings
        scalePageViewport();
    }

    function callWindowResize(e) {
        clearTimeout(window.isResized);
        window.isResized = setTimeout(function (e) {
            windowResize(e);
        }, 40);
    }

    window.addEventListener('resize', callWindowResize, false);
    windowResize();

    function scrollWindow(e) {
        var wsy = window.scrollY | window.pageYOffset;
    }
    window.addEventListener('scroll', scrollWindow, false);

    /**
     * Плавная прокрутка к элементу
     * @param element
     * @param page если пусто, проматываем на текущей странице, если нет - с редиректом
     */
    window.scrollToElement = function (element, page) {
        var goTo = 0,
            scrollSpeed = 800,
            offset = 10,
            $page = page ? page : '';
        if ($page) {
            document.location = $page + '#' + element;
            return false;
        }
        $.magnificPopup.close();
        //console.log(element);
        switch (element) {
            case 'top':
                goTo = 0;
                break;
            case 'first':
                if ($('div').first().length) {
                    goTo = $('div').first().offset().top - offset;
                } else {
                    goTo = 0;
                }
                break;
            default:
                // проверяем, есть ли такой объект на странице
                if ($('#' + element).length) {
                    goTo = $('#' + element).offset().top - offset;
                } else {
                    goTo = 0;
                }
        }
        $('html, body').stop().animate({ scrollTop: goTo }, scrollSpeed);
        return false;
    };
});