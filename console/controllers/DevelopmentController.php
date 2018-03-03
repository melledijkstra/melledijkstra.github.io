<?php

namespace console\controllers;


use common\models\Guide;
use yii\console\Controller;

class DevelopmentController extends Controller
{

    public function actionTestGuideEmail($guideId, $mailAddress)
    {
        $guide = Guide::findOne($guideId);
        if ($guide !== null) {
            $message = \Yii::$app->mailer->compose('guide-created', [
                'guide' => $guide,
                'recipient' => $mailAddress,
            ])
                ->setTo($mailAddress)
                ->setReplyTo(\Yii::$app->params['adminEmail'])
                ->setFrom(\Yii::$app->params['adminEmail']);

            if ($message->send()) {
                $this->stdout("Mail sent!\n");
            } else {
                $this->stderr("Failed to send mail!\n");
            }
        } else {
            $this->stderr("Guide not found with id $guideId\n");
        }

    }

}