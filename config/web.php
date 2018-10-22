<?php

return array_replace_recursive(
    require(__DIR__ . '/common.php'),
    [
        'components'=>[
            'request'=>[
                'class'=>'DHttpRequest',
                'baseUrl'=>'',
                'noCsrfValidationUris'=>[
                    '^newsgallery/galleryAdmin/(upload|checkexists).*$',
                    '^file/fileAdmin/(upload|checkexists).*$',
                    '^ulogin.*$',
                ],
                'enableCsrfValidation'=>true,
                'enableCookieValidation'=>true,
            ],
            'session'=> [
                'class'=>'system.web.CHttpSession',
                'timeout'=>3600*24*10,
                'cookieParams'=>[
                    'lifetime'=>3600*24*10,
                ],
            ],
        ],
    ]
);
