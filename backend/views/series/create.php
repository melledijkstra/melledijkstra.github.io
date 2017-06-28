<?php

use yii\helpers\Html;


/**
 * @var $this yii\web\View
 * @var $model common\models\Series
 * @var $guides array
 */

$this->title = Yii::t('common', 'Create {modelClass}', ['modelClass' => Yii::t('series', 'Series')]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('series', 'Series'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="series-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'guides' => $guides,
    ]) ?>

</div>
