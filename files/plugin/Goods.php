<?php
/**
 */

namespace execut\cms\files\plugin;


use execut\goods\Plugin;

class Goods implements Plugin
{
    public function getArticlesCrudFieldsPlugins()
    {
        return [
            'files' => [
                'class' => \execut\files\crudFields\Plugin::class,
            ],
        ];
    }

    public function getBrandsCrudFieldsPlugins()
    {
        return [];
    }

    public function getGoodsCrudFieldsPlugins()
    {
        return [];
    }

    public function getAttachedModels() {
        return [];
    }
}