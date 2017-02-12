<?php

use common\assets\HighLightAsset;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $guide \common\models\Guide */

HighLightAsset::register($this);
$this->registerJs('hljs.initHighlightingOnLoad();', View::POS_READY);

$this->title = $guide->title;

?>
<div class="container">
    <div class="guide-view">
        <div class="guide-header">
            <small class="guide-date"><?= Yii::$app->formatter->asDate($guide->created_at, 'medium'); ?> - <?= $guide->createdBy->username; ?></small>
            <h1 class="guide-title"><?= $guide->title ?></h1>
        </div>
        <div class="guide-container">
            <?= $guide->renderGuide(); ?>
        </div>
    </div>
</div>