<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Sound */

$this->title = Yii::t('common', 'Update {model}', ['model' => Yii::t('sound','Sound')]) .': '. $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('sound', 'Sounds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="sound-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
