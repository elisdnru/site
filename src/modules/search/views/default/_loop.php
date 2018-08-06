<?php $this->widget('DListView', [
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
