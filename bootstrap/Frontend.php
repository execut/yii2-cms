<?php
/**
 */

namespace execut\cms\bootstrap;

use execut\cms\pages\plugin\Menu;
use execut\cms\seo\plugin\Pages;
use execut\menu\Module;
use yii\helpers\ArrayHelper;

class Frontend extends Backend
{
    public function getDefaultDepends()
    {
        return ArrayHelper::merge(parent::getDefaultDepends(), [
            'bootstrap' => [
                'settings' => [
                    'class' => \execut\settings\bootstrap\Frontend::class,
                ],
                'menu' => [
                    'class' => \execut\menu\bootstrap\Frontend::class,
                ],
                'pages' => [
                    'class' => \execut\pages\bootstrap\Frontend::class,
                ],
                'alias' => [
                    'class' => \execut\alias\bootstrap\Frontend::class,
                ],
            ],
            'modules' => [
                'alias' => [
                    'class' => \execut\alias\Module::class,
                    'plugins' => [
                        [
                            'class' => \execut\cms\pages\plugin\Alias::class,
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function bootstrap($app)
    {
        if ($this->isStandardLayout($app)) {
            $app->layoutPath = '@vendor/execut/cms/views/layouts';
            $app->layout = 'frontend';
        }

        parent::bootstrap($app);
    }
}