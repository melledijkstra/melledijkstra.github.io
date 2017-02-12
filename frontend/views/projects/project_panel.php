<?php
/**
 * Created by PhpStorm.
 * User: Melle Dijkstra
 * Date: 26-11-2016
 * Time: 21:52
 * @var $project \common\models\Project
 */
use yii\helpers\Url;

?>
<a href="<?= Url::to(['/projects/'.$project->getTitle(true)]); ?>">
    <div class="project-item" style="background-image: url('<?= $project->getPublicLink(); ?>');">
        <div class="slide-up-desc">
            <h4><?= $project->title ?></h4>
            <p><?= $project->description ?></p>
        </div>
    </div>
</a>
