<?php
/**
 */

namespace execut\cms\alias\plugin;

class Pages implements \execut\pages\Plugin
{
    public function getPageFieldsPlugins() {
        return [
            [
                'class' => \execut\alias\crudFields\Plugin::class,
            ],
        ];
    }
}