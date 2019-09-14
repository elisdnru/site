<?php $this->widget(\DListView::class, [
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
