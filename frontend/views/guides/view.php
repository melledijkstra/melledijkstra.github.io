<?php

use common\assets\HighLightAsset;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $guide \common\models\Guide */

HighLightAsset::register($this);
$this->registerJs('hljs.initHighlightingOnLoad();', View::POS_READY);

if(!empty($guide->sneak_peek)) {
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $guide->sneak_peek,
    ], 'description');
}

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => implode(' ', array_merge(
            $guide->getCategories()->select('name')->column(),
            [$guide->language ? $guide->language->name : ''])
    )
], 'keywords');

$this->title = $guide->title;

?>
<div id="guide-view-page">
    <div id="guide-view" class="container-fluid">
        <div class="jumbotron">
            <h1 class="guide-title"><?= $guide->title ?></h1>
            <small class="guide-date"><?= Yii::$app->formatter->asDate($guide->created_at, 'medium'); ?> - <?= $guide->createdBy->username; ?></small>
        </div>
        <div class="guide-container">
            <?= $guide->renderGuide(); ?>
        </div>
    </div>
</div>