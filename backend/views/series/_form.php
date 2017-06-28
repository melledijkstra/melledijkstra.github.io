<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model common\models\Series
 * @var $form yii\widgets\ActiveForm
 * @var $guides array
 */
?>

<div class="series-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'uploadedFile')->fileInput() ?>
    <?= ($model->hasFile()) ? '<div class="alert alert-warning">Leaving upload empty keeps current image</div>' : '' ?>

    <?= $form->field($model, 'guideIds')->widget(Select2::className(), [
        'data' => $guides,
        // maintain the order because the order is stored in database
        'maintainOrder' => true,
        'theme' => Select2::THEME_BOOTSTRAP,
        'showToggleAll' => false,
        'options' => [
            'multiple' => true,
        ],
        'pluginOptions' => [
            'tags' => false,
        ],
    ])
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('common', 'Create') : Yii::t('common', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
