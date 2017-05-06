<?php
/**
 */

namespace execut\cms\seo\plugin;

use execut\pages\models\Page;
use execut\pages\Plugin;
use yii\base\Module;

class Pages implements Plugin
{
    public function getPageFieldsPlugins() {
        return [
            [
                'class' => \execut\seo\crudFields\Plugin::class,
            ]
        ];
    }
}