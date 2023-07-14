require('@npm/jquery');
require('@npm/jquery-mousewheel')
require('@npm/malihu-custom-scrollbar-plugin')
require('@web/libs/jquery-3.2.1.min.js');
require('@web/libs/bootstrap-3.3.7-dist/js/bootstrap.min.js');
require('@web/libs/jasny-bootstrap/js/jasny-bootstrap.min.js');
require('@web/libs/jquery-ui-1.12.1.custom/jquery-ui.min.js');
require('@web/libs/jquery.ui.touch-punch.min.js');
require('@web/libs/slick/slick.js');
require('@web/libs/bootstrap-select-1.12.4/js/bootstrap-select.min.js');
require('@web/libs/bootstrap-select-1.12.4/js/i18n/defaults-ru_RU.min.js');
require('@web/libs/magnific-popup/jquery.magnific-popup.min.js');
require('@web/libs/tooltipster/dist/js/tooltipster.bundle.min.js');
require('@web/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
require('@web/libs/bootstrap-datepicker/locales/bootstrap-datepicker.ru.min.js');
require('@web/js/polyfill.js');
require('@web/js/site-scripts.js');
require('@web/libs/bootstrap-3.3.7-dist/css/bootstrap.min.css');
require('@web/libs/bootstrap-3.3.7-dist/css/bootstrap-theme.min.css');
require('@web/libs/jasny-bootstrap/css/jasny-bootstrap.min.css');
require('@web/libs/jquery-ui-1.12.1.custom/jquery-ui.structure.min.css');
require('@web/libs/slick/slick.css');
require('@web/libs/bootstrap-select-1.12.4/css/bootstrap-select.min.css');
require('@web/libs/magnific-popup/magnific-popup.css');
require('@web/libs/tooltipster/dist/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-light.min.css');
require('@web/libs/tooltipster/dist/css/tooltipster.bundle.min.css');
require('@web/libs/bootstrap-datepicker/css/bootstrap-datepicker.css');
require('@web/site.css');

jQuery(function(){
    var p = $('.sf-toolbar').length ? '/app_dev.php' : '';
    $(document).on("click", ".js-add-to-favorite", function(e) {
        var t=$(this);
        $.post(p+'/addtofavorites', {item: $(this).parents('section.js-data').data('id')}, function(data){
            $('.js-favorite-counter').text(data.count);
            var message = '';
            if (data.noauth) {
                message = 'Нужно авторизоваться';
                alert(message);
            } else {
                if (data.error) {
                    message = 'уже добавлено в избранное';
                    if (confirm('Уже добавлено в избранное. Удалить из избранного?')) {
                        $.post(p+'/addtofavorites', {item: t.parents('section.js-data').data('id'), 'delete': 1}, function(data){
                            $('.js-favorite-counter').text(data.count);
                            var message = '';
                            if (data.noauth) {
                                message = 'Нужно авторизоваться';
                                alert(message);
                            } 
                            if (data.done) {
                                t.removeClass('in-favorite');
                            }
                        });
                    }
                } else {
                    if (data.done) {
                        message = 'добавлено в избранное';
                        t.addClass('in-favorite');
                        alert(message);
                    }
                }
            }
        });
    });

    $('select.js-sort').on('change',function() {
        window.location.href = $(this).val();
    });

    $('.js-auth-container>a.black-yellow').hover(function() {
        $(this).parent().find('button').removeClass('yellow').addClass('black-yellow');
    }, function() {
        $(this).parent().find('button').addClass('yellow').removeClass('black-yellow');
    });

    $(document).on('change', '.js-profile #form_brand, .js-profile input[name=form\\[brandImage\\]\\[binaryContent\\]]', function() {
        if($('#form_brand').val() || $('input[name=form\\[brandImage\\]\\[binaryContent\\]]').val()) {
            $('.js-profile #form_brand, .js-profile input[name=form\\[brandImage\\]\\[binaryContent\\]]').prop('required',true);
        } else {
            $('.js-profile #form_brand, .js-profile input[name=form\\[brandImage\\]\\[binaryContent\\]]').prop('required',false);
        }
    });

    $(document).on('submit', '.js--site-popup-window form', function() {
        var t = $(this);
        $.post(t.attr("action"), t.serializeArray(), function(data){ 
            t.replaceWith($('form', data).length ? $('form', data) : $(data));
        });
        return false;
    });

    $(document).on('click', '.js-more-message', function() {
        $('.message-list .hide').removeClass('hide');
        $(this).remove();
        return false;
    });

    $(document).on('click', '.js-scroll-focus', function() {
        var t = $($(this).data('target'));
        $('html, body').animate({
            scrollTop: (t.first().offset().top-200)
        },500);
        t.focus();
        return false;
    });

    $(document).on('click', '.js-order-done', function() {
        $('#formOrder_status_3').prop('checked', true);
        $('form[name=formOrder]').submit();
        return false;
    });

    $('.js-modal').magnificPopup({
        type: 'ajax',
        preloader: false,
        modal: true,
        alignTop: false,
        overflowY: 'scroll',
        callbacks: {
            parseAjax: function(mfpResponse) {
                var mp = $.magnificPopup.instance,
                    t = $(mp.currItem.el[0]),
                    title = t.data('title');
                if (title) {
                    mfpResponse.data = mfpResponse.data.replace('site-default-text">', 'site-default-text"><h1>'+title+'</h1>');
                }
            },
        }
    });

    $('.spec-offer-list input').on('change', function (e) {
        $('.spec-offer-list input').not(this).prop('checked', false); 
        if ($('.spec-offer-list input:checked').length) {
            if (!(parseInt($('#form_discount').val()) > 0)) {
                $('.js-discount input[type=radio][value=10]').trigger('change');
            }
        } else {
            $('.js-discount input[type=radio]:checked').prop('checked', false);
            $('#form_discount').val('');
        }
    });

    if ($('.js-catalogue-tree').length) {
        $('.js-catalogue-tree').removeClass('hide').insertAfter('#section-window form .site-popup-tabs-control');
    }

    if ($('.js-selections').length) {
        $('.js-selections').removeClass('hide').insertBefore('#collection-window form .save-item');
    }

    if ($('#form-colors-id').length) {
            var colorForm = $('#form-colors-id'); // forms' ID
            var colorFormItems = colorForm.find('input[type=checkbox]');
            var maxColors = 2; // max number of colors to choose
            colorFormItems.on('change', function (e) {
                    var checked = colorFormItems.filter(function() {
                        if ($(this).prop('checked')) {
                            return true;
                        }
                    return false;
                });
                if (checked.length >= maxColors) {
                    // hide others
                    var unchecked = colorFormItems.filter(function() {
                        if (!$(this).prop('checked')) {
                            return true;
                        }
                        return false;
                    });
                    unchecked.prop('disabled', true);
                } else {
                    // show all
                    var unchecked = colorFormItems.filter(function() {
                        if (!$(this).prop('checked')) {
                            return true;
                        }
                        return false;
                    });
                    unchecked.removeAttr('disabled');
                }
            });
        if (colorForm.find('input[type=checkbox]:checked').length >= maxColors) {
            // hide others
            var unchecked = colorFormItems.filter(function() {
                if (!$(this).prop('checked')) {
                    return true;
                }
                return false;
            });
            unchecked.prop('disabled', true);
        }
        var resetColorsLink = $('#form-colors-reset-id');
        resetColorsLink.on('click', function (e) {
            e.preventDefault();
            colorFormItems.prop('checked', false);
            colorFormItems.removeAttr('disabled');
        });
    }

    $(document).on('change', '.js-discount input[type=radio]', function() {
        $('#form_discount').val($(this).val());
        if ((parseInt($('#form_discount').val()) > 0)) {
            if (!$('.spec-offer-list input:checked').length) {
                $('#form_sale_1').prop('checked', true);
            }
        } else {
            $('.spec-offer-list input:checked').prop('checked', false); 
        }
    });

    $(document).on('change', '.js-discount #form_discount', function() {
        $('.js-discount input[type=radio]:checked').prop('checked', false);
        if ((parseInt($('#form_discount').val()) > 0)) {
            if (!$('.spec-offer-list input:checked').length) {
                $('#form_sale_1').prop('checked', true);
            }
        } else {
            $('.spec-offer-list input:checked').prop('checked', false); 
        }
    });

    $(document).on('click', '.js--new-selection', function() {
        var t = $('input[name=new_collection]');
        $.post($(this).data("action"), {name: t.val()}, function(data){ 
            $('.done').remove();
            if (data.done) {
                $('<div class="done">Коллекция добавлена - ' + t.val() + '</div>').insertAfter($('.js--new-selection'));
                var t2 = $('.js-selections>div:first').clone(true, true);
                var ct = $('.js-selections label').length-1;
                t2.find('.text').html(t.val());
                t2.find('input').data('value', t.val())
                        .val(ct).attr('id', 'form_selections_'+ct)
                        .prop('checked', false);
                t2.find('label').attr('for', 'form_selections_'+ct);
                t2.appendTo('.js-selections');
                t.val('');
            } else {
                $('<div class="done">'+data.error+'</div>').insertAfter($('.js--new-selection'));
            }
            //t.replaceWith($('form', data).length ? $('form', data) : $(data));
        });
        return false;
    });

    $(document).on('click', '.js-image .image-remove', function() {
        $(this).parents('.js-image').find('.image._empty').attr('style', '');
        $(this).parents('.js-image').find('.note').remove();
        $('<div class="note">Изображение удалено, не забудьте сохранить</div>').appendTo($(this).parents('.js-image'));
    });

    $('body').on('change', '.js-image input[type=file]', function (e) {
        var src = URL.createObjectURL(e.target.files[0]),
            img = $(this).parents('.js-image').find('.image._empty'),
            input = e.target;
        $(this).parents('.js-image').find('.note').remove();

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                img.attr('style', 'background-image: url(' +e.target.result +')');
                $('<div class="note">Изображение загружено, не забудьте сохранить</div>').appendTo($(img).parents('.js-image'));
            };
            reader.readAsDataURL(input.files[0]);
        }
    });

    $(document).on('submit', '.site-members-area form', function() {
        $('button', this).prop('disabled', true);
        return true;
    });

    if ($('.js--site-carousel').length) {
        var onCarouselResize = function(carousel, next, prev) {
            var img = carousel.find('.link');
            if (img.length) {
                var imgHeight = img.height();
                prev.css({ top : imgHeight / 2 });
                next.css({ top : imgHeight / 2 });
            }
        };
        $('.js--site-carousel').each(function(index, item) {
            var carousel = $(item);
            var prev = carousel.find('.slick-prev');
            var next = carousel.find('.slick-next');
            $(window).off('resize').on('resize', function(e) {
                onCarouselResize(carousel, next, prev);
            });
            onCarouselResize(carousel, next, prev);
        });
    }

})