<?php

return array_replace_recursive(
    require(__DIR__ . '/common.php'),
    require(__DIR__ . '/common-local.php'),
    array(
        'components'=>array(
            'session'=>array (
                'class'=>'system.web.CHttpSession',
            ),
        ),
    ),
    require(__DIR__ . '/web-local.php')
);
