<?php

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
        <?= Html::a(Yii::t('guide', 'Create Guide'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'title',
            'filename',
            'project.title',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
