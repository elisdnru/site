<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

$dirs = scandir(dirname(__FILE__).'/../modules');

$modules = array();
foreach ($dirs as $name){
    if ($name[0] != '.')
        $modules[$name] = array('class'=>'application.modules.' . $name . '.' . ucfirst($name) . 'Module');
}

define('MODULES_MATCHES', implode('|', array_keys($modules)));

return array(

    'basePath'=>dirname(dirname(__FILE__)),
    'name'=>'Site',
    'sourceLanguage'=>'en',
    'language'=>'ru',

    'import'=>array(
        'application.components.*',
        'application.modules.main.components.actions.*',
        'application.modules.main.components.arbehaviors.*',
        'application.modules.main.components.behaviors.*',
        'application.modules.main.components.helpers.*',
        'application.modules.main.components.system.*',
        'application.modules.main.components.widgets.*',
        'application.modules.main.components.*',
        'application.modules.user.components.*',
        'application.modules.user.models.*',
        'application.modules.module.components.DUrlRulesHelper',
    ),

    'modules'=>array_replace($modules, array(
        /*'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'admin',
            'ipFilters'=>array('127.0.0.1','::1'),
        ),*/
    )),

    'components'=>array(

        'urlManager'=>array(
            'class'=>'DUrlManager',
            'urlFormat'=>'path',
            'showScriptName'=>false,
			'useStrictParsing'=>true,
            'urlSuffix'=>'',
            'rules'=>array(
                '<module:' . MODULES_MATCHES . '>/<controller:\w+[Aa]dmin>/<action:\w+>/<id:\d+>'=>'<module>/<controller>/<action>',
                '<module:' . MODULES_MATCHES . '>/<controller:\w+[Aa]dmin>'=>'<module>/<controller>/index',
                '<module:' . MODULES_MATCHES . '>/<controller:\w+[Aa]dmin>/<action:\w+>'=>'<module>/<controller>/<action>',
            ),
        ),

        'user'=>array(
            'class'=>'application.modules.user.components.WebUser',
            'allowAutoLogin'=>true,
            'loginUrl'=>array('/user/default/login'),
        ),

        'clientScript'=>array(
            'scriptMap'=>array(
                'modernizr.js'=>'/core/js/modernizr.min.js',
                'core-site.js'=>'/core/js/core-site.js',
                'core-end.js'=>'/core/js/core-end.js',
                //'jquery.js'=>'http://code.jquery.com/jquery-latest.min.js',
                //'jquery.min.js'=>'http://code.jquery.com/jquery-latest.min.js',
                'jquery.easing.js'=>'/core/js/jquery.easing.js',
                'jquery.mousewheel.js'=>'/core/js/jquery.mousewheel.js',
                'jquery.plugins.js'=>'/core/js/jquery.plugins.js',
                'swfobject.js'=>'/core/js/swfobject.js',
            )
        ),

        'config'=>array(
            'class'=>'application.modules.config.components.DConfig',
            'cache'=>3600,
        ),

        'request'=>array(
            'class'=>'DHttpRequest',
            'baseUrl'=>'',
            'noCsrfValidationUris'=>array(
                '^gallery/galleryAdmin/(upload|checkexists).*$',
                '^file/fileAdmin/(upload|checkexists).*$',
                '^ulogin.*$',
            ),
            'enableCsrfValidation'=>true,
            'enableCookieValidation'=>true,
        ),

        'authManager'=>array(
            'class'=>'application.modules.user.components.PhpAuthManager',
            'defaultRoles'=>array('role_guest'),
        ),

        'moduleManager'=>array(
            'class'=>'application.modules.module.components.DModuleManager',
        ),
        
        'errorHandler'=>array(
            'errorAction'=>'/main/error/index',
        ),

        'session'=>array (
            'class'=>'system.web.CDbHttpSession',
            'sessionTableName'=>'{{session}}',
            'connectionID'=>'db',
            'timeout'=>3600*24*10,
            'autoCreateSessionTable'=>false,
            'cookieParams'=>array(
                'lifetime'=>3600*24*10,
            ),
        ),

        'shopcart'=>array(
            'class'=>'application.modules.shop.components.ShopCart'
        ),

        'image'=>array(
            'class'=>'ext.image.CImageHandler',
        ),

        'file'=>array(
            'class'=>'ext.file.CFile',
        ),

        'uploader'=>array(
            'class'=>'application.modules.uploader.components.DUploadManager',
            'origFileSalt'=>'adFxt0de',
            'rootPath'=>'upload',
            'emptyImage'=>'core/images/nophoto.png',
            'allowedThumbnailResolutions'=>array(
                array('upload/images/news', array(
                    '250x0', // default
                    '200x180', // list
                    '198x180', // greed
                )),
                array('upload/images/users/avatars', array(
                    '200x0', // fishing
                    '100x100',
                    '50x50',
                )),
                array('upload/images/users/galleries', array(
                    '50x50', // fishing
                    '200x0', // fishing
                    '250x0', // admin
                )),
                array('upload/images/shop', array(
                    '250x0', // default
                    '150x150', // admin
                    '50x50', // cart
                )),
                array('upload/images/shop/models', array(
                    '250x0', // default
                    '100x100', // default
                    '150x150', // default
                )),
                array('upload/images/pages', array(
                    '250x0', // default
                )),
            ),
        ),

        'email'=>array(
            'class'=>'ext.email.Email',
            'delivery'=>'php', //'php'|'debug'
        ),

        'mailer'=>array(
            'class'=>'ext.mailer.MyEMailer',
            'pathViews'=>'//email',
            'pathLayouts'=>'//email/layouts'
        ),

        'widgetFactory'=>array(
            'enableSkin'=>true,
        ),

        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>CLogger::LEVEL_ERROR,
                    'logFile'=>'log_error.log',
                ),
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>CLogger::LEVEL_WARNING,
                    'logFile'=>'log_warning.log',
                ),
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>CLogger::LEVEL_INFO,
                    'logFile'=>'log_info.log',
                ),
            ),
        ),

        'cache'=>array(
            'class'=>'system.caching.CDummyCache',
        ),
    ),

    'preload'=>array(
        'log',
    ),

    'behaviors'=> array(
        array(
            'class'=>'application.modules.module.components.DModuleUrlRulesBehavior',
            'beforeCurrentModule'=>array(
                'main',
                'uploader',
                'sitemap',
                'admin',
                'user',
                'ulogin',
            ),
            'afterCurrentModule'=>array(
                'page',
                'new',
            )
        )
    ),

    'params'=>array(
        'runtimeWidgets'=>array(
            'new.widgets.News',
            'new.widgets.LastNews',
            'gallery.widgets.Gallery',
            'page.widgets.SubPages',
            'page.widgets.Page',
            'menu.widgets.Menu',
            'block.widgets.Block',
            'contact.widgets.Contact',
        ),
        'translatedLanguages'=>array(
            'ru'=>'Russian',
        ),
        'defaultLanguage'=>'ru',
    ),
);