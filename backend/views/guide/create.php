<?php

use common\assets\HighLightAsset;
use yii\helpers\Html;
use yii\web\View;


/* @var $this yii\web\View */
/* @var $model common\models\Guide */
/* @var \common\models\Category[] $categories */

HighLightAsset::register($this);
$this->registerJs('hljs.initHighlightingOnLoad();',View::POS_READY);

$this->title = Yii::t('guide', 'Create Guide');
$this->params['breadcrumbs'][] = ['label' => Yii::t('guide', 'Guides'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="guide-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
    ]) ?>

</div>
