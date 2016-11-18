<?php

namespace frontend\controllers;

use common\models\Project;
use frontend\components\FrontendController;
use Yii;
use yii\web\NotFoundHttpException;

class ProjectsController extends FrontendController
{
    public function actionIndex()
    {
        $projects = Project::find()->all();
        return $this->render('index',['projects' => $projects]);
    }

    public function actionView($title)
    {
        if($project = Project::findOne(['title' => $title])) {
            return $this->render('view', ['project' => $project]);
        } else {
            throw new NotFoundHttpException(Yii::t('project',"Project with title '{$title}' could not be found"));
        }
    }

}
