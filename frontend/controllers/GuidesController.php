<?php

namespace frontend\controllers;

use common\models\Guide;
use common\models\GuidesCategory;
use common\models\search\GuideSearch;
use frontend\components\FrontendController;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;

class GuidesController extends FrontendController
{

    /**
     * The guides overview page
     * @return string
     */
    public function actionIndex()
    {
        $guideSearch = new GuideSearch();
        $guideDataProvider = $guideSearch->search(Yii::$app->request->queryParams);
        $guideDataProvider->pagination->pageSize = 30;

        return $this->render('index', [
            'guideSearch' => $guideSearch,
            'guideDataProvider' => $guideDataProvider,
        ]);
    }

    /**
     * Shows a single guide
     * @param $title string The title of the guide to search for
     * @return string
     * @throws NotFoundHttpException When a guide can't be found
     */
    public function actionView($title)
    {
        if ($guide = Guide::findOne(['title' => str_replace('-', ' ', $title)])) {
            return $this->render('view', ['guide' => $guide]);
        } else {
            throw new NotFoundHttpException(Yii::t('guide', 'This guide could not be found'));
        }
    }

    /**
     * Check how many new guides are here since last visit.
     * And updates a cookie accordingly
     * @return int Count of new guides since last visit
     */
    private function checkNewestGuidesCount()
    {
        $last_visit_count = 0;
        // check if user has a cookie with last visit time
        if (Yii::$app->request->cookies->has('last-visit')) {
            // Get the time of latest visit
            $last_visit = (int)Yii::$app->request->cookies->get('last-visit')->value;
            // get the count of all new guides since then
            $last_visit_count = Guide::find()->where(['>', 'created_at', $last_visit])->count();
        }

        // update or create cookie with latest visit
        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'last-visit',
            'value' => time(),
        ]));

        return $last_visit_count;
    }

}
