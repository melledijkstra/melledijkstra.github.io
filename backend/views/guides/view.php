<?php

use common\assets\HighLightAsset;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Guide */

HighLightAsset::register($this);
$this->registerJs('hljs.initHighlightingOnLoad();',View::POS_READY);

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('guide', 'Guides'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="guide-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('guide', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('guide', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('guide', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php
    try {
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'title',
                'filename',
                [
                    'attribute' => 'project_id',
                    'value' => $model->project ? $model->project->title : null,
                ],
                'thumbnail',
                'language.name',
                'difficulty',
                [
                    'attribute' => 'categoryIds',
                    'value' => function($model) {
                        /** @var $model \common\models\Guide */
                        implode(', ', $model->categoryStrings);
                    },
                    'format' => 'html',
                ],
                'created_at:datetime',
                'updated_at:datetime',
                'createdBy.username',
                'updatedBy.username',
            ],
        ]);
    } catch (Exception $e) {}
    ?>

    <h2><?= Yii::t('guide', 'Preview'); ?></h2>
    <div class="guide-preview">
        <?= $model->renderGuide(); ?>
    </div>

</div>
