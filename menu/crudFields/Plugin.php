<?php
/**
 */

namespace execut\cms\menu\crudFields;


use execut\crudFields\fields\HasManySelect2;
use execut\menu\models\Item;
use execut\menu\models\Menu;
use kartik\detail\DetailView;
use unclead\multipleinput\MultipleInputColumn;
use yii\helpers\Html;
use yii\helpers\Url;

class Plugin extends \execut\crudFields\Plugin
{
    public function getFields() {
        return [
            'createMenu' => [
                'field' => function ($model) {
                    return [
                        'class' => DetailView::INPUT_TEXT,
                        'displayOnly' => true,
                        'label' => 'Menu item',
                        'format' => 'raw',
                        'value' => function () use ($model) {
                            $getParams = [
                                'pages_page_id' => $model->id,
                                'name' => $model->name,
                                'sort' => 10,
                            ];
                            if (Menu::getDefaultId()) {
                                $parentItem = Item::find()->andWhere(['pages_page_id' => $model->pages_page_id, 'menu_menu_id' => Menu::getDefaultId()])->one();
                                $getParams['menu_item_id'] = $parentItem->id;
                            }

                            return Html::a('Create', [
                                '/menu/items/update',
                                'Item' => $getParams,
                            ], ['target' => '_blank']);
                        },
                    ];
                },
                'column' => false,
            ],
//            'menuMenus' => [
//                'class' => HasManySelect2::class,
//                'relation' => 'menuMenus',
//                'url' => [
//                    '/menu/items'
//                ],
//                'viaColumns' => [
//                    'name' => [
//                        'type' => MultipleInputColumn::TYPE_TEXT_INPUT,
//                        'name' => 'name',
//                    ],
//                ],
//            ]
        ];
    }

    public function getRelations()
    {
        return [
            'menuMenus' => [
               'class' => Item::class,
               'name' => 'menuMenus',
               'link' => [
                   'pages_page_id' => 'id',
               ],
               'multiple' => true
            ]
        ];
    }
}