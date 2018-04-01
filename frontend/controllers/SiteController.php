<?php

namespace frontend\controllers;

use common\models\Subscription;
use frontend\components\FrontendController;
use frontend\models\ContactForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use yii\filters\VerbFilter;
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

    /**
     * Ajax request for adding subscription
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionAddSubscription(): array
    {
        if (\Yii::$app->request->isAjax) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $subscription = new Subscription();

            if ($subscription->load(\Yii::$app->request->post()) && $subscription->save()) {
                return ['status' => 'OK', 'message' => 'Hey! Thank you for signing up'];
            }

            return ['status' => 'ERROR', 'message' => $subscription->getFirstError('email')];
        }

        throw new BadRequestHttpException('This page is only for ajax requests');
    }

    /**
     * Remove subscription
     * @param string $email
     */
    public function actionUnsubscribe(string $email)
    {
        $sub = Subscription::findOne(['email' => $email]);
        if ($sub !== null) {
            try {
                if ($sub->delete()) {
                    echo 'Successfully unsubscribed!';
                } else {
                    echo 'Failed to unsubscribe, is this email correct: ' . $email;
                }
            } catch (\Exception $e) {
                echo "Something went wrong ({$e->getMessage()})";
            }
        } else {
            echo "Subscription with email '$email' is already unsubscribed";
        }
        die;
    }

    public function actionResume()
    {
        return $this->render('resume');
    }

}
