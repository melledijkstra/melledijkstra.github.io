<?php
/* @var $this yii\web\View */
use melledijkstra\slideshow\Slideshow;
use yii\bootstrap\Tabs;

/* @var $projects \common\models\Project[] */

$this->title = Yii::t('project', 'Projects');

?>
<div>
    <h1><?= Yii::t('portfolio', 'My Portfolio'); ?></h1>

    <div class="row">
        <div class="col-sm-2 hidden-xs">
            <!-- Navigation -->
            <ul class="list-unstyled">
                <li><a class="btn btn-block btn-primary" href="/projects"><span
                                class="mdi mdi-ruler"></span> Projects</a></li>
                <li><a class="btn btn-block btn-primary" href="/guides"><span class="mdi mdi-book-multiple"></span>
                        Guides</a></li>
            </ul>
            <!-- Social Links -->
        </div>
        <div class="col-xs-12 col-sm-10">
            <div class="row">
                <?php foreach ($projects as $project): ?>
                    <div class="col col-sm-12 col-md-4 col-lg-3">
                        <?= $this->render('project_panel', ['project' => $project]) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
