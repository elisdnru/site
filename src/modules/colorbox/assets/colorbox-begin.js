
function fancy_init()
{
    jQuery('a.group').colorbox({
        'rel': 'group',
        'initialWidth': 200,
        'initialHeight': 120,
        'maxWidth': '100%',
        'maxHeight': '100%',
        'opacity': 0.1
    });

    jQuery('a.lightbox').colorbox({
        'initialWidth': 200,
        'initialHeight': 120,
        'maxWidth': '100%',
        'maxHeight': '100%',
        'opacity': 0.1
    });

    jQuery('a.fancydiv').colorbox({
        'initialWidth': 200,
        'initialHeight': 120,
        inline: true,
        'opacity': 0.1
    });

    jQuery("a.iframe").colorbox({
        'initialWidth': 200,
        'initialHeight': 120,
        'innerWidth': 780,
        'innerHight': 535,
        'opacity': 0.1,
        'iframe': true
    });
}


