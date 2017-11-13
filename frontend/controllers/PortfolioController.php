<?php
/**
 * Created by PhpStorm.
 * User: melle
 * Date: 4-11-2017
 * Time: 23:58
 */

namespace frontend\controllers;

use common\models\Project;
use common\models\search\ProjectSearch;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PortfolioController extends Controller
{

    public function actionIndex() {

        $projectSearch = new ProjectSearch();
        $projectDataProvider = $projectSearch->search(\Yii::$app->request->queryParams);

        return $this->render('index', compact('projectDataProvider'));
    }

    public function actionView($title) {
        if($project = Project::findOne(['title' => str_replace('-',' ',$title)])) {
            return $this->render('view', ['project' => $project]);
        }

        throw new NotFoundHttpException(\Yii::t('project',"Project with title '{title}' could not be found", ['title' => Html::encode($title)]));
    }

}