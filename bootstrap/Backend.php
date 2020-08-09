<?php
/**
 */

namespace execut\cms\bootstrap;

use execut\menu\Module;
use execut\navigation\Component;
use execut\yii\Bootstrap;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Backend extends Common
{

    public function getDefaultDepends()
    {
        return ArrayHelper::merge(parent::getDefaultDepends(), [
            'bootstrap' => [
                'goods'=> [
                    'class' => \execut\goods\bootstrap\Backend::class,
                ],
                'alias' => [
                    'class' => \execut\alias\bootstrap\Backend::class,
                ],
                'menu' => [
                    'class' => \execut\menu\bootstrap\Backend::class,
                ],
                'pages' => [
                    'class' => \execut\pages\bootstrap\Backend::class,
                ],
                'settings' => [
                    'class' => \execut\settings\bootstrap\Backend::class,
                ],
                'seo' => [
                    'class' => \execut\seo\bootstrap\Backend::class,
                ],
                'files' => [
                    'class' => \execut\files\bootstrap\Backend::class,
                ],
            ],
        ]);
    }

    public function bootstrap($app)
    {
        parent::bootstrap($app);
        $this->bootstrapNavigation($app);
        $this->initLayout($app);
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
     */
    protected function initLayout($app)
    {
        if ($this->isStandardLayout($app)) {
            $app->layoutPath = '@vendor/execut/yii2-cms/views/layouts';
            $app->layout = 'backend';
        }
    }
}