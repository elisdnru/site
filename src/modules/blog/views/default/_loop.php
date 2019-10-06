<?php use app\components\widgets\ListView;

$this->widget(ListView::class, [
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
    'id' => 'blogList',
    'ajaxUpdate' => false,
    'cssFile' => false,
    'noScript' => true,
]);
