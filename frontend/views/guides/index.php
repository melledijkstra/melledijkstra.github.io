<?php
/* @var $this yii\web\View */
/* @var $guides \common\models\Guide[] */
?>
<h1><?= Yii::t('guide', 'Guides'); ?> <i class="mdi mdi-book-multiple"></i></h1>

<ul>
<?php foreach($guides as $guide): ?>
    <li><h1><?= $guide->title ?></h1><?= $guide->renderCategories() ?></li>
<?php endforeach; ?>
</ul>
