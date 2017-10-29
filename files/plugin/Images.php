<?php
/**
 */

namespace execut\cms\files\plugin;


use execut\files\models\File;
use execut\images\Plugin;
use Imagine\Filter\Basic\Fill;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\Point;
use yii\base\Event;
use yii\imagine\BaseImage;
use yii\imagine\Image;

class Images implements Plugin
{
    public function __construct()
    {
        Event::on(File::class, File::EVENT_AFTER_VALIDATE, function ($e) {
            $file = $e->sender;
            $this->onBeforeFileSave($file, 'data');
        });
    }

    public function onBeforeFileSave($file, $dataAttribute) {
        $sizes = $this->getSizes();
        foreach ($sizes as $sizeName => $size) {
            $data = $file->$dataAttribute;
            $thumbnailAttributeName = $sizeName;
            if (is_string($data)) {
                $tempFile = tempnam('/tmp', 'temp_');
                file_put_contents($tempFile, $data);
                $data = fopen($tempFile, 'r+');
            }

            if (!empty($size['width'])) {
                $width = $size['width'];
            } else {
                $width = null;
            }

            if (!empty($size['height'])) {
                $height = $size['height'];
            } else {
                $height = null;
            }

            if (!empty($size['mode'])) {
                $mode = $size['mode'];
            } else {
                $mode = ImageInterface::THUMBNAIL_INSET;
            }

            BaseImage::$thumbnailBackgroundAlpha = 0;
            $image = Image::thumbnail($data, $width, $height, $mode);
            $fileName = tempnam(sys_get_temp_dir(), 'test');
            $image->save($fileName, [
                'format' => $file->extension,
            ]);

            $data = fopen($fileName, 'r+');
            $file->$thumbnailAttributeName = $data;
            if (!is_string($file->$dataAttribute)) {
                rewind($file->$dataAttribute);
            }
        }
    }

    public function getAttachedModels()
    {
        return [
            'pages' => File::class,
        ];
    }

    public function getSizes()
    {
        return [
            'size_m' => [
                'width' => 375,
                'mode' => ImageInterface::THUMBNAIL_INSET,
            ],
            'size_s' => [
                'width' => 67,
                'mode' => ImageInterface::THUMBNAIL_INSET,
            ],
        ];
    }
}