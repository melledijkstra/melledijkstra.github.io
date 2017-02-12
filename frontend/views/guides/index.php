<?php

/* @var $this yii\web\View */
/* @var $guideSearch \common\models\search\GuideSearch */
/* @var $guideDataProvider \yii\data\ActiveDataProvider */

$this->title = Yii::t('guides', 'Guides');

?>
<div class="container">
    <h1><i class="mdi mdi-book-open-page-variant"></i> <?= Yii::t('guide', 'What\'s new?'); ?></h1>

    <div class="row">
        <?php foreach ($guideDataProvider->models as $guide):
            /** @var $guide \common\models\Guide */
            ?>
            <div class="col col-sm-6">
                <h2 class="guide-title-link"><a href="<?= $guide->getLink(); ?>"><?= $guide->title ?></a></h2>
                <div class="guide-info">
                    <i class="mdi mdi-clock"></i> <?= Yii::$app->formatter->asDate($guide->created_at, 'medium'); ?>
                    <small><?= $guide->renderCategories() ?></small>
                </div>
                <a href="<?= $guide->getLink() ?>">Read more</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>