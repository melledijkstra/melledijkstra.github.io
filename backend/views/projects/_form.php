<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]); ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]); ?>

    <?= $form->field($model, 'size')->dropDownList(\common\models\Project::SIZES); ?>

    <?= $form->field($model, 'uploadedFile')->fileInput(); ?>

    <?= $form->field($model, 'credits')->textInput(); ?>

    <?php
    if (!$model->isNewRecord) {
        echo "<img class='img-responsive thumbnail' style='max-height: 200px;' src='{$model->getPublicLink(true, true)}' />" .
            Html::label(Yii::t('project', 'Delete current file?')) .
            '<br />' .
            Html::checkbox('deleteFile');
    }
    ?>

    <?= $form->field($model, 'external_url')->textInput(['maxlength' => true]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('project', 'Create') : Yii::t('project', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
