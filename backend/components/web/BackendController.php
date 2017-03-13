<?php
/**
 * Created by PhpStorm.
 * User: melle
 * Date: 13-11-2016
 * Time: 16:37
 */

namespace backend\components\web;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class BackendController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

}