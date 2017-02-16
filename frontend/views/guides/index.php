<?php

use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $newest_guide \common\models\Guide */
/* @var $guideSearch \common\models\search\GuideSearch */
/* @var $last_visit_count int */
/* @var $filter string */
/* @var $guideDataProvider \yii\data\ActiveDataProvider */

$this->title = Yii::t('guides', 'Guides');

\frontend\assets\MasonryAsset::register($this);

$this->registerJs(<<<JSCRIPT
var mason = $('#grid').masonry({
    columnWidth: '.grid-sizer',
    itemSelector: '.grid-item',
    percentPosition: true,
});
JSCRIPT
, View::POS_END);

?>

<div id="guides-overview-page">
    <div class="jumbotron">
        <a href="<?= $newest_guide->getLink(); ?>">
            <div class="newest-guide-preview center-block">
                <span>Newest guide:</span>
                <h1><?= $newest_guide->title; ?></h1>
                <?php if (!is_null($newest_guide->sneak_peek)): ?>
                    <p><?= $newest_guide->sneak_peek; ?></p>
                <?php endif; ?>
                <?php if (!is_null($newest_guide->language)): ?>
                    <span style="background-color: #<?= $newest_guide->language->color; ?>;"><?= $newest_guide->language->name; ?></span>
                <?php endif; ?>
            </div>
        </a>
    </div>
    <div id="filter-options-navbar">
        <div class="options">
            <a class="<?= ($filter == 'newest') ? 'selected' : '' ?>" href="<?= Url::to(['/guides/newest']); ?>">Newest<?php if ($last_visit_count > 0): ?> <span class="badge" title="New guides since last visit"><?= $last_visit_count; ?></span></a><?php endif; ?>
            <a class="<?= ($filter == 'difficulty') ? 'selected' : '' ?>" href="<?= Url::to(['/guides/difficulty']); ?>">By difficulty</a>
            <a class="<?= ($filter == 'categories') ? 'selected' : '' ?>" href="<?= Url::to(['/guides/categories']); ?>">By categories</a>
        </div>
    </div>
    <?= $this->render('_newest', [
        'guideDataProvider' => $guideDataProvider,
    ]); ?>
</div>