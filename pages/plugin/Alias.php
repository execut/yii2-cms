<?php
/**
 */

namespace execut\cms\pages\plugin;


use execut\pages\models\FrontendPage;
use execut\alias\Plugin;

class Alias implements Plugin
{
    public function getModels()
    {
        return [
            [
                'modelClass' => FrontendPage::class,
                'order' => 100,
                'route' => 'pages/frontend'
            ],
        ];
    }
}