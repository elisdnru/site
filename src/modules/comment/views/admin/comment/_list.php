<?php
/** @var $dataProvider CDataProvider */
?>
<?php $this->widget(\app\components\widgets\ListView::class, [
    'dataProvider' => $dataProvider,
    'itemView' => 'comment.views.admin.comment._view',
]);
