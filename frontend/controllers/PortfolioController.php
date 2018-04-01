<?php
/**
 * Created by PhpStorm.
 * User: melle
 * Date: 4-11-2017
 * Time: 23:58
 */

namespace frontend\controllers;

use common\models\search\ProjectSearch;
use yii\web\Controller;

class PortfolioController extends Controller
{

    /**
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionIndex(): string
    {
        $projectSearch = new ProjectSearch();
        $projectDataProvider = $projectSearch->search(\Yii::$app->request->queryParams);

        return $this->render('index', compact('projectDataProvider'));
    }

//    /**
//     * @param $title
//     * @return string
//     * @throws \yii\base\InvalidParamException
//     * @throws NotFoundHttpException
//     */
//    public function actionView($title): string
//    {
//        if ($project = Project::findOne(['title' => str_replace('-', ' ', $title)])) {
//            return $this->render('view', ['project' => $project]);
//        }
//
//        throw new NotFoundHttpException(\Yii::t('project', "Project with title '{title}' could not be found",
//            ['title' => Html::encode($title)]));
//    }

}