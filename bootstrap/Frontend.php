<?php
/**
 */

namespace execut\cms\bootstrap;

use execut\pages\models\FrontendPage;
use execut\robotsTxt\Bootstrap;
use yii\helpers\ArrayHelper;

class Frontend extends Backend
{
    public function getDefaultDepends()
    {
        return ArrayHelper::merge(parent::getDefaultDepends(), [
            'bootstrap' => [
                'robotsTxt' => [
                    'class' => \execut\robotsTxt\Bootstrap::class,
                ],
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
                    'plugins' => [
                        'pages' => [
                            'modelClass' => FrontendPage::class,
                        ],
                    ]
                ],
            ]
        ]);
    }

    public function bootstrap($app)
    {
        parent::bootstrap($app);
    }
}