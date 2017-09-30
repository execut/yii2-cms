<?php
/**
 */

namespace execut\cms\images\plugin;


use execut\files\Plugin;

class Files implements Plugin
{
    public function getFileFieldsPlugins() {
        return [
            [
                'class' => \execut\images\crudFields\Plugin::class,
            ],
        ];
    }

    public function getAttachedModels()
    {
        return [];
    }

    public function getDataColumns()
    {
        return array_keys(\yii::$app->getModule('images')->getSizes());
    }
}