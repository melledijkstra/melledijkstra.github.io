<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Series */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('series', 'Series'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="series-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('series', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('series', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('series', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>
    
    <div>
        <ol>
            <?php foreach ($model->seriesGuides as $seriesGuide): ?>
                <li><?= $seriesGuide->guide->title ?> <a href="<?= $seriesGuide->guide->getLink(true); ?>">link</a> (<?= $seriesGuide->order ?>)</li>
            <?php endforeach; ?>
        </ol>
    </div>

</div>
