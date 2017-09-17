<?php
/**
 */

namespace execut\cms\pages\plugin;


use execut\pages\models\FrontendPage;
use execut\alias\Plugin;
use execut\pages\models\Page;

class Alias implements Plugin
{
    public $modelClass = Page::class;
    public function getModels()
    {
        return [
            [
                'modelClass' => $this->modelClass,
                'order' => 100,
                'route' => 'pages/frontend'
            ],
        ];
    }
}