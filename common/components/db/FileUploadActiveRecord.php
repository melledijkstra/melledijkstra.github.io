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
abstract class FileUploadActiveRecord extends MActiveRecord
{

    /**
     * @var array The accepted extensions
     */
    protected static $extensions;

    /**
     * @var bool Specifies if a file needs to be uploaded
     */
    protected $fileRequired = true;

    /**
     * @var string The attribute name to use to reference the name of the file
     */
    protected static $fileAttributeName = 'file_name';

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
    public function beforeValidate(): bool
    {
        // Set the file before validating, so the file is validated
        $this->uploadedFile = UploadedFile::getInstance($this, 'uploadedFile');
        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if (null !== $this->uploadedFile) {
                $this->deleteFile();
                // if directory not exists (file_exists also works on dir)
                if (!file_exists(static::$uploadPath)) {
                    FileHelper::createDirectory(static::$uploadPath);
                }
                $filename = $this->generateFileName($this->uploadedFile);
                if ($this->uploadedFile->saveAs(static::$uploadPath . $filename, true)) {
                    $this->{static::$fileAttributeName} = $filename;
                    return true;
                }
            } elseif (!$insert || !$this->fileRequired) {
                return true;
            }
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        $rules = [
            [['uploadedFile'], 'file', 'extensions' => static::$extensions],
        ];

        if ($this->fileRequired && $this->isNewRecord) {
            $rules[] = [['uploadedFile'], 'required'];
        }

        return array_merge(parent::rules(), $rules);
    }

    public function attributeLabels(): array
    {
        return array_merge(parent::attributeLabels(), [
            'uploadedFile' => Yii::t('files', 'File Upload'),
        ]);
    }

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidParamException
     */
    public function init()
    {
        parent::init();
        static::$uploadPath = Yii::getAlias('@frontend') . '/web/uploads/' . static::tableName() . '/';
    }

    /**
     * Generate a Html link to the file
     * @return string
     */
    public function getHtmlLink(): string
    {
        if (!empty($this->{static::$fileAttributeName})) {
            return Html::a($this->{static::$fileAttributeName}, $this->getPublicLink(), ['target' => '_blank']);
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete(): bool
    {
        if (parent::beforeDelete()) {
            $this->deleteFile();
            return true;
        }
        return false;
    }

    /**
     * Deletes the current file if it exists
     * @return bool Whether the file is deleted or not
     */
    public function deleteFile(): bool
    {
        if (file_exists($this->filePath()) && unlink($this->filePath())) {
            $this->{static::$fileAttributeName} = null;
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
        if (!empty($this->{static::$fileAttributeName}) && file_exists(static::$uploadPath . $this->{static::$fileAttributeName})) {
            return static::$uploadPath . $this->{static::$fileAttributeName};
        }
        return null;
    }

    /**
     * Retrieve public link to the file
     * @param bool $absolute if the link should be absolute
     * @return string
     */
    public function getPublicLink($absolute = false): string
    {
        $url = $absolute ? Url::base(true) : '';
        return $url . '/uploads/' . static::tableName() . '/' . $this->{static::$fileAttributeName};
    }

    /**
     * Generates a file name for the uploaded file
     * @param $uploadedFile
     * @return string The new file name on the server
     */
    protected function generateFileName($uploadedFile): string
    {
        // TODO: this won't work for multiple file, the time would be the same and overwrite previous file
        return time() . /* str_replace(' ', '_', $uploadedFile->baseName) . */
            '.' . $uploadedFile->extension;
    }

    /**
     * Check if current file exists which is linked with this model
     */
    public function fileExists()
    {
        return (!empty($this->{static::$fileAttributeName}) && file_exists(static::$uploadPath . $this->{static::$fileAttributeName}));
    }

    /**
     * Checks if this model has a file name set
     * It does not check if the file exists, use $this->fileExists
     * @see FileUploadActiveRecord::fileExists
     */
    public function hasFile()
    {
        return !empty($this->{static::$fileAttributeName});
    }

}