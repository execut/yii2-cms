<?php
/**
 */

namespace execut\cms\images\plugin;


use execut\files\models\File;
use execut\pages\models\FrontendPage;
use execut\alias\Plugin;

class Alias implements Plugin
{
    public function getModels()
    {
        return [
            [
                'modelClass' => File::class,
                'order' => 0,
                'pattern' => '<id:.*>-<dataAttribute:.*>.<extension:.*>',
                'route' => 'images/frontend',
            ],
        ];
    }
}