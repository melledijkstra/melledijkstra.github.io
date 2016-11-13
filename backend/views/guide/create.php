<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Guide */

$this->title = Yii::t('guide', 'Create Guide');
$this->params['breadcrumbs'][] = ['label' => Yii::t('guide', 'Guides'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="guide-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
