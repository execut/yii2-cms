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
            'pages/frontend' => FrontendPage::class,
        ];
    }
}