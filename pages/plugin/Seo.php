<?php
/**
 */

namespace execut\cms\pages\plugin;


use execut\pages\models\Page;
use execut\seo\Plugin;

class Seo implements Plugin
{
    public function getModels()
    {
        return [
            Page::class,
        ];
    }
}