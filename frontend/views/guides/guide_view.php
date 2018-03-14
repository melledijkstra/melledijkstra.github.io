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
use yii\helpers\StringHelper;

$cardStyling = $guide->language ? "style='border-bottom: 3px solid {$guide->language->color};'" : '';
$sneakPeekLength = 197; // length 200 - the 3 dots for ellipsis

?>
<div class="grid-item col-xs-12 col-sm-12 col-md-6 col-lg-4">
    <div id="guide-item<?= $guide->id ?>" class="guide-item card margin-10" <?= $cardStyling ?>>
        <?php if ($guide->hasFile()): ?>
            <a href="<?= $guide->getLink(); ?>">
                <div class="trim">
                    <img class="image center-block img-responsive" src="<?= $guide->getPublicLink(true); ?>"
                         alt="guide image"/>
                </div>
            </a>
        <?php endif; ?>
        <div class="card-content">
            <?php if (null !== $guide->language): ?>
                <small class="programming-language-tooltip"
                       style="background-color: <?= $guide->language->color; ?>;"> <?= Html::encode($guide->language->name); ?></small>
            <?php endif; ?>
            <h2 class="title">
                <a data-pjax="0" href="<?= $guide->getLink(); ?>"><?= Html::encode($guide->title); ?></a>
            </h2>
            <div class="info">
                <div class="time">
                    <span class="mdi mdi-clock"></span> <?= Yii::$app->formatter->asDate($guide->created_at,
                        'medium'); ?>
                </div>
                <?php if (count($guide->categories) > 0): ?>
                    <div class="categories">
                        <span class="mdi mdi-tag"></span>
                        <small>
                            <?= implode(', ', $guide->categoryStrings); ?>
                        </small>
                    </div>
                <?php endif; ?>
            </div>
            <?= ($guide->sneak_peek !== null) ? '<p class="sneak-peek">' . Html::encode(StringHelper::truncate($guide->sneak_peek, $sneakPeekLength)) . '</p>' : '' ?>
        </div>
    </div>
</div>