<?php
/**
 * Created by PhpStorm.
 * User: Melle Dijkstra
 * Date: 15-2-2017
 * Time: 14:07
 *
 * @var $guideDataProvider \yii\data\ActiveDataProvider
 */
?>
<div class="container-fluid">
        <div id="grid">
            <div class="grid-sizer col-xs-12 col-sm-6 col-md-4"></div>
            <?php foreach ($guideDataProvider->models as $guide):
    /** @var $guide \common\models\Guide */
    ?>
    <div class="grid-item col-xs-12 col-sm-6 col-md-4">
        <div class="card margin-10">
            <?php if(!is_null($guide->language)): ?>
                <small class="programming-language-tooltip" style="background-color: <?= $guide->language->color; ?>;"> <?= $guide->language->name; ?></small>
            <?php endif; ?>
            <h2 class="guide-title-link">
                <a href="<?= $guide->getLink(); ?>"><?= $guide->title ?></a>
            </h2>
            <div class="guide-info">
                <i class="mdi mdi-clock"></i> <?= Yii::$app->formatter->asDate($guide->created_at, 'medium'); ?>
                <small><?= $guide->renderCategories() ?></small>
            </div>
            <?php if(!is_null($guide->sneak_peek)) echo "<p>$guide->sneak_peek</p>" ?>
            <a href="<?= $guide->getLink() ?>">Read more</a>
        </div>
    </div>
<?php endforeach; ?>
</div>
</div>