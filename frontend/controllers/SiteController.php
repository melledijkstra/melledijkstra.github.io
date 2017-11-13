<?php

namespace frontend\controllers;

use common\models\LoginForm;
use common\models\Project;
use common\models\Subscription;
use frontend\components\FrontendController;
use frontend\models\ContactForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use Yii;
use yii\base\InvalidParamException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends FrontendController
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'add-subscriber' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionAddSubscription()
    {
        if(\Yii::$app->request->isAjax) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $subscription = new Subscription();

            if ($subscription->load(\Yii::$app->request->post()) && $subscription->save()) {
                return ['status' => 'OK', 'message' => 'Hey! Thank you for signing up'];
            }

            return ['status' => 'ERROR', 'message' => $subscription->getFirstError('email')];
        }

        throw new BadRequestHttpException('This page is only for ajax requests');
    }

    public function actionResume() {
        return $this->render('resume');
    }

}
