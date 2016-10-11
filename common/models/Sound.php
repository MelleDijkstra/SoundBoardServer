<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\validators\FileValidator;
use yii\web\UploadedFile;

/**
 * This is the model class for table "sound".
 *
 * @property integer $id
 * @property string $name
 * @property string $filename
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $createdBy
 * @property User $updatedBy
 *
 * Dynamic Properties
 * @property string $filePath
 * @property string $extension
 *
 */
class Sound extends ActiveRecord
{

    const SUPPORTED_EXTENSIONS = [
        '3gp',
        'mp3',
        'aac',
        'flac',
        'ogg',
        'wav',
    ];

    const MAX_FILESIZE = 1024 * 1024 * 8;

    /**
     * @var $soundFile UploadedFile
     */
    public $soundFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sound';
    }

    public function behaviors() {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name', 'filename'], 'string', 'max' => 255],
            [['soundFile'], 'file', 'extensions' => implode(', ',self::SUPPORTED_EXTENSIONS), 'maxSize' => Sound::MAX_FILESIZE],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('common', 'ID'),
            'name'          => Yii::t('sound', 'Name'),
            'filename'      => Yii::t('sound', 'Filename'),
            'created_by'    => Yii::t('common', 'Created By'),
            'updated_by'    => Yii::t('common', 'Updated By'),
            'created_at'    => Yii::t('common', 'Created At'),
            'updated_at'    => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * Gets the upload path
     * which can be used like src="'.$model->uploadPath.'"
     * @return string
     */
    public function getFilePath() {
        return Yii::getAlias('@soundsPath').'/'.$this->filename;
    }

    /**
     * Check if file exists
     * @return bool
     */
    public function beforeDelete() {
        if(parent::beforeDelete()) {
            $this->deleteFile();
            return true;
        }
        return false;
    }

    /**
     * Returns the extension
     * @return string
     */
    public function getExtension() {
        $parts = explode('.',$this->filename);
        return end($parts);
    }

    /**
     * Generates the filename for the sound file
     * @return string The generated filename
     */
    public function generateFilename() {
        if(!isset($this->filename)) {
            $this->filename = md5(time()).'.'.$this->soundFile->extension;
        }
        return $this->filename;
    }

    /**
     * Overwrites the __get() for filename
     * It generates a filename if not yet exists
     */
    public function getFilename() {
        if(empty($this->filename)) {
            $this->generateFilename();
        }
        return $this->filename;
    }

    /**
     * Deletes the file associated with this sound record
     */
    public function deleteFile() {
        if(!empty($this->filename) && file_exists(Yii::getAlias('@uploadPath').'/'.$this->filename)) {
            return unlink(Yii::getAlias('@uploadPath').'/'.$this->filename);
        }
        return true;
    }

    public function supportedExtensionsForFileInput() {
        $tmp = [];
        foreach(self::SUPPORTED_EXTENSIONS as $sup_ext) {
            $tmp[] = 'audio/'.$sup_ext;
        }
        return implode(',',$tmp);
    }
}