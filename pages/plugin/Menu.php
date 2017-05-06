<?php
/**
 */

namespace execut\cms\pages\plugin;


use execut\menu\models\Item;
use execut\menu\Plugin;
use execut\pages\models\Page;
use yii\base\Module;

class Menu implements Plugin
{
    public function getItemFieldsPlugins() {
        return [
            [
                'class' => \execut\pages\crudFields\Plugin::class,
            ],
        ];
    }

    public function getUrlByItem(Item $item)
    {
        if (!empty($item->pages_page_id)) {
            return [
                '/pages/frontend',
                'id' => $item->pages_page_id,
            ];
        }
    }

    public function getAttachedModels() {
        return [
            Page::class,
        ];
    }
}