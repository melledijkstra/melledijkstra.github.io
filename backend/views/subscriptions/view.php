<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Subscription */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('subscriptions', 'Subscriptions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscription-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('subscriptions', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('subscriptions', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('subscriptions', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'email:email',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
