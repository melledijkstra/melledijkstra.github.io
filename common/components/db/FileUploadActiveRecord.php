<?php
/**
 * Created by PhpStorm.
 * User: Melle Dijkstra
 * Date: 9-2-2017
 * Time: 02:15
 */

namespace common\components\db;

use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\web\UploadedFile;

abstract class FileUploadActiveRecord extends MActiveRecord {

    /**
     * @var array The accepted extensions
     */
    protected $extensions;

    /**
     * @var bool Specifies if a file needs to be uploaded
     */
    protected $fileRequired = true;

    /**
     * @var string The attribute name to use to reference the name of the file
     */
    protected $fileAttributeName = 'file_name';

    /**
     * @var UploadedFile The uploaded file
     */
    public $uploadedFile;

    /**
     * @var string The upload folder path
     */
    protected static $uploadFolder;

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        // Set the file before validating, so the file is validated
        $this->uploadedFile = UploadedFile::getInstance($this, 'uploadedFile');
        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)) {
            if(!is_null($this->uploadedFile)) {
                $this->deleteFile();
                // if directory not exists (file_exists also works on dir)
                if(!file_exists(self::$uploadFolder)) {
                    FileHelper::createDirectory(self::$uploadFolder);
                }
                $filename = $this->generateFileName($this->uploadedFile);
                if($this->uploadedFile->saveAs(self::$uploadFolder.$filename)) {
                    $this->{$this->fileAttributeName} = $filename;
                    return true;
                }
            } elseif(!$insert || !$this->fileRequired) {
                return true;
            }
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['uploadedFile'], 'file', 'extensions' => $this->extensions],
        ];

        if($this->fileRequired && $this->isNewRecord) $rules[] = [['uploadedFile'], 'required'];

        return array_merge_recursive(parent::rules(), $rules);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'uploadedFile' => Yii::t('files', 'File Upload'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$uploadFolder = Yii::getAlias('@frontend').'/web/uploads/'.$this->tableName().'/';
    }

    /**
     * Generate a Html link to the file
     * @return string
     */
    public function getHtmlLink()
    {
        if (!empty($this->{$this->fileAttributeName})) {
            return Html::a($this->{$this->fileAttributeName}, $this->getPublicLink(), ['target' => '_blank']);
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if(parent::beforeDelete()) {
            $this->deleteFile();
            return true;
        }
        return false;
    }

    /**
     * Deletes the current file if it exists
     * @return bool Whether the file is deleted or not
     */
    public function deleteFile()
    {
        if(file_exists($this->filePath()) && unlink($this->filePath())) {
            $this->{$this->fileAttributeName} = null;
            return true;
        }
        return false;
    }

    /**
     * Retrieve the storage file path of the associated file
     * @return null|string The filepath
     */
    public function filePath()
    {
        if(!empty($this->{$this->fileAttributeName}) && file_exists(self::$uploadFolder.$this->{$this->fileAttributeName})) {
            return self::$uploadFolder.$this->{$this->fileAttributeName};
        }
        return null;
    }

    /**
     * Retrieve public link to the file
     * @return string
     */
    public function getPublicLink()
    {
        return '/uploads/'.$this->tableName().'/'.$this->{$this->fileAttributeName};
    }

    /**
     * Generates a file name for the uploaded file
     * @param $uploadedFile
     * @return string The new file name on the server
     */
    protected function generateFileName($uploadedFile)
    {
        return time() . /* str_replace(' ', '_', $uploadedFile->baseName) . */ '.' . $uploadedFile->extension;
    }

    /**
     * Check if current file exists
     */
    public function fileExists()
    {
        return (!empty($this->{$this->fileAttributeName}) && file_exists(self::$uploadFolder.$this->{$this->fileAttributeName}));
    }
}