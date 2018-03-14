<?php

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\GuideSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('guide', 'Guides');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="guide-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('common', 'Create {modelClass}', ['modelClass' => Yii::t('guide', 'Guide')]), ['create'],
            ['class' => 'btn btn-success']) ?>
    </p>
    <?=
    /** @noinspection PhpUnhandledExceptionInspection */
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'title',
                'value' => function ($model, $key, $index, $column) {
                    /** @var $model \common\models\Guide */
                    return \yii\helpers\StringHelper::truncate($model->title, 30);
                },
            ],
            [
                'attribute' => 'project',
                'value' => 'project.title',
            ],
            [
                'header' => 'Language name',
                'value' => 'language.name',
            ],
            'createdBy.username',
            'updatedBy.username',
            'created_at:date',
            'updated_at:date',

            ['class' => ActionColumn::class],
        ],
    ]); ?>
</div>
