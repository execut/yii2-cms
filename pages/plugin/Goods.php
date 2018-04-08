<?php
/**
 */

namespace execut\cms\pages\plugin;


use execut\goods\Plugin;
use execut\pages\models\Page;

class Goods implements Plugin
{
    public function getArticlesCrudFieldsPlugins() {
        return [];
    }
    public function getGoodsCrudFieldsPlugins() {
        return [];
    }
    public function getBrandsCrudFieldsPlugins() {
        return [];
    }
    public function getAttachedModels()
    {
        return [
            'pages' => Page::class,
        ];
    }
}