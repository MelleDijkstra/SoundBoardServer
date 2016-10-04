<?php
/**
 * Created by PhpStorm.
 * User: melle
 * Date: 4-10-2016
 * Time: 23:13
 */

namespace api\modules\v1;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'api\modules\v1\controllers';

    public function init()
    {
        parent::init();
    }
}