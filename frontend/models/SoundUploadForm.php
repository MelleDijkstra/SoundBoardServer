<?php
/**
 * Created by PhpStorm.
 * User: Melle Dijkstra
 * Date: 21-8-2016
 * Time: 22:04
 */

namespace frontend\models;


use common\models\Sound;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class SoundUploadForm
 * @package frontend\models
 */
class SoundUploadForm extends Model {

    /**
     * @var $file UploadedFile
     */
    public $soundFile;

    public function rules() {
        return [
            [['soundFile'], 'file', 'extensions' => implode(', ',Sound::$SUPPORTED_EXTENSIONS)],
        ];
    }

    public function attributeLabels() {
        return [
            'soundFile'     => Yii::t('sound', 'Sound File'),
        ];
    }

    public function upload() {
        if($this->validate()) {
            $this->soundFile->saveAs(Yii::getAlias('@uploadPath',true).'/'.$this->soundFile->baseName.'.'.$this->soundFile->extension);
            return true;
        } else {
            return false;
        }
    }

}