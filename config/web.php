<?php

return array_replace_recursive(
    require(__DIR__ . '/common.php'),
    require(__DIR__ . '/common-local.php'),
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
            ],
        ],
    ],
    require(__DIR__ . '/web-local.php')
);
