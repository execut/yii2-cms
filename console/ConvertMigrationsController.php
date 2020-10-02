<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 5/27/19
 * Time: 1:46 PM
 */

namespace execut\cms\console;


use yii\console\Controller;

class ConvertMigrationsController extends Controller
{
    public function actionIndex() {
        $convertedList = [
            'm140101_100000_dynagrid' => 'kartik\dynagrid\migrations\m140101_100000_dynagrid',
            'm170401_190746_createBaseTable' => 'execut\pages\migrations\m170401_190746_createBaseTable',
            'm170402_192559_initalStructure' => 'execut\menu\migrations\m170402_192559_initalStructure',
            'm170501_182316_initialStructure' => 'execut\settings\migrations\m170501_182316_initialStructure',
            'm170514_165149_addSortToItems' => 'execut\menu\migrations\m170514_165149_addSortToItems',
            'm170829_010636_addMenuDefaultValue' => 'execut\menu\migrations\m170829_010636_addMenuDefaultValue',
            'm170829_151236_addKeywordsToModules' => 'execut\seo\migrations\m170829_151236_addKeywordsToModules',
            'm170830_223319_createBaseStructure' => 'execut\files\migrations\m170830_223319_createBaseStructure',
            'm170917_152309_addLogsTable' => 'execut\alias\migrations\m170917_152309_addLogsTable',
            'm170214_065041_addArticlesTable' => 'execut\goods\migrations\m170214_065041_addArticlesTable',
            'm180408_162536_addUrlsToGoods' => 'execut\goods\migrations\m180408_162536_addUrlsToGoods',
        ];
        $db = \yii::$app->db;
        foreach ($convertedList as $oldMigration => $newMigration) {
            if (\yii::$app->db->createCommand('SELECT count(*) FROM migration WHERE version=\'' . $newMigration . '\'')->queryScalar()) {
                continue;
            }
            echo 'apply for ' . $oldMigration . ' ' . $db->createCommand()->update('migration', ['version' => $newMigration], ['version' => $oldMigration])->execute() . "\n";
        }
    }
}