<?php

use yii\grid\SerialColumn;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\SeriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('series', 'Series');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="series-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('series', 'Create Series'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => SerialColumn::class],

            'id',
            'title',
            [
                'attribute' => 'image',
                'value' => function($model) {
                    /** @var $model \common\models\Series */
                    return $model->getPublicLink(true);
                },
                'format' => 'image'
            ],
            'created_at:datetime',
            'updated_at:datetime',
            // 'created_by',
            // 'updated_by',

            ['class' => ActionColumn::class],
        ],
    ]); ?>
</div>
