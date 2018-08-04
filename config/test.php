<?php

return array_replace_recursive(
    require(__DIR__ . '/common.php'),
    require(__DIR__ . '/common-local.php'),
    require(__DIR__ . '/main.php'),
    require(__DIR__ . '/main-local.php'),
    array(
        'components'=>array(
            'fixture'=>array(
                'class'=>'system.test.CDbFixtureManager',
            ),

            'log'=>array(
                'class'=>'CLogRouter',
                'routes'=>array(
                    array(
                        'class'=>'CFileLogRoute',
                        'levels'=>'error',
                    ),
                ),
            ),
        ),

        'params'=>array(
            'translatedLanguages'=>array(
                'ru'=>'Russian',
                'en'=>'English',
            ),
            'defaultLanguage'=>'ru',
        ),
    ),
    require(__DIR__ . '/test-local.php')
);