<?php

use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var $projects \yii\data\ActiveDataProvider
 * @var $guides \yii\data\ActiveDataProvider
 */

$this->title = 'Dashboard';

?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="row">
    <div class="col col-sm-12 col-md-6">
        <a target="_blank" href="https://<?= \Yii::$app->params['disqusId'] ?>.disqus.com/admin/"><i
                    class="mdi mdi-disqus"></i> Disqus Administration</a>
    </div>
    <div class="col col-sm-12 col-md-6"></div>
</div>
<div class="row">
    <div class="col col-sm-12 col-md-6">
        <h2>Guides</h2>
        <?= $guides->count; ?> Guides <span class="mdi mdi-book-open-variant"></span>
    </div>
    <div class="col col-sm-12 col-md-6">
        <h2>Projects</h2>
        <?= $projects->count; ?> Projects <span class="mdi mdi-book-open"></span>
    </div>
</div>