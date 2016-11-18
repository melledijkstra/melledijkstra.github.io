<?php
/* @var $this yii\web\View */
/* @var $projects \common\models\Project[] */

$this->title = Yii::t('project','Projects');

?>
<h1><?= $this->title ?></h1>

<div class="row">
    <div class="col-md-2">
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
    <div class="col-sm-12 col-md-10">
        <?php foreach($projects as $project): ?>
            <?= melledijkstra\slideshow\AutoloadExample::widget([
                'view' => '',
            ]); ?>
        <?php endforeach; ?>
    </div>
</div>
