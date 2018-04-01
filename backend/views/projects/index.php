<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('project', 'Projects');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('project', 'Create Project'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'title',
            [
                'attribute' => 'thumbnail',
                'value' => function ($model) {
                    /** @var $model \common\models\Project */
                    return "<img class='img-responsive' src='{$model->getPublicLink(true, true)}' />";
                },
                'format' => 'html',
            ],
            'sizeString',
            'external_url:url',
            'created_at:date',
            'updated_at:date',
            'createdBy.username',
            'updatedBy.username',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
