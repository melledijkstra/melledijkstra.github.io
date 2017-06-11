<?php

use common\models\Category;
use common\models\Guide;
use common\models\Language;
use common\models\Project;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $newest_guide Guide */
/* @var $guideSearch \common\models\search\GuideSearch */
/* @var $last_visit_count int */
/* @var $filter string */
/* @var $guideDataProvider \yii\data\ActiveDataProvider */

$this->title = Yii::t('guides', 'Guides');

if (Yii::$app->request->isAjax && isset(Yii::$app->params['titleSuffix'])) {
    $this->title .= Yii::$app->params['titleSuffix'];
}

\frontend\assets\MasonryAsset::register($this);

// let bots know there also is a feed
$this->registerLinkTag([
    'href' => '/feed/atom',
    'type' => 'application/atom+xml',
    'rel' => 'alternate',
], 'feed');

$this->registerJs("$('#page-loader-wrap').fadeOut(500);",View::POS_LOAD);

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

// refresh the masonry layout when the guides are updated with pjax
$(document).on('pjax:success', function() {
    mason = $('#grid').masonry({
        columnWidth: '.grid-sizer',
        itemSelector: '.grid-item',
        percentPosition: true
    });
});

$(document).on('pjax:start', function() { $('#guide-loader-wrap').show(); });
$(document).on('pjax:end', function() { $('#guide-loader-wrap').hide(); });
JSCRIPT
    , View::POS_END);

$this->registerCss('
@media (max-width: 992px) {
    .affix {
        position: static !important;
        margin-bottom: 40px;
    }
}');

?>
<div id="page-loader-wrap">
    <div class="loader"></div>
</div>
<div id="guides-overview-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col col-xs-12 col-md-9">
                <?php Pjax::begin([
                    'timeout' => false,
                    'enablePushState' => true,
                    'id' => 'update-view',
                    'formSelector' => '#guide-filter-form',
                    'submitEvent' => 'submit'
                ]); ?>
                <div class="no-gutter" id="grid">
                    <div class="grid-sizer col-xs-12 col-sm-12 col-md-6 col-lg-4"></div>
                    <?php
                    if ($guideDataProvider->count > 0) {
                        foreach ($guideDataProvider->models as $guide) {
                            /** @var $guide Guide */
                            echo $this->render('guide_view', [
                                'guide' => $guide,
                            ]);
                        }
                    } else {
                        echo $this->render('empty_guides');
                    }
                    ?>
                </div>
                <?= \yii\widgets\LinkPager::widget([
                    'activePageCssClass' => 'link-pager-active',
                    'nextPageCssClass' => 'link-pager-next-page',
                    'prevPageCssClass' => 'link-pager-prev-page',
                    'pagination' => $guideDataProvider->pagination
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
            <div class="col col-xs-12 col-md-3">
                <div class="affix">
                    <h3>Search guides</h3>

                    <?php $form = ActiveForm::begin([
                        'action' => '/guides',
                        'options' => ['data' => ['pjax' => true]],
                        'id' => 'guide-filter-form',
                        'method' => 'get',
                    ]); ?>

                    <?= $form->field($guideSearch, 'content') ?>

                    <?= $form->field($guideSearch, 'difficulty')->dropDownList(Guide::difficultyList(),
                        ['prompt' => 'Select Difficulty']) ?>

                    <? //= $form->field($guideSearch, 'duration')->dropDownList(Guide::durationList(), ['prompt' => 'Select Duration']) ?>

                    <?= $form->field($guideSearch,
                        'project_id')->dropDownList(ArrayHelper::map(Project::find()->select([
                        'id',
                        'title'
                    ])->asArray()->all(), 'id', 'title'), ['prompt' => 'Select Project']) ?>

                    <?= $form->field($guideSearch,
                        'category_id')->dropDownList(ArrayHelper::map(Category::find()->select([
                        'id',
                        'name'
                    ])->asArray()->all(), 'id', 'name'), ['prompt' => 'Select Category']); ?>

                    <?= $form->field($guideSearch,
                        'language_id')->dropDownList(ArrayHelper::map(Language::find()->select([
                        'id',
                        'name'
                    ])->asArray()->all(), 'id', 'name'), ['prompt' => 'Select Language']); ?>

                    <?= Html::submitButton('Search', ['class' => 'btn btn-block btn-primary']); ?>

                    <div class="margin-tb-10" id="guide-loader-wrap">
                        <div class="loader"></div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>