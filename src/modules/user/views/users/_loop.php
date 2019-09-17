<?php $this->widget(\app\modules\main\components\widgets\ListView::class, [
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
    'ajaxUpdate' => false,
    'htmlOptions' => [
        'class' => 'list-view'
    ],
]);
