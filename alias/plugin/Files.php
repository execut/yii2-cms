<?php
/**
 */

namespace execut\cms\alias\plugin;

use execut\navigation\Page;

class Files implements \execut\files\Plugin
{
    public function getFileFieldsPlugins() {
        return [
            [
                'class' => \execut\alias\crudFields\Plugin::class,
            ],
        ];
    }

    public function getAttachedModels()
    {
        return [];
    }
}