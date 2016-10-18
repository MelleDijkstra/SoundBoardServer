<?php
/**
 * Created by PhpStorm.
 * User: melle
 * Date: 4-10-2016
 * Time: 23:10
 */

namespace api\modules\v1\controllers;


use api\modules\v1\models\Sound;
use Yii;
use yii\base\InvalidParamException;
use yii\rest\ActiveController;

class SoundController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Sound';

    public function actionChanges($timestamp) {
        if(!is_numeric($timestamp)) {
            Yii::$app->response->statusCode = 400;
            throw new InvalidParamException("Given timestamp is not a valid timestamp ($timestamp)");
        } else {
            $timestamp = (int) $timestamp;
        }

        return Sound::find()
            ->where(['>=', 'created_at', $timestamp])
            ->orWhere(['>=', 'updated_at', $timestamp])
            ->all();
    }
}