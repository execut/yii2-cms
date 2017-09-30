<?php
/**
 */

namespace execut\cms\menu\plugin;


use execut\navigation\Page;
use execut\pages\Plugin;
use yii\db\ActiveQuery;
use yii\db\Expression;

class Pages implements Plugin
{
    public function getPageFieldsPlugins()
    {
        return [
            'createMenu' => [
                'class' => \execut\cms\menu\crudFields\Plugin::class,
            ],
        ];
    }

    public function getCacheKeyQueries() {
        return [
            'item' => \execut\menu\models\Item::find()
                ->where('visible')
                ->select([
                    'key' => new Expression('COALESCE(updated,created)')
                ])
                ->orderBy(new Expression('COALESCE(updated,created) DESC'))
                ->limit(1)
        ];
    }

    public function initCurrentNavigationPage(Page $navigationPage, \execut\pages\models\Page $pageModel) {
    }

    public function applyCurrentPageScopes(ActiveQuery $q)
    {
        return $q;
    }
}