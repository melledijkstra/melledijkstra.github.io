<?php

use common\models\Project;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Guide */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="guide-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guide_text')->widget('kartik\markdown\MarkdownEditor',[
        'footerMessage' => false,
        'showExport' => false,
    ]); ?>

    <?= $form->field($model, 'project')->dropDownList(
        Project::find()->select(['title','id'])->indexBy('id')->column(),
        ['prompt' => 'Select Project']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('guide', 'Create') : Yii::t('guide', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
