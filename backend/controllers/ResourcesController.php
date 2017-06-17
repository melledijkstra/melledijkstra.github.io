<?php
/**
 * Created by PhpStorm.
 * User: melle
 * Date: 16-6-2017
 * Time: 23:17
 */

namespace backend\controllers;


use backend\components\web\BackendController;
use yii\helpers\FileHelper;
use yii\web\HttpException;
use yii\web\UploadedFile;

class ResourcesController extends BackendController
{

    public $path;

    public $defaultAction = 'images';

    public function init()
    {
        $this->path = \Yii::getAlias('@frontend/web/images/');
        parent::init();
    }

    public function actionImages()
    {
        $fileList = [];
        if (is_dir($this->path)) {
            foreach (FileHelper::findFiles($this->path, ['except' => ['.gitignore']]) as $file) {
                $file = explode('web', FileHelper::normalizePath($file, '/'))[1];
                $fileList[] = ['name' => $file];
            }
        }

        return $this->render('images', ['fileList' => $fileList]);
    }


    public function actionDeleteImage($file)
    {
        $image = FileHelper::normalizePath(explode('images', $this->path)[0] . $file);
        if (is_file($image)) {
            unlink($image);
            \Yii::$app->session->addFlash('success', 'File "' . $file . '" successfully deleted!');
        } else {
            \Yii::$app->session->addFlash('info', 'File "' . $file . '" not found and not deleted!');
        }
        return $this->goBack('/resources');
    }

    public function actionUploadGuideImage()
    {
        $filename = time() . '-' . substr(hash('md5', mt_rand(1, 100)), 0, 5);
        $uploadedFile = UploadedFile::getInstanceByName('pastedImage');
        if ($uploadedFile !== null) {
            $filename .= '.'.$uploadedFile->extension;
            if($uploadedFile->saveAs($this->path . 'guides/' . $filename, true)) {
                $publicpath = explode('web',$this->path)[1].'guides/'.$filename;
                echo \Yii::$app->params['frontendUrl'].$publicpath;
            } else {
                throw new \Exception("Could not save image");
            }
        } else {
            throw new HttpException(400, "There is no image file uploaded");
        }
        die;
    }

}