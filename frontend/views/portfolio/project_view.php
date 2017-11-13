<?php
/**
 * Created by PhpStorm.
 * User: melle
 * Date: 13-11-2017
 * Time: 15:09
 *
 * @var $project \common\models\Project
 */

?>
<div class="grid-item col-xs-12 col-sm-6 col-md-4 col-lg-3">
    <div id="project-item<?= $project->id ?>" class="project-item card margin-tb-10">
        <?php if ($project->hasFile()): ?>
            <a href="<?= $project->getLink(); ?>">
                <img class="image center-block img-responsive" src="<?= $project->getPublicLink(true); ?>"
                     alt="project image"/>
                <span class="title"><?= $project->title; ?></span>
            </a>
        <?php endif; ?>
    </div>
</div>
