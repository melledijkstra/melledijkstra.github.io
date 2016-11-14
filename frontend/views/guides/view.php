<?php

use common\assets\HighLightAsset;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $guide \common\models\Guide */

HighLightAsset::register($this);
$this->registerJs('hljs.initHighlightingOnLoad();',View::POS_READY);

$this->title = $guide->title;

?>
<h1 class="text-center"><?= $guide->title ?></h1>
<hr>

<?= $guide->renderGuide(); ?>
