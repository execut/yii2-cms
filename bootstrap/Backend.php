<?php
/**
 */

namespace execut\cms\bootstrap;

use execut\menu\Module;
use execut\navigation\Component;
use execut\yii\Bootstrap;
use yii\helpers\Html;

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
                'settings' => [
                    'class' => \execut\settings\bootstrap\Backend::class,
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
                'settings' => [
                    'class' => \execut\settings\Module::class,
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

        $this->bootstrapNavigation($app);
    }

    protected function bootstrapNavigation($app) {
        /**
         * @var Component $navigation
         */
        $navigation = $app->navigation;
        if ($app->user->isGuest) {
            $navigation->addMenuItem(['label' => 'Login', 'url' => ['/site/login']]);
        } else {
            $navigation->addMenuItem(['label' => 'Home', 'url' => ['/']]);
            $navigation->addMenuItem('<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . \Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>');
        }
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