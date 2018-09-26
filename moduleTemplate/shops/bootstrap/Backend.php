<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 9/17/18
 * Time: 1:56 PM
 */

namespace execut\shops\bootstrap;

use execut\crud\navigation\Configurator;
use execut\shops\models\Shop;
use yii\helpers\ArrayHelper;

class Backend extends Common
{
    public function getDefaultDepends()
    {
        return ArrayHelper::merge(parent::getDefaultDepends(), [
            'modules' => [
                'shops' => [
                    'controllerNamespace' => 'execut\shops\backend',
                ],
            ],
        ]);
    }

    public function initNavigation($app)
    {
        parent::initNavigation($app);
        $app->navigation->addConfigurator([
            'class' => Configurator::class,
            'module' => 'shops',
            'moduleName' => 'Shops',
            'modelName' => Shop::MODEL_NAME,
            'controller' => 'shops',
        ]);
    }
}