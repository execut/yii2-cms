<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 9/17/18
 * Time: 3:59 PM
 */

namespace execut\shops\models\queries;


use yii\db\ActiveQuery;

class Shop extends ActiveQuery
{
    public function isVisible() {
        $class = $this->modelClass;

        return $this->andWhere($class::tableName() . '.visible');
    }
}