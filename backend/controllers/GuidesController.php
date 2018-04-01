<?php

namespace backend\controllers;

use backend\components\web\BackendController;
use common\models\Category;
use common\models\Guide;
use common\models\search\GuideSearch;
use common\models\Subscription;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * GuideController implements the CRUD actions for Guide model.
 */
class GuidesController extends BackendController
{
    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ]);
    }

    /**
     * Lists all Guide models.
     * @return mixed
     * @throws \yii\base\InvalidParamException
     */
    public function actionIndex()
    {
        $searchModel = new GuideSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Guide model.
     * @param integer $id
     * @return mixed
     * @throws \yii\base\InvalidParamException
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Guide model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \yii\base\InvalidParamException
     */
    public function actionCreate()
    {
        $model = new Guide();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Mail every subscription that there is a new guide
            $messages = [];
            foreach (Subscription::find()->each() as $subscription) {
                /** @var $subscription Subscription */
                $messages[] = \Yii::$app->mailer->compose('guide-created', [
                    'guide' => $model,
                    'recipient' => $subscription->email,
                ])
                    ->setTo($subscription->email)
                    ->setFrom('dev.melle@gmail.com')
                    ->setReplyTo('dev.melle@gmail.com')
                    ->setSubject("Melle's new guide: {$model->title}");
            }
            $successfullMessages = Yii::$app->mailer->sendMultiple($messages);
            $failedMessages = \count($messages) - $successfullMessages;
            if (\count($messages) === $successfullMessages) {
                \Yii::$app->session->addFlash('success', 'All mails successfully sent!');
            } else {
                \Yii::$app->session->addFlash('danger', "$failedMessages mail(s) failed to send!");
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'categories' => Category::find()->asArray()->all(),
        ]);
    }

    /**
     * Updates an existing Guide model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws \yii\base\InvalidParamException
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'categories' => Category::find()->all(),
        ]);
    }

    /**
     * Deletes an existing Guide model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws \yii\db\StaleObjectException
     * @throws \Exception
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Guide model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Guide the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Guide
    {
        if (($model = Guide::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
