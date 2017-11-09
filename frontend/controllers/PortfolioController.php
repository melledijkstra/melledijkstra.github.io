<?php
/**
 * Created by PhpStorm.
 * User: melle
 * Date: 4-11-2017
 * Time: 23:58
 */

namespace frontend\controllers;


use yii\web\Controller;

class PortfolioController extends Controller
{

    public function beforeAction($action)
    {
        //$this->layout = 'portfolio';
        return parent::beforeAction($action);
    }

    public function actionIndex() {
        return $this->render('index');
    }

}