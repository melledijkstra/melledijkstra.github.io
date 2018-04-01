<?php
/**
 * @var $this \yii\web\View
 * @var $projectDataProvider \yii\data\ActiveDataProvider
 */

use common\models\Project;
use yii\web\View;

\frontend\assets\MasonryAsset::register($this);

$this->registerJs(<<<JSCRIPT
var grid = $('#grid');
var mason = grid.masonry({
    columnWidth: '.grid-sizer',
    itemSelector: '.grid-item',
    percentPosition: true,
});

grid.imagesLoaded(function() {
    // init Masonry after all images have loaded
    mason.masonry();
});
JSCRIPT
    , View::POS_END);

$this->title = \Yii::t('portfolio', 'Portfolio');

?>
<div class="container-fluid">
    <div class="row">
        <div class="text-center">
            <h1>Portfolio</h1>
        </div>
        <div class="less-gutter" id="grid">
            <div class="grid-sizer col-xs-12 col-sm-6 col-md-4 col-lg-3"></div>
            <?php
            if ($projectDataProvider->count > 0) {
                foreach ($projectDataProvider->models as $project) {
                    /** @var $project Project */
                    if ($project->hasFile()) {
                        echo $this->render('project_view', [
                            'project' => $project,
                        ]);
                    }
                }
            }
            ?>
        </div>
    </div>
</div>