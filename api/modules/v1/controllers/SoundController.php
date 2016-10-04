<?php
/**
 * Created by PhpStorm.
 * User: melle
 * Date: 4-10-2016
 * Time: 23:10
 */

namespace api\modules\v1\controllers;


use yii\rest\ActiveController;

class SoundController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Sound';
}