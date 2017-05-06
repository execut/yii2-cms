<?php
/**
 */

namespace execut\cms\pages\plugin;


use execut\pages\models\Page;
use execut\alias\Plugin;

class Alias implements Plugin
{
    public function getModels()
    {
        return [
            'pages/frontend' => Page::class,
        ];
    }
}