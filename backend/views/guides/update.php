<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Guide */
/* @var \common\models\Category[] $categories */

$this->title = Yii::t('guide', 'Update {modelClass}', [
    'modelClass' => 'Guide',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('guide', 'Guides'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('guide', 'Update');
?>
<div class="guide-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
    ]) ?>

</div>
