<?php
/**
 */

namespace execut\cms\bootstrap;

use execut\cms\controllers\ImagesController;
use execut\pages\Module;
use execut\yii\Bootstrap;
use yii\console\controllers\MigrateController;
use yii\helpers\ArrayHelper;

class Console extends Common
{
    public function getDefaultDepends()
    {
        return ArrayHelper::merge(parent::getDefaultDepends(), [
            'modules' => [
                'alias' => [
                    'class' => \execut\alias\Module::class,
                    'plugins' => [
                        [
                            'class' => \execut\alias\plugin\Pages::class,
                        ],
                    ],
                ],
            ],
            'bootstrap' => [
                'actions' => [
                    'class' => \execut\actions\Bootstrap::class,
                ],
                'pages' => [
                    'class' => \execut\pages\bootstrap\Console::class,
                ],
                'alias' => [
                    'class' => \execut\alias\bootstrap\Frontend::class,
                ],
                'files' => [
                    'class' => \execut\files\bootstrap\Common::class,
                ],
            ],
        ]);
    }

    public function bootstrap($app)
    {
        parent::bootstrap($app);
        if (empty($app->controllerMap['migrate'])) {
            $app->controllerMap['migrate'] = [];
        }

        $app->controllerMap['migrate'] = ArrayHelper::merge([
            'class' => MigrateController::class,
            'migrationPath' => ['base' => '@app/migrations'],
            'templateFile' => '@vendor/execut/yii2-migration/views/template.php',
        ], $app->controllerMap['migrate']);

        if (empty($app->controllerMap['images'])) {
            $app->controllerMap['images'] = [
                'class' => ImagesController::class
            ];
        }
    }
}