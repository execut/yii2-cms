<?php
/**
 */

namespace execut\cms\files\plugin;


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
                'pattern' => '<id:.*>.<extension:.*>',
                'route' => 'files/frontend',
            ],
        ];
    }
}