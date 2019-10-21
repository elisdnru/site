<?php
/** @var $dataProvider CDataProvider */

use app\components\widgets\ListView;

?>
<?php $this->widget(ListView::class, [
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
    'id' => 'worklist',
    'htmlOptions' => [
        'class' => 'list-view greed_container'
    ],
]);
