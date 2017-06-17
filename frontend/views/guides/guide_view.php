<?php
/**
 * Created by PhpStorm.
 * User: Melle Dijkstra
 * Date: 15-2-2017
 * Time: 14:07
 *
 * @var $this \yii\web\View
 * @var $guide \common\models\Guide
 */
use yii\helpers\Html;

$cardStyling = ($guide->language) ? "style='border-bottom: 3px solid {$guide->language->color};'" : '';

?>
<div class="grid-item col-xs-12 col-sm-12 col-md-6 col-lg-4">
    <div id="guide-item<?= $guide->id ?>" class="guide-item card margin-10" <?= $cardStyling ?>>
        <?php if ($guide->hasFile()): ?>
            <a href="<?= $guide->getLink(); ?>"><img class="guide-item-image center-block img-responsive"
                 src="<?= $guide->getPublicLink(true); ?>" alt="guide image" /></a>
        <?php endif; ?>
        <div class="guide-item-content card-content">
            <?php if (!is_null($guide->language)): ?>
                <small class="programming-language-tooltip"
                       style="background-color: <?= $guide->language->color; ?>;"> <?= Html::encode($guide->language->name); ?></small>
            <?php endif; ?>
            <h2 class="guide-item-title">
                <a data-pjax="0" href="<?= $guide->getLink(); ?>"><?= Html::encode($guide->title); ?></a>
            </h2>
            <div class="guide-item-info">
                <div class="guide-item-time">
                    <span class="mdi mdi-clock"></span> <?= Yii::$app->formatter->asDate($guide->created_at, 'medium'); ?>
                </div>
                <?php if (count($guide->categories) > 0): ?>
                    <div class="guide-item-categories">
                        <span class="mdi mdi-tag"></span>
                        <small><?= $guide->renderCategories(11); ?></small>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (!is_null($guide->sneak_peek)) echo '<p class="guide-item-sneak-peek">' . Html::encode($guide->sneak_peek) . '</p>' ?>
        </div>
    </div>
</div>