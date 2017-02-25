<?php

namespace frontend\controllers;

use common\models\Project;
use frontend\components\FrontendController;
use Yii;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

class ProjectsController extends FrontendController
{
    /**
     * Overview of all Projects
     * @return string
     */
    public function actionIndex()
    {
        $projects = Project::find()->all();
        return $this->render('index',['projects' => $projects]);
    }

    /**
     * The view of a specific Project
     * @param $title string The title of the project to search for
     * @return string The rendered page
     * @throws NotFoundHttpException
     */
    public function actionView($title)
    {
        if($project = Project::findOne(['title' => str_replace('-',' ',$title)])) {
            return $this->render('view', ['project' => $project]);
        } else {
            throw new NotFoundHttpException(Yii::t('project',"Project with title '{title}' could not be found", ['title' => Html::encode($title)]));
        }
    }

}
