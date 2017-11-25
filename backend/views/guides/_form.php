<?php

use common\models\Guide;
use common\models\Language;
use common\models\Project;
use kartik\markdown\MarkdownEditor;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model common\models\Guide
 * @var $categories common\models\Category[]
 * @var $form yii\widgets\ActiveForm
 */

$modeldummy = $model;
$modeldummy->created_at = time();

$this->registerJsFile('/js/guide_form.js', ['depends' => \yii\web\JqueryAsset::className()]);

\yii\bootstrap\Modal::begin([
    'header' => '<h3>Paste image upload</h3>',
    'options' => [
        'id' => 'paste-image-modal',
    ]
]);
?>

<div class="margin-tb-20 center-text center-block">
    <img class="center-block" id="uploadImagePreview" src="#" alt="paste upload image preview" />
</div>
<button class="btn btn-primary btn-lg center-block">Upload image and use in guide</button>

<?php
\yii\bootstrap\Modal::end();
?>
<div class="guide-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(
        [
            'maxlength' => true,
            'onchange' => '$(".guide-item-title a").first().text(this.value);',
        ]) ?>

    <?= $form->field($model, 'sneak_peek')->textarea(
        [
            'rows' => 3,
            'maxlength' => true,
            'onchange' => 'setSneakPeek(this.value);',
        ]) ?>
    <p>It is best to keep descriptions between 150 and 160 characters.</p>

    <?= $form->field($model, 'guideText')->widget(MarkdownEditor::className(), [
        'footerMessage' => false,
        'showExport' => false,
    ]); ?>

    <?= $form->field($model, 'uploadedFile')->fileInput([
        'onchange' => 'previewImg(this);',
    ]); ?>

    <?= $form->field($model, 'language_id')->dropDownList(
        Language::find()->select(['name', 'id'])->indexBy('id')->column(),
        ['prompt' => 'No specific programming language']
    ) ?>

    <?= $form->field($model, 'category_ids')->widget(Select2::className(), [
        'data' => \yii\helpers\ArrayHelper::map($categories, 'id', 'name'),
        'options' => [
            'multiple' => true,
        ],
        'pluginOptions' => [
            'tags' => true,
        ],
        'pluginEvents' => [
            'change' => "function() { setCategories($(this).select2('data')); }",
        ]
    ])
    ?>

    <?= $form->field($model, 'difficulty')->dropDownList(Guide::difficultyList(),
        ['prompt' => 'Select difficulty']
    ) ?>

    <?= $form->field($model, 'project_id')->dropDownList(
        Project::find()->select(['title', 'id'])->indexBy('id')->column(),
        ['prompt' => 'Select Project']
    ) ?>

    <h3>Preview</h3>
    <div class="margin-tb-10">
        <?= $this->render('@frontend/views/guides/guide_view', ['guide' => $modeldummy]); ?>
    </div>
    <div class="clearfix"></div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('common', 'Create') : Yii::t('common', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
