<?php
/**
 * @var \yii\web\View $this
 */
echo \yii\helpers\Html::a($model->name, [
    '/' . $this->context->uniqueId . '/view',
    'id' => $model->id,
]);