<?php
/**
 * Created by PhpStorm.
 * User: melle
 * Date: 4-10-2016
 * Time: 23:07
 */

namespace api\modules\v1\models;


class Sound extends \common\models\Sound
{

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();

        unset($fields['created_by']);
        unset($fields['updated_by']);
        // Make sure we have a file
        if (!empty($this->filename))
        {
            $fields['download_link'] = 'downloadLink';
        }

        return $fields;
    }

    /**
     * Gets the download link
     */
    public function getDownloadLink() {
        return \Yii::getAlias('@uploadWeb').'/'.$this->filename;
    }

}