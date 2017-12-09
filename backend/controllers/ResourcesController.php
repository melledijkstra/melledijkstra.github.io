<?php
/**
 * Created by PhpStorm.
 * User: melle
 * Date: 16-6-2017
 * Time: 23:17
 */

namespace backend\controllers;


use backend\components\web\BackendController;
use common\components\db\ImageUploadActiveRecord;
use yii\helpers\FileHelper;
use yii\web\HttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class ResourcesController extends BackendController
{

    protected $path;

    protected $pastedImagesFolder = 'guide-images';

    public $defaultAction = 'images';

    public function init()
    {
        $this->path = \Yii::getAlias('@frontend/web/uploads/');
        try {
            FileHelper::createDirectory($this->path . $this->pastedImagesFolder);
        } catch (\Exception $e) {
            \Yii::$app->session->addFlash('danger', $e->getMessage());
        }
        parent::init();
    }

    public function actionImages()
    {
        $fileList = [];
        if (is_dir($this->path)) {
            $extensions = [];
            foreach (ImageUploadActiveRecord::$extensions as $extension) {
                $extensions[] = '*.' . $extension;
            }
            foreach (FileHelper::findFiles($this->path, [
                'only' => $extensions,
                'except' => ['.gitignore'],
            ]) as $file) {
                $split = explode('d/web', FileHelper::normalizePath($file, '/'));
                $file = $split[\count($split) - 1];
                $fileList[] = ['name' => $file];
            }
        }

        return $this->render('images', ['fileList' => $fileList]);
    }

    /**
     * @param $file
     * @return Response
     */
    public function actionDeleteImage($file): Response
    {
        $imagePath = FileHelper::normalizePath($this->path . explode('uploads', $file)[1]);
        if (is_file($imagePath)) {
            unlink($imagePath);
            \Yii::$app->session->addFlash('success', "File $file successfully deleted!");
        } else {
            \Yii::$app->session->addFlash('info', "File $file not found and not deleted!");
        }
        return $this->goBack('/resources');
    }

    /**
     * @throws \RuntimeException
     * @throws HttpException
     * @throws \Exception
     */
    public function actionUploadGuideImage()
    {
        $uploadedFile = UploadedFile::getInstanceByName('pastedImage');
        if ($uploadedFile !== null) {
            $hash = time() . '-' . substr(hash('md5', random_int(1, 100)), 0, 5);
            $filename = "$hash.{$uploadedFile->extension}";
            if ($uploadedFile->saveAs($this->path . $this->pastedImagesFolder . '/' . $filename)) {
                $publicpath = explode('d/web', $this->path)[1] . $this->pastedImagesFolder . '/' . $filename;
                echo \Yii::$app->params['frontendUrl'] . $publicpath;
            } else {
                throw new \RuntimeException('Could not save image');
            }
        } else {
            throw new HttpException(400, 'There is no image file uploaded');
        }
        die;
    }

}