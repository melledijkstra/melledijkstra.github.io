<?php

namespace frontend\controllers;

use common\models\Guide;
use common\models\search\GuideSearch;
use frontend\components\FrontendController;
use Yii;
use yii\web\NotFoundHttpException;

class GuidesController extends FrontendController
{
    public function actionIndex()
    {
        $guideSearch = new GuideSearch();

        return $this->render('index', [
            'guideSearch'       => $guideSearch,
            'guideDataProvider' => $guideSearch->search(Yii::$app->request->queryParams),
        ]);
    }

    public function actionView($title)
    {
        if($guide = Guide::findOne(['title' => str_replace('-',' ',$title)])) {
            return $this->render('view', ['guide' => $guide]);
        } else {
            throw new NotFoundHttpException(Yii::t('guide', 'This guide could not be found'));
        }
    }

}
