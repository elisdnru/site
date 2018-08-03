jQuery.fn.grayText = function () {

    return this.each(function () {
        if ($(this).attr('type') == 'password') {
            document.getElementById($(this).attr('id')).setAttribute('type', 'text');
            $(this).data('type', 'password');
        }

        if (!$(this).val()) $(this).val($(this).attr('title'));
        if ($(this).val() == $(this).attr('title')) $(this).css('color', '#fff');

        $(this).focus(function () {
            if ($(this).val() == $(this).attr('title')) {
                $(this).val('');
                $(this).css('color', '#fff');
                if ($(this).data('type') == 'password') {
                    document.getElementById($(this).attr('id')).setAttribute('type', 'password');
                    $(this).focus();
                }
            }
        });

        $(this).blur(function () {
            if ($(this).val() == '') {
                $(this).val($(this).attr('title'));
                $(this).css('color', '#fff');
                if ($(this).data('type') == 'password') {
                    document.getElementById($(this).attr('id')).setAttribute('type', 'text');
                }
            }
        })
    })

};

jQuery.fn.tdRuller = function () {
    return this.each(function () {
        $(this).find('td').hover(function () {
                $(this).parent().find('td').addClass('hover');
            },
            function () {
                $(this).parent().find('td').removeClass('hover');
            });
        $(this).find('td').click(function () {
            $(this).parent().parent().find('td').removeClass('select');
            $(this).parent().find('td').addClass('select');
        })
    })
};

jQuery.fn.doConfirm = function () {
    return this.each(function () {
        $(this).click(function () {
            lbl = $(this).attr('title') ? $(this).attr('title') + '?' : 'Вы уверены?';
            return window.confirm(lbl);
        })
    })
};

jQuery.fn.doConfirm2 = function () {

};