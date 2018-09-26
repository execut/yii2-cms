<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 9/17/18
 * Time: 2:44 PM
 */

namespace execut\shops\frontend;

use execut\shops\models\Shop;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ShopsController extends Controller
{
    public function actionIndex() {
        $this->addMainPage();

        $dataProvider = new ActiveDataProvider([
            'query' => Shop::find()->isVisible(),
        ]);

        return $this->render('list', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        $model = Shop::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException(\yii::t('execut/shops', 'Shop not found'));
        }

        $this->addMainPage();
        \yii::$app->navigation->addPage($this->module->getNavigationPageByShopModel($model));

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function addMainPage(): void
    {
        \yii::$app->navigation->addPage([
            'name' => \yii::t('execut/shops', 'Shops'),
            'url' => [
                '/' . $this->uniqueId . '/index',
            ],
        ]);
    }
}