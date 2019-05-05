<?php
/**
 */

namespace execut\cms\bootstrap;

use execut\pages\models\FrontendPage;
use execut\robotsTxt\Bootstrap;
use yii\helpers\ArrayHelper;

class Frontend extends Common
{
    public function getDefaultDepends()
    {
        return ArrayHelper::merge(parent::getDefaultDepends(), [
            'bootstrap' => [
                'menu' => [
                    'class' => \execut\menu\bootstrap\Frontend::class,
                ],
                'pages' => [
                    'class' => \execut\pages\bootstrap\Frontend::class,
                ],
                'alias' => [
                    'class' => \execut\alias\bootstrap\Frontend::class,
                ],
                'robotsTxt' => [
                    'class' => \execut\robotsTxt\Bootstrap::class,
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
        $this->initLayout($app);
    }

    /**
     * @param $app
     */
    protected function initLayout($app)
    {
        if ($this->isStandardLayout($app)) {
            $app->layoutPath = '@vendor/execut/yii2-cms/views/layouts';
            $app->layout = 'frontend';
        }
    }
}