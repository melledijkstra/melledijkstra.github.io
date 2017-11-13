<?php
/**
 * Created by PhpStorm.
 * User: melle
 * Date: 6-6-2017
 * Time: 12:27
 */

namespace common\components\db;

use Imagine\Image\Box;
use yii\imagine\Image;

/**
 * Class ImageUploadActiveRecord
 */
abstract class ImageUploadActiveRecord extends FileUploadActiveRecord
{

    protected $extensions = ['png', 'jpg', 'jpeg', 'gif'];

    protected $fileAttributeName = 'image_file';

    /**
     * @var int The width of the image
     */
    protected $width = 300;

    /**
     * @var int The height of the image
     */
    protected $height = 300;

    /**
     * @param string $filepath The path of the image
     * @param string $newpath (optionally) the new path of the cropped image, if not given the current file is overwritten
     * @throws \Imagine\Exception\RuntimeException
     * @throws \Imagine\Exception\InvalidArgumentException
     */
    protected function convertToThumbnail($filepath, $newpath = null)
    {
        ini_set('memory_limit', '300M');
        // overwrite given file if no new path is given
        if ($newpath === null) {
            $newpath = $filepath;
        }
        Image::getImagine()->open($filepath)->thumbnail(new Box($this->width, $this->height))->save($newpath);
    }

    /**
     * @inheritdoc
     * @throws \Imagine\Exception\InvalidArgumentException
     * @throws \Imagine\Exception\RuntimeException
     */
    public function afterSave($insert, $changedAttributes)
    {
        // check if the image needs to be cropped (when guide is created or $fileAttributeName is updated)
        if ($insert || array_key_exists($this->fileAttributeName, $changedAttributes)) {
            $this->convertToThumbnail($this->filePath());
        }
        parent::afterSave($insert, $changedAttributes);
    }

}