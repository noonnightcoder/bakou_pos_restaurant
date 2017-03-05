<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>Yii::t('app','Bakou POS - Simply the Best'),
        'sourceLanguage' => '00',
        'language' => 'kh',
        'timeZone' => 'Asia/Phnom_Penh',
    
         'aliases' => array(
            // yiistrap configuration 
            'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'), // change this if necessary
             // yiiwheels configuration
            'yiiwheels' => realpath(__DIR__ . '/../extensions/yiiwheels'), // change if necessary 
         ),

	// preloading 'log' component
	'preload'=>array('log',
                         //'bootstrap',
            ),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
                'application.helpers.*', //helper for image extension
                'application.extensions.PasswordHash', // PHPass
                'bootstrap.helpers.TbHtml', //application.extensions.bootstrap.helpers.TbHtml  
                'bootstrap.helpers.TbArray!', //application.extensions.bootstrap.helpers.TbHtml 
                'bootstrap.behaviors.TbWidget', //application.extensions.bootstrap.helpers.TbHtml 
                'bootstrap.components.TbApi', //application.extensions.bootstrap.helpers.TbHtml 
                'bootstrap.widgets.*',
                'application.extensions.EExcelView.*'
	),
        'theme'=>'ace', 
      
	'modules'=>array(
		// uncomment the following to enable the Gii to
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1','192.168.10.1'),
                        'generatorPaths' => array('bootstrap.gii'),
		),
                 // Configure auth extension to use CDbAuthManager schema
                'auth' => array(
                        'strictMode' => true, // when enabled authorization items cannot be assigned children of the same type.
                        'userClass' => 'RbacUser', // the name of the user model class.
                        'userIdColumn' => 'id', // the name of the user id column.
                        'userNameColumn' => 'user_name', // the name of the user name column.
                        'appLayout' => 'application.views.layouts.main', // the layout used by the module.
                        'viewDir' => null, // the path to view files to use with this module.
                ),
                // Configure backup db extension
                'backup'=> array('path' => __DIR__.'/../_backup/'  ), 
	),

	// application components
	'components'=>array(
                /*
                'request'=>array(
                    'enableCsrfValidation'=>true, // Cross-site Request Forgery Prevention 
                    'enableCookieValidation'=>true, //Cookie Attack Prevention
                ),
                 * 
                */
                // yiistrap configuration
		'bootstrap' => array(
                     'class' => 'bootstrap.components.TbApi', 
                ),
                 // yiiwheels configuration
                'yiiwheels' => array(
                    'class' => 'yiiwheels.YiiWheels',   
                ),
                'shoppingCart' => array(
                    'class' => 'ShoppingCart',
                ),
                'orderingCart' => array(
                    'class' => 'OrderingCart',
                ),
                'getsetSession' => array(
                    'class' => 'GetsetSession',
                ),
                'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
                        //'showScriptName'=>false, //http://bit.ly/1exuqQf  LoadModule rewrite_module modules/mod_rewrite.so - D:\wamp\bin\apache\apache2.2.22\conf
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=bakou_restaurant',
			'emulatePrepare' => true,
			'username' => 'homestead',
			'password' => 'secret',
			'charset' => 'utf8mb4',
            'schemaCachingDuration' => 180,
            'initSQLs'=>array(
                    "SET time_zone = '+7:00'" //for my country (Cambodia)
             ),
		),
		'session' => array(
			//'class' => 'CCacheHttpSession',
                        'class' => 'system.web.CDbHttpSession',
                        'connectionID' => 'db',
                        'sessionTableName' => 'sessions',
		),
//		'cache' => array(
//			'class' => 'CApcCache',
//		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
                'cache'=>array(
                    'class'=>'system.caching.CFileCache',
                ),
                'settings'=>array(
                    'class'                 => 'CmsSettings',
                    'cacheComponentId'  => 'cache',
                    'cacheId'           => 'global_website_settings',
                    'cacheTime'         => 84000,
                    'tableName'     => 'settings',
                    'dbComponentId'     => 'db',
                    'createTable'       => true,
                    'dbEngine'      => 'InnoDB',
                ),
                // Auth extension
                 'authManager' => array(
                     'class' => 'CDbAuthManager',
                     'connectionID' => 'db',
                     'behaviors' => array(
                      'auth' => array(
                        'class' => 'auth.components.AuthBehavior',
                        'admins' => array('admin','bar'), // users with full access    
                      ),
                    ),
                 ),
                 'user'=>array(
			// enable cookie-based authentication
			//'allowAutoLogin'=>true,
                        'loginRequiredAjaxResponse' => 'YII_LOGIN_REQUIRED',
                        'class' => 'auth.components.AuthWebUser', 
                        //'authTimeout'=>500,//5 minutes.
                        'behaviors' => array(
                            'auth' => array(
                                'class' => 'auth.components.AuthBehavior',
                                'admins' => array('admin'),
                            ),
                        ),
		 ),
                 'image'=>array(
                    'class'=>'application.extensions.image.CImageComponent',
                      // GD or ImageMagick
                      'driver'=>'GD',
                      // ImageMagick setup path
                      'params'=>array('directory'=>'/opt/local/bin'),
                  ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
        'sale_cancel_status' => '0',
        'sale_complete_status' => '1',
        'sale_suspend_status' => '2',
        'inactive_status' =>  '0',
        'active_status' =>  '1',
        'num_zero' => 0,
        'num_one' => 1,
        'str_zero' => '0',
        'str_one' => '1',
        'str_two' => '2',
        'defaultArchived' => 'false',
    ),
    'catchAllRequest' => file_exists(dirname(__FILE__) . '/.maintenance.php') && !(isset($_COOKIE['secret']) && $_COOKIE['secret'] == "password") ? array('maintenance/index') : null,
);