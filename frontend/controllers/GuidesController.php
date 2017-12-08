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
     * @return string|mixed
     * @throws \yii\base\InvalidParamException
     */
    public function actionIndex()
    {
        $guideSearch = new GuideSearch();
        $guideDataProvider = $guideSearch->search(Yii::$app->request->queryParams);
        $guideDataProvider->pagination->pageSize = 30;

        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Learn anything about Science related topics. This is is where I share my latest knowledge and try to guide you through it.',
        ]);

        return $this->render('index', compact('guideSearch', 'guideDataProvider'));
    }

    /**
     * Shows a single guide
     * @param $title string The title of the guide to search for
     * @return string|mixed
     * @throws \yii\base\InvalidParamException
     * @throws NotFoundHttpException When a guide can't be found
     */
    public function actionView($title)
    {
        if ($guide = Guide::findOne(['title' => str_replace('-', ' ', $title)])) {
            return $this->render('view', ['guide' => $guide]);
        }

        throw new NotFoundHttpException(Yii::t('guide', 'This guide could not be found'));
    }

    /**
     * Check how many new guides are here since last visit.
     * And updates a cookie accordingly
     * @return int Count of new guides since last visit
     * @throws \yii\base\InvalidCallException
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
