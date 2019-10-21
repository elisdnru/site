<?php
/** @var $dataProvider CDataProvider */
?>
<?php $this->widget(\app\components\widgets\ListView::class, [
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
    'id' => 'worklist',
    'htmlOptions' => [
        'class' => 'list-view greed_container'
    ],
]);
