<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Subscription */

$this->title = Yii::t('subscriptions', 'Update {modelClass}: ', [
    'modelClass' => 'Subscription',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('subscriptions', 'Subscriptions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('subscriptions', 'Update');
?>
<div class="subscription-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
