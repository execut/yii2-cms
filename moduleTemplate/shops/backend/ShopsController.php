<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 9/17/18
 * Time: 2:44 PM
 */

namespace execut\shops\backend;


use execut\crud\params\Crud;
use execut\shops\models\Shop;
use yii\filters\AccessControl;
use yii\web\Controller;

class ShopsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['shops_admin'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return \yii::createObject([
            'class' => Crud::class,
            'modelClass' => Shop::class,
            'module' => 'shop',
            'moduleName' => 'Shops',
            'modelName' => Shop::MODEL_NAME,
        ])->actions();
    }
}