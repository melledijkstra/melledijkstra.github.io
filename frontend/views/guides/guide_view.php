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
<div class="grid-item col-xs-12 col-sm-12 col-md-12 col-lg-4">
    <div class="card margin-10" <?= $cardStyling ?>>
        <?php if($guide->hasFile()): ?>
        <img class="img-responsive" src="<?= $guide->getPublicLink(); ?>" />
        <?php endif; ?>
        <div class="card-content">
            <?php if (!is_null($guide->language)): ?>
                <small class="programming-language-tooltip"
                       style="background-color: <?= $guide->language->color; ?>;"> <?= Html::encode($guide->language->name); ?></small>
            <?php endif; ?>
            <h2 class="guide-title-link">
                <a data-pjax="0" href="<?= $guide->getLink(); ?>"><?= Html::encode($guide->title); ?></a>
            </h2>
            <div class="guide-info">
                <i class="mdi mdi-clock"></i> <?= Yii::$app->formatter->asDate($guide->created_at, 'medium'); ?><br />
                <?php if(count($guide->categories) > 0): ?>
                    <i class="mdi mdi-tag"></i> <small><?= $guide->renderCategories(14) ?></small>
                <?php endif; ?>
            </div>
            <?php if (!is_null($guide->sneak_peek)) echo '<p>' . Html::encode($guide->sneak_peek) . '</p>' ?>
            <a href="<?= $guide->getLink() ?>">Read more</a>
        </div>
    </div>
</div>