<?php
/* @var $this yii\web\View */
use melledijkstra\slideshow\Slideshow;
use yii\bootstrap\Tabs;

/* @var $projects \common\models\Project[] */

$this->title = Yii::t('project','Projects');

?>
<h1><?= Yii::t('portfolio', 'My Portfolio'); ?></h1>

<div class="row">
    <div class="col-sm-2 hidden-xs">
        <!-- Navigation -->
        <ul class="list-unstyled">
            <li><a class="btn btn-primary" href="/projects"><span class="glyphicon glyphicon-bookmark"></span> Projects</a></li>
            <li><a class="btn btn-primary" href="/guides"><span class="glyphicon glyphicon-book"></span> Guides</a></li>
            <li><a class="btn btn-primary" href="/guides"><span class="glyphicon glyphicon-book"></span> Guides</a></li>
            <li><a class="btn btn-primary" href="/guides"><span class="glyphicon glyphicon-book"></span> Guides</a></li>
            <li><a class="btn btn-primary" href="/guides"><span class="glyphicon glyphicon-book"></span> Guides</a></li>
        </ul>
        <!-- Social Links -->
    </div>
    <div class="col-xs-12 col-sm-10">
        <?php
        $items = [];
        foreach ($projects as $project) {
            $items[]['content'] = $this->render('project_slide', ['project' => $project]);
        }

        echo Slideshow::widget([
            'items' => $items,
            'clientOptions' => [
                'speed' => 150,
                'slidesPerView' => 'auto'
            ],
        ]); ?>

        <?= Tabs::widget([
            'items' => [],
            'options' => ['henkie' => ['whut' => ['evendeeper']]]
        ]); ?>
    </div>
</div>
