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
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * FileUploadActiveRecord has all the functionality to save files for ActiveRecords.
 * @property string $htmlLink
 */
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
    protected static $uploadPath;

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
                if(!file_exists(self::$uploadPath)) {
                    FileHelper::createDirectory(self::$uploadPath);
                }
                $filename = $this->generateFileName($this->uploadedFile);
                if($this->uploadedFile->saveAs(self::$uploadPath.$filename, true)) {
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

        return array_merge(parent::rules(), $rules);
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
        self::$uploadPath = Yii::getAlias('@frontend').'/web/uploads/'.$this->tableName().'/';
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
        if(!empty($this->{$this->fileAttributeName}) && file_exists(self::$uploadPath.$this->{$this->fileAttributeName})) {
            return self::$uploadPath.$this->{$this->fileAttributeName};
        }
        return null;
    }

    /**
     * Retrieve public link to the file
     * @param bool $absolute if the link should be absolute
     * @return string
     */
    public function getPublicLink($absolute = false)
    {
        $url = ($absolute) ? Url::base(true) : '';
        return $url.'/uploads/'.$this->tableName().'/'.$this->{$this->fileAttributeName};
    }

    /**
     * Generates a file name for the uploaded file
     * @param $uploadedFile
     * @return string The new file name on the server
     */
    protected function generateFileName($uploadedFile)
    {
        // TODO: this won't work for multiple file, the time would be the same and overwrite previous file
        return time() . /* str_replace(' ', '_', $uploadedFile->baseName) . */ '.' . $uploadedFile->extension;
    }

    /**
     * Check if current file exists which is linked with this model
     */
    public function fileExists()
    {
        return (!empty($this->{$this->fileAttributeName}) && file_exists(self::$uploadPath.$this->{$this->fileAttributeName}));
    }

    /**
     * Checks if this model has a file name set
     * It does not check if the file exists, use $this->fileExists
     * @see FileUploadActiveRecord::fileExists
     */
    public function hasFile()
    {
        return !empty($this->{$this->fileAttributeName});
    }

}