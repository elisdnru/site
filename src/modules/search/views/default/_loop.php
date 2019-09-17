<?php $this->widget(\app\modules\main\components\widgets\ListView::class, [
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
    'viewData' => [
        'query' => $query,
    ],
    'id' => 'searchList',
    'ajaxUpdate' => false,
    'cssFile' => false,
    'noScript' => true,
]);
