﻿<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');
Yii::setPathOfAlias('editable', dirname(__FILE__).'/../extensions/x-editable');

Yii::setPathOfAlias('BATIK_PATH', dirname(__FILE__).'/../extensions/highcharts/exporting-server/batik-rasterizer.jar');
Yii::setPathOfAlias('TEMP_PATH', dirname(__FILE__).'/../extensions/highcharts/exporting-server/temp/');
Yii::setPathOfAlias('EXPORT_PATH', dirname(__FILE__).'/../extensions/highcharts/exporting-server/');

return array(
    'theme'=>'bootstrap',
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'โปรแกรมระบบโรงงานรีไซเคิลขวดพลาสติก',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'editable.*' //easy include of editable classes [x-editable extension]
	),
    'language'=>'th', 
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		 'gii'=>array(
                     'class'=>'system.gii.GiiModule',
					'password'=>'meroot',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			//'ipFilters'=>array('127.0.0.1','::1'),
                    'generatorPaths'=>array(
                        'bootstrap.gii','ext.mpgii'
                    ),

        ),
	),
	

	// application components
	'components'=>array(
        //X-editable config
        'editable' => array(
            'class'     => 'editable.EditableConfig',
            'form'      => 'bootstrap',        //form style: 'bootstrap', 'jqueryui', 'plain' 
            'mode'      => 'popup',            //mode: 'popup' or 'inline'  
            'defaults'  => array(              //default settings for all editable elements
               'emptytext' => 'Click to edit'
            )
        ),  
        'word'=>array(

               'class'=>'application.extensions.phpoffice.PhpWord.PhpWord',

        ),
        'clientScript' => array(
	        // disable yiigridview auto include
	        'scriptMap'=>array(
	               'jquery.yiigridview.js'=>false
		    )
		),  
        'format'=>array(
        	'class'=>'application.components.Formatter',
        	'numberFormat'=>array('decimals'=>2, 'decimalSeparator'=>'.', 'thousandSeparator'=>','),
    	),      
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
                        'loginUrl' => array('/site/login'),
                        'class'=>'WebUser',
		),
		
		'bootstrap'=>array(
                    'class'=>'bootstrap.components.Bootstrap',

                ),
		
		// uncomment the following to enable URLs in path-format
                'urlManager'=>array(
                'urlFormat'=>'path',
                'rules'=>array(
                    '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                ),
                'showScriptName'=>false,
                ),


		
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=poontong',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'meroot',
			'charset' => 'utf8',
		),
		// 'db'=>array(
		// 	'connectionString' => 'mysql:host=thai-contractor.com;dbname=u102926510_jk',
		// 	'emulatePrepare' => true,
		// 	'username' => 'u102926510_jk',
		// 	'password' => 'PEAjk2020',
		// 	'charset' => 'utf8',
		// ),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);