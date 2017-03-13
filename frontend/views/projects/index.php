<?php
/* @var $this yii\web\View */
use melledijkstra\slideshow\Slideshow;
use yii\bootstrap\Tabs;

/* @var $projects \common\models\Project[] */

$this->title = Yii::t('project', 'Projects');

?>

<div class="text-center">
    <h1 class="portfolio-title">Portfolio</h1>
</div>

<div class="row no-margin no-gutter">
    <?php foreach ($projects as $project): ?>
        <div class="col col-xs-12 col-sm-6 col-md-4 col-lg-3">
            <?= $this->render('project_panel', ['project' => $project]) ?>
        </div>
    <?php endforeach; ?>
</div>
