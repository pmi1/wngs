$(document).ready(function() {
    $(document).on('click', '.js-generation-cases', function (e) {
        NProgress.start();
        var cont = $(this).parents('.box-body');
        $.get($(this).data('url'), {name: $('input[id$=_name]', cont).val()}, function(data) {
            if(data.content) {
                var cases = {
                    'РД' : 'Rd', 
                    'ДТ' : 'Dt', 
                    'ВН' : 'Vn', 
                    'ТВ' : 'Tv', 
                    'ПР' : 'Pr'
                };
                
                for(key in cases) {
                    if($('input[id$=_name'+cases[key]+']', cont).length && data.content[key]) $('input[id$=_name'+cases[key]+']', cont).val(data.content[key]);
                };
                NProgress.done();
            }
            if(data.errors) {
                $('.js-cases-errors', cont).html(data.errors);
                $('.js-cases-done', cont).html('');
            } else {
                $('.js-cases-errors', cont).html('');
                $('.js-cases-done', cont).html(data.done);
            }
            return false;
        }, 'json');
    });
});
