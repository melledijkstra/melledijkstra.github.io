<?php
/**
 * @var $project \common\models\Project
 */

use yii\helpers\Url;

$this->title = $project->title;

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <h1><?= $project->title ?>
                <small class="badge"><?= \Yii::$app->formatter->asDate($project->created_at); ?></small>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-<?= (count($project->guides) > 0) ? '10' : '12' ?>">
            <img class="img-responsive" src="<?= $project->getPublicLink(); ?>" alt="project image"/>
        </div>
        <?php if (count($project->guides) > 0): ?>
            <div class="col-sm-2">
                <ul class="affix">
                    <li><b>Related Guides</b></li>
                    <?php foreach ($project->guides as $guide): ?>
                        <li><a href="<?= Url::to('/guides/' . $guide->getTitle(true)) ?>"><?= $guide->title; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>
