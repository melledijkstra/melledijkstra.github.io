<?php
/* @var $this yii\web\View */
use melledijkstra\slideshow\Slideshow;
use yii\bootstrap\Tabs;

/* @var $projects \common\models\Project[] */

$this->title = Yii::t('project', 'Projects');

?>
<div class="container">
    <h1><?= Yii::t('portfolio', 'My Portfolio'); ?></h1>

    <div class="row">
        <?php foreach ($projects as $project): ?>
            <div class="col col-sm-12 col-md-4 col-lg-3">
                <?= $this->render('project_panel', ['project' => $project]) ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
