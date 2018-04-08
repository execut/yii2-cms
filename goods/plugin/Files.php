<?php
/**
 */

namespace execut\cms\goods\plugin;


use execut\files\Plugin;
use execut\goods\models\Article;

class Files implements Plugin
{
    public function getFileFieldsPlugins() {
        return [];
    }

    public function getAttachedModels() {
        return [
            'articles' => Article::class,
        ];
    }
    public function getDataColumns() {
        return [];
    }
}