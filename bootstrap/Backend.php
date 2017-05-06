<?php
/**
 */

namespace execut\cms\bootstrap;

use execut\menu\Module;
use execut\yii\Bootstrap;
class Backend extends Bootstrap
{
    public function getDefaultDepends()
    {
        return [
            'bootstrap' => [
                'menu' => [
                    'class' => \execut\menu\bootstrap\Backend::class,
                ],
                'pages' => [
                    'class' => \execut\pages\bootstrap\Backend::class,
                ],
            ],
            'modules' => [
                'menu' => [
                    'class' => Module::class,
                    'plugins' => [
                        [
                            'class' => \execut\cms\pages\plugin\Menu::class,
                        ],
                    ],
                ],
                'pages' => [
                    'class' => \execut\pages\Module::class,
                    'plugins' => [
                        [
                            'class' => \execut\cms\seo\plugin\Pages::class,
                        ],
                        [
                            'class' => \execut\cms\alias\plugin\Pages::class,
                        ],
                    ],
                ],
            ],
        ];
    }

    public function bootstrap($app)
    {
        parent::bootstrap($app);
        if ($this->isStandardLayout($app)) {
            $app->layoutPath = '@vendor/execut/cms/views/layouts';
            $app->layout = 'backend';
        }
    }

    /**
     * @param $app
     * @return bool
     */
    protected function isStandardLayout($app): bool
    {
        $result = $app->layoutPath === $app->getViewPath() . DIRECTORY_SEPARATOR . 'layouts' && $app->layout === 'main';
        return $result;
    }
}