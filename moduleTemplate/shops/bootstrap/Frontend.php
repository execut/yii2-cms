<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 9/17/18
 * Time: 1:56 PM
 */

namespace execut\shops\bootstrap;
use yii\helpers\ArrayHelper;

class Frontend extends Common
{
    public function getDefaultDepends()
    {
        return ArrayHelper::merge(parent::getDefaultDepends(), [
            'modules' => [
                'shops' => [
                    'controllerNamespace' => 'execut\shops\frontend',
                ],
            ],
        ]);
    }
}