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

?>
<div class="grid-item col-xs-12 col-sm-6 <?= $classes[$size]; ?>">
    <div class="grid-item-content">
        <a href="<?= $project->getLink(); ?>">
            <div id="project-item<?= $project->id ?>" class="project-item margin-tb-5"
                style="background-image: url('<?= $project->getPublicLink(); ?>');">
                <h3 class="title"><?= $project->title; ?></h3>
            </div>
        </a>
    </div>
</div>
