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

$JS = /** @lang JavaScript */
<<<JS
function previewImg(input) {
    var imgPreview = $(".guide-item-image");
    if(imgPreview.length > 0) {
        imgPreview.remove();
    }
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        var img = $("<img class='guide-item-image center-block img-responsive' alt='guide image'/>");
        $(".guide-item-content").before(img);

        reader.onload = function (e) {
            img.attr("src", e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function setSneakPeek(value) {
    var sneak_peek = $(".guide-item-sneak-peek");
    if(sneak_peek.length > 0) {
        sneak_peek.remove();
    }

    if(value !== "") {
        $(".guide-item-info").after("<p class='guide-item-sneak-peek'>"+value+"</p>");
    }
}

function setCategories(selectedItems) {
    console.log(selectedItems);
    var guideCategories = $(".guide-item-categories");
    
    if(guideCategories.length > 0) {
        guideCategories.remove();
    }
    
    if(selectedItems.length > 0) {
        guideCategories = $("<div class='guide-item-categories'><i class='mdi mdi-tag'></i> <small></small></div>");
        var small = guideCategories.find('small');
        for(var i = 0;i < selectedItems.length;i++) {
            small.append("<div class='label label-primary'>"+selectedItems[i].text+"</div> ");
        }
        $(".guide-item-time").after(guideCategories);
    }
}
JS;

$this->registerJs($JS, \yii\web\View::POS_BEGIN);

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

    <?= $form->field($model, 'guide_text')->widget(MarkdownEditor::className(), [
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
