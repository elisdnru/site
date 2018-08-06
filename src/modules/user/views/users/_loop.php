<?php $this->widget('DListView', [
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
    'ajaxUpdate' => false,
    'htmlOptions' => [
        'class' => 'list-view'
    ],
]);
