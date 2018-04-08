<?php
/**
 */

namespace execut\cms\goods\plugin;


use execut\goods\widget\Good;
use execut\navigation\Page;
use execut\pages\Plugin;
use yii\db\ActiveQuery;

class Pages implements Plugin
{
    public function applyCurrentPageScopes(ActiveQuery $q)
    {
        // TODO: Implement applyCurrentPageScopes() method.
    }

    public function getCacheKeyQueries()
    {
        // TODO: Implement getCacheKeyQueries() method.
    }

    public function getPageFieldsPlugins()
    {
        return [
            'goods' => [
                'class' => \execut\goods\crudFields\Plugin::class,
            ],
        ];
    }

    public function initCurrentNavigationPage(Page $navigationPage, \execut\pages\models\Page $pageModel)
    {
        $good = $pageModel->good;
        if ($good) {
            $navigationPage->setText(Good::widget([
                'description' => $navigationPage->getText(),
                'good' => $good,
            ]));
        }
    }
}