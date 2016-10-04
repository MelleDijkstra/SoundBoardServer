<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\SoundSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('sound', 'Sounds');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sound-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('common', 'Create {model}',['model'=> Yii::t('sound','Sound')]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'filename',
                'value' => function($model) {
                    /** @var $model \common\models\Sound */
                    return '<audio controls="controls"><source src="'.$model->filePath.'" type="audio/'.$model->extension.'"></audio>';
                },
                'format' => 'raw',
            ],
            'created_by',
            'updated_by',
            'created_at:datetime',
            'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
