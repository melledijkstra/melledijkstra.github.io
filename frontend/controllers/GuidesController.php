<?php

namespace frontend\controllers;

use common\models\Guide;
use frontend\components\FrontendController;
use Yii;
use yii\web\NotFoundHttpException;

class GuidesController extends FrontendController
{
    public function actionIndex()
    {
        return $this->render('index', [
            'guides' => Guide::find()->all(),
        ]);
    }

    public function actionView($title)
    {
        if($guide = Guide::findOne(['title' => $title])) {
            return $this->render('view', ['guide' => $guide]);
        } else {
            throw new NotFoundHttpException(Yii::t('guide', 'This guide could not be found'));
        }
    }

}
