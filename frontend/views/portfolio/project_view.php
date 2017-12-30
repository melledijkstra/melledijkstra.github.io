<?php
/**
 * Created by PhpStorm.
 * User: melle
 * Date: 13-11-2017
 * Time: 15:09
 *
 * @var $project \common\models\Project
 */

$classes = [
    0 => 'col-md-4 col-lg-3 small',     // 'Small'
    1 => 'col-md-8 col-lg-6 large',     // 'Large'
    2 => 'col-md-8 col-lg-6 small',     // 'Landscape'
    3 => 'col-md-4 col-lg-3 large',     // 'Portrait'
];

$size = ($project->size >= count($classes)) ? count($classes) - 1 : $project->size;

$hasUrl = $project->hasUrl();

?>
<div class="grid-item col-xs-12 col-sm-6 <?= $classes[$size]; ?>">
    <div class="grid-item-content">
        <?php if ($hasUrl): ?>
        <a target="_blank" href="<?= $project->externalUrl ?: ''; ?>">
        <?php endif; ?>
            <div id="project-item<?= $project->id ?>" class="project-item margin-tb-10"
                 style="background-image: url('<?= $project->getPublicLink(); ?>');">
                <?php if($project->credits !== null): ?>
                    <p class="credits"><small><span class="mdi mdi-unsplash"></span><?= $project->credits; ?></small></p>
                <?php endif; ?>
                <h3 class="title"><?= $project->title; ?><?= $hasUrl ? ' <i class="mdi mdi-open-in-new"></i>' : ''; ?></h3>
            </div>
        <?php if ($hasUrl): ?>
        </a>
        <?php endif; ?>
    </div>
</div>
