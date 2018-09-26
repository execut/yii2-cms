<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 9/17/18
 * Time: 2:13 PM
 */

namespace execut\shops\models;

use execut\crudFields\Behavior;
use execut\crudFields\BehaviorStub;
use execut\crudFields\fields\Id;
use execut\crudFields\ModelsHelperTrait;
use yii\db\ActiveRecord;
class Shop extends ActiveRecord
{
    use BehaviorStub, ModelsHelperTrait;
    const MODEL_NAME = '{n,plural,=0{Shop} =1{Shop} other{Shops}}';
    public function behaviors()
    {
        return [
            'fields' => [
                'class' => Behavior::class,
                'fields' => $this->getStandardFields(),
                'plugins' => \yii::$app->getModule('shops')->getShopsFieldsPlugins(),
            ],
        ];
    }

    public static function find()
    {
        return new \execut\shops\models\queries\Shop(self::class);
    }

    public function __toString() {
        return '#' . $this->id;
    }

    public static function tableName()
    {
        return 'shops_shops';
    }
}