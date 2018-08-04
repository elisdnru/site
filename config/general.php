<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

$dirs = scandir(__DIR__.'/../protected/modules');

$modules = array();
foreach ($dirs as $name){
    if ($name[0] != '.')
        $modules[$name] = array('class'=>'application.modules.' . $name . '.' . ucfirst($name) . 'Module');
}

define('MODULES_MATCHES', implode('|', array_keys($modules)));

return array(

    'basePath'=>dirname(__DIR__).'/protected',
    'runtimePath'=>dirname(__DIR__) . '/runtime',
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
        'application.extensions.cachetagging.Tags',
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
				/*'gii'=>'gii/default/index',
				'gii/<controller:\w+>'=>'gii/<controller>/index',
				'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',*/
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
                'modernizr.js'=>'/js/modernizr.min.js',
                'core-site.js'=>'/js/core-site.js',
                'core-end.js'=>'/js/core-end.js',
                //'jquery.js'=>'http://code.jquery.com/jquery-latest.min.js',
                //'jquery.min.js'=>'http://code.jquery.com/jquery-latest.min.js',
                'jquery.easing.js'=>'/js/jquery.easing.js',
                'jquery.mousewheel.js'=>'/js/jquery.mousewheel.js',
                'jquery.plugins.js'=>'/js/jquery.plugins.js',
                'swfobject.js'=>'/js/swfobject.js',
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
                '^newsgallery/galleryAdmin/(upload|checkexists).*$',
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
            'class'=>'system.web.CHttpSession',
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
            'emptyImage'=>'images/nophoto.png',
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

        'rpcManager'=>array(
            'class'=>'DRPCManager',
        ),

        'widgetFactory'=>array(
            'enableSkin'=>true,
        ),

		'syntaxHighlighter' => array(
			'class'=>'ext.JMSyntaxHighlighter.JMSyntaxHighlighter',
			'theme'=>'Eclipse',
		),

		'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error',
                    'logFile'=>'log_error.log',
                ),
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'warning',
                    'logFile'=>'log_warning.log',
                ),
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'info',
                    'logFile'=>'log_info.log',
                ),
            ),
        ),

        'cache'=>array(
            'class'=>'system.caching.CDummyCache',
            'behaviors'=>array(
                'tagging'=>array(
                    'class'=>'ext.cachetagging.TaggingBehavior',
                ),
            ),
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
            'newsgallery.widgets.NewsGallery',
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

		'minimize_styles' => array(),
		'minimize_scripts' => array(),
    ),
);