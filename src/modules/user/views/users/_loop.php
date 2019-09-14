<?php $this->widget(\DListView::class, [
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
    'ajaxUpdate' => false,
    'htmlOptions' => [
        'class' => 'list-view'
    ],
]);
