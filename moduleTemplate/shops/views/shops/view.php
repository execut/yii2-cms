<?php
echo \yii\widgets\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'name',
    ],
]);