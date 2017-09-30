<?php
/**
 */

namespace execut\cms\alias\plugin;

use execut\navigation\Page;
use yii\db\ActiveQuery;

class Pages implements \execut\pages\Plugin
{
    public function getPageFieldsPlugins() {
        return [
            [
                'class' => \execut\alias\crudFields\Plugin::class,
            ],
        ];
    }

    public function getCacheKeyQueries() {
        return [];
    }

    public function initCurrentNavigationPage(Page $navigationPage, \execut\pages\models\Page $pageModel) {
    }

    public function applyCurrentPageScopes(ActiveQuery $q)
    {
        return $q;
    }
}