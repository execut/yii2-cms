<?php
/**
 */

namespace execut\cms\bootstrap;

use execut\pagesAlias\pages\Plugin;
use execut\yii\Bootstrap;

class Common extends Bootstrap
{
    public function getDefaultDepends()
    {
        return [
            'bootstrap' => [
//                'goods'=> [
//                    'class' => \execut\goods\bootstrap\Common::class,
//                ],
                'images' => [
                    'class' => \execut\images\bootstrap\Common::class,
                ],
                'seo' => [
                    'class' => \execut\seo\bootstrap\Common::class,
                ],
                'settings' => [
                    'class' => \execut\settings\bootstrap\Common::class,
                ],
                'menu' => [
                    'class' => \execut\menu\bootstrap\Common::class,
                ],
                'pagesAlias' => [
                    'class' => \execut\pagesAlias\bootstrap\Common::class,
                ],
                'pagesSeo' => [
                    'class' => \execut\pagesSeo\bootstrap\Common::class,
                ],
            ],
            'modules' => [
//                'goods' => [
//                    'class' => \execut\goods\Module::class,
//                    'plugins' => [
//                        [
//                            'class' => \execut\goods\plugin\Files::class,
//                        ],
//                        [
//                            'class' => \execut\goods\plugin\Pages::class,
//                        ],
//                    ],
//                ],
                'seo' => [
                    'class' => \execut\seo\Module::class,
                    'plugins' => [
                        [
                            'class' => \execut\seo\plugin\Pages::class,
                        ],
                        [
                            'class' => \execut\seo\plugin\Files::class,
                        ],
                    ],
                ],
                'images' => [
                    'class' => \execut\images\Module::class,
                    'plugins' => [
                        [
                            'class' => \execut\images\plugin\Files::class,
                        ]
                    ],
                ],
                'menu' => [
                    'class' => \execut\menu\Module::class,
                    'plugins' => [
                        [
                            'class' => \execut\menu\plugin\Pages::class,
                        ],
                    ],
                ],
                'pages' => [
                    'class' => \execut\pages\Module::class,
                    'plugins' => [
                        [
                            'class' => \execut\pages\plugin\Seo::class,
                        ],
                        [
                            'class' => Plugin::class,
                        ],
                        [
                            'class' => \execut\pages\plugin\Menu::class,
                        ],
                        [
                            'class' => \execut\pages\plugin\Files::class,
                        ],
                        [
                            'class' => \execut\pages\plugin\Goods::class,
                        ],
                    ],
                ],
                'files' => [
                    'class' => \execut\files\Module::class,
                    'plugins' => [
                        [
                            'class' => \execut\files\plugin\Goods::class,
                        ],
                        [
                            'class' => \execut\files\plugin\Alias::class,
                        ],
                        [
                            'class' => \execut\files\plugin\Pages::class,
                        ],
                        [
                            'class' => \execut\files\plugin\Images::class,
                        ],
                        [
                            'class' => \execut\files\plugin\Seo::class,
                        ],
                    ],
                ],
                'alias' => [
                    'class' => \execut\alias\Module::class,
                    'plugins' => [
                        'pages' => [
                            'class' => \execut\pagesAlias\alias\Plugin::class,
                        ],
                        [
                            'class' => \execut\alias\plugin\Files::class,
                        ],
                        [
                            'class' => \execut\alias\plugin\Images::class,
                        ],
                    ],
                ],
            ],
        ];
    }

    public function bootstrap($app)
    {
        parent::bootstrap($app); // TODO: Change the autogenerated stub
        \yii::setAlias('@execut', '@vendor/execut');
    }

    /**
     * @param $app
     * @return bool
     */
    protected function isStandardLayout($app)
    {
        $result = $app->layoutPath === $app->getViewPath() . DIRECTORY_SEPARATOR . 'layouts' && $app->layout === 'main';
        return $result;
    }
}