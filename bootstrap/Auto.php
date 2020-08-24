<?php
/**
 */

namespace execut\cms\bootstrap;


use yii\base\BootstrapInterface;
use yii\console\Application;

class Auto implements BootstrapInterface
{
    public function bootstrap($app)
    {
        if (!empty($app->bootstrap['base'])) {
            return;
        }

        $bootstraps = [];
        if ($app instanceof Application) {
            $bootstraps[] = new Console();
        } else if ($app instanceof \yii\web\Application) {
            if ($app->id === 'app-backend') {
                $bootstraps[] = new Backend();
            } else if ($app->id === 'app-frontend') {
                $bootstraps[] = new Frontend();
            } else {
                $bootstraps[] = new Frontend();
                $bootstraps[] = new Backend();
            }
        }

        foreach ($bootstraps as $bootstrap) {
            $bootstrap->bootstrap($app);
        }
    }
}