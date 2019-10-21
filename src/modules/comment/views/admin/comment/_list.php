<?php
/** @var $dataProvider CDataProvider */

use app\components\widgets\ListView;

?>
<?php $this->widget(ListView::class, [
    'dataProvider' => $dataProvider,
    'itemView' => 'comment.views.admin.comment._view',
]);
