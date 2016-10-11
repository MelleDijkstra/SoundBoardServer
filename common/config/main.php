<?php
Yii::setAlias('@common', dirname(__DIR__));

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'nl-NL',
    'sourceLanguage' => 'en-US',
    'defaultRoute' => 'sound',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
        ],
        'authManager' => [
            'class'        => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest'],
        ],
        'formatter'   => [
            'currencyCode'   => 'EUR',
            'class'          => 'yii\i18n\Formatter',
            'dateFormat'     => 'php:d-m-Y',
            'datetimeFormat' => 'php:d-m-Y H:i:s',
            'timeFormat'     => 'H:mm:ss',
            //'booleanFormat'  => ['Nee', 'Ja'],
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/translations',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'common' => 'common.php',
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                    'on missingTranslation' => ['common\components\TranslationEventHandler', 'handleMissingTranslation'],
                ],
            ]
        ],
    ],
];
