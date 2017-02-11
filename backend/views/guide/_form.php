<?php

use common\models\Project;
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

    <?= $form->field($model, 'guide_text')->widget('kartik\markdown\MarkdownEditor',[
        'footerMessage' => false,
        'showExport' => false,
    ]); ?>

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

    <?= $form->field($model, 'project')->dropDownList(
        Project::find()->select(['title','id'])->indexBy('id')->column(),
        ['prompt' => 'Select Project']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('guide', 'Create') : Yii::t('guide', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
