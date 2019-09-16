<?php $this->widget(\app\modules\main\components\widgets\DListView::class, [
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
    'id' => 'worklist',
    'noScript' => true,
    'htmlOptions' => [
        'class' => 'list-view greed_container'
    ],
]);
