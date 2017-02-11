<?php


/* @var $this yii\web\View */
use yii\helpers\Url;

/* @var $project \common\models\Project */

$this->title = $project->title;

?>
<div class="row">
    <div class="col-sm-10">
        <h1><?= $project->title ?> <small class="badge"><?= Yii::$app->formatter->asDate($project->created_at); ?></small></h1>
    </div>
    <div class="col-sm-2">
        <ul class="">
            <li><b>Related Guides</b></li>
            <?php foreach($project->guides as $guide): ?>
                <li><a href="<?= Url::to('/guides/'.$guide->title) ?>"><?= $guide->title; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>


