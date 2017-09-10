<?php
/**
 */

namespace execut\cms\pages\plugin;

use execut\navigation\Page;

class Files implements \execut\files\Plugin
{
    public function getFileFieldsPlugins() {
        return [];
    }

    public function getAttachedModels()
    {
        return [
            'pages' => \execut\pages\models\Page::class,
        ];
    }
}