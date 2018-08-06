<?php

$script = <<<TINYSCRIPT
$(function() {
    if (\$('.tinymce').length) {
        \$('.tinymce').tinymce({
            // Location of TinyMCE script
            script_url : '$scriptUrl',
            relative_urls : false,
            remove_script_host : true,

            content_css : '$styleUrl',
            language : 'ru',
            elements : 'elm2',
            theme : 'advanced',
            skin : 'o2k7',
            skin_variant : 'silver',

            // General options
            plugins : 'style,table,advhr,advimage,advlink,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,youtube',

            // Theme options
            theme_advanced_buttons1 : 'bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,formatselect,|,cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,preview,|,code',
            theme_advanced_buttons2 : 'undo,redo,|,nonbreaking,|,forecolor,backcolor,|,link,unlink,anchor,image,|,cleanup,|,hr,removeformat,|,sub,sup,|,charmap,iespell,youtube,media,|,fullscreen',
            theme_advanced_buttons3 : '',
            theme_advanced_buttons4 : '',
            theme_advanced_toolbar_location : 'top',
            theme_advanced_toolbar_align : 'left',
            theme_advanced_statusbar_location : 'bottom',
            theme_advanced_resizing : true,

            file_browser_callback : 'tinyBrowser',

            valid_elements: '*[*]',
            invalid_elements: 'script,applet'
        });
    }
});

TINYSCRIPT;

Yii::app()->clientScript->registerScript('tinymce', $script, CClientScript::POS_END);
