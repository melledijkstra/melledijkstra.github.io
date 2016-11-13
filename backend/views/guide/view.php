<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Guide */

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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'filename',
            [
                'attribute' => 'guide_text',
                'value'     => $model->getGuide(),
                'format'    => 'raw',
            ],
            'project',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
