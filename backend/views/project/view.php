<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Project */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('project', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('project', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('project', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('project', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description',
            'thumbnail',
            'external_url:url',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
