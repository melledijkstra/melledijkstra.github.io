<?php
/**
 * Created by PhpStorm.
 * User: melle
 * Date: 17-11-2017
 * Time: 22:24
 *
 * @var $this \yii\web\View
 * @var $project \common\models\Project
 * @var $index int
 */

$classes = ['bg-primary', ''];

$class = $classes[$index % 2];
$slanted = '';
if ($index % 4 === 0) {
    $slanted = 'slanted-down';
} else if ($index % 2 === 0) {
    $slanted = 'slanted-up';
}

$this->registerCss(<<<CSS
    .wip-project-item {
        background-position: left bottom -10px;
        background-repeat: no-repeat;
        background-size: 30vw;
    }
CSS
);

?>
<div class="row no-gutter padding-tb-50 wip-project-item <?= $class . ' ' . $slanted ?>"
     style="background-image: url('<?= $project->getPublicLink(); ?>');">
    <div class="col-xs-12">
        <div class="margin-lr-20">
            <h2><?= $project->title; ?></h2>
            <p><?= $project->description; ?></p>
        </div>
    </div>
</div>
