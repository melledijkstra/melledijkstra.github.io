<?php

namespace frontend\controllers;

use common\models\Category;
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

    public function actionIndex()
    {
        $last_visit_count = 0;
        // check how many new guides are here since last visit
        if(Yii::$app->request->cookies->has('last-visit')) {
            $last_visit = (int)Yii::$app->request->cookies->get('last-visit')->value;
            $last_visit_count = Guide::find()->where(['>', 'created_at', $last_visit])->count();
        } else {
            Yii::$app->response->cookies->add(new Cookie([
                'name' => 'last-visit',
                'value' => time(),
            ]));
        }

        $guideDataProvider = new ActiveDataProvider([
            'query' => Guide::find()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => false
        ]);

        $relations = GuidesCategory::find()->all();

        return $this->render('index', [
            'guideDataProvider' => $guideDataProvider,
            'newest_guide'      => Guide::find()->orderBy(['created_at' => SORT_DESC])->limit(1)->one(),
            'filter'            => 'newest',
            'last_visit_count'  => $last_visit_count,
        ]);
    }

    /**
     * Show all guides per category
     */
    public function actionCategories() {
        $guide_categories = GuidesCategory::find()->all();

        $this->render('guide_category_overview', [
            'guide_categories' => $guide_categories,
        ]);
    }

    /**
     * Shows all guides per language
     */
    public function actionLanguages() {
        $guides = Guide::find()->all();

        $guide_by_language = [];
        foreach ($guides as $guide) {
            /** @var $guide Guide */
            $guide_by_language[$guide->language->name][] = $guide;
        }

        dd($guide_by_language);
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
