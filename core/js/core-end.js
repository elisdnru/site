jQuery('.graytext').grayText();

jQuery('a[href^="http://"], a[href^="https://"]').attr('target', '_blank');
jQuery('.tdruller').tdRuller();
jQuery('.confirm').doConfirm();

jQuery('.js_hide').hide();

jQuery('span[data-href]').each(function () {
	var span = jQuery(this);
	span.replaceWith(jQuery('<a/>').attr('href', span.data('href')).html(span.html()));
});

jQuery(document).on('click', 'a.ajax_del', function(){
    var t=jQuery(this);
    if (!confirm(t.attr('title')+'?')) return false;

    $.ajax({
        type:'POST',
        url:$(this).attr('href'),
        data:{'YII_CSRF_TOKEN': getCSRFToken()},
        success:function(data) {
            jQuery('#'+t.data('del')).hide(500);
        },
        error:function(XHR) {
            alert(XHR.responseText);
        }
    });

    return false;
});

jQuery(document).on('click', 'a.ajax_load', function(){
    var t=jQuery(this);
    if (!confirm(t.attr('title')+'?')) return false;

    $.ajax({
        type:'POST',
        url:$(this).attr('href'),
        data:{'YII_CSRF_TOKEN': getCSRFToken()},
        success:function(data) {
            jQuery('#'+t.data('load')).html(data);
        },
        error:function(XHR) {
            alert(XHR.responseText);
        }
    });

    return false;
});

jQuery(document).on('click', 'a.ajax_post', function(){
    var t=jQuery(this);
    if (!confirm(t.attr('title')+'?')) return false;

    $.ajax({
        type:'POST',
        url:$(this).attr('href'),
        data:{'YII_CSRF_TOKEN': getCSRFToken()},
        success:function(data) {
            alert('Успешно');
        },
        error:function(XHR) {
            alert(XHR.responseText);
        }
    });

    return false;
});

jQuery('ul.collapsed li:has(li.active)').addClass('sup_active');

jQuery('ul.collapsed > li:has(ul)').prepend($('<div>').addClass('collapse').prepend($('<span>').html('+')));

jQuery('ul.collapsed > li .collapse').click(function(){
    jQuery(this).parent().find('>ul').slideToggle(300);
    return false;
});