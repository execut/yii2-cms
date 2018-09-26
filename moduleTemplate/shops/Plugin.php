<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 10/23/17
 * Time: 10:14 AM
 */

namespace execut\shops;
use execut\shops\models\Shop;

interface Plugin
{
    public function getShopsFieldsPlugins();
    public function getNavigationPageByShopModel(Shop $model);
}