<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Sound */

$this->title = Yii::t('common', 'Create {model}',['model'=> Yii::t('sound','Sound')]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('sound', 'Sounds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sound-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
