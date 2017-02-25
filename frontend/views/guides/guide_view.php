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

?>
<div class="grid-item col-xs-12 col-sm-6 col-md-4 col-lg-3">
    <div class="card margin-10">
        <?php if (!is_null($guide->language)): ?>
            <small class="programming-language-tooltip"
                   style="background-color: <?= $guide->language->color; ?>;"> <?= Html::encode($guide->language->name); ?></small>
        <?php endif; ?>
        <h2 class="guide-title-link">
            <a data-pjax="0" href="<?= $guide->getLink(); ?>"><?= Html::encode($guide->title); ?></a>
        </h2>
        <div class="guide-info">
            <i class="mdi mdi-clock"></i> <?= Yii::$app->formatter->asDate($guide->created_at, 'medium'); ?>
            <small><?= $guide->renderCategories() ?></small>
        </div>
        <?php if (!is_null($guide->sneak_peek)) echo '<p>' . Html::encode($guide->sneak_peek) . '</p>' ?>
        <a href="<?= $guide->getLink() ?>">Read more</a>
    </div>
</div>