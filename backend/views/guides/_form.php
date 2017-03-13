<?php

use common\models\Guide;
use common\models\Language;
use common\models\Project;
use kartik\markdown\MarkdownEditor;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Guide */
/* @var $categories common\models\Category[] */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="guide-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sneak_peek')->textarea(['rows' => 3, 'maxlength' => true]) ?>
    <p>It is best to keep descriptions between 150 and 160 characters.</p>

    <?= $form->field($model, 'guide_text')->widget(MarkdownEditor::className(),[
        'footerMessage' => false,
        'showExport' => false,
    ]); ?>

    <?= $form->field($model, 'uploadedFile')->fileInput(); ?>

    <?= $form->field($model, 'language_id')->dropDownList(
        Language::find()->select(['name','id'])->indexBy('id')->column(),
        ['prompt' => 'No specific programming language']
    ) ?>

    <?= $form->field($model, 'category_ids')->widget(Select2::className(), [
            'data' => \yii\helpers\ArrayHelper::map($categories, 'id', 'name'),
            'options' => [
                'multiple' => true,
            ],
            'pluginOptions' => [
                'tags' => true,
            ]
        ])
    ?>

    <?= $form->field($model, 'difficulty')->dropDownList(Guide::difficultyList(),
        ['prompt' => 'Select difficulty']
    ) ?>

    <?= $form->field($model, 'project_id')->dropDownList(
        Project::find()->select(['title','id'])->indexBy('id')->column(),
        ['prompt' => 'Select Project']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('guide', 'Create') : Yii::t('guide', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
