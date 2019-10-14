<?php
/** @var $dataProvider CDataProvider */
?>
<?php $this->widget(\app\components\widgets\ListView::class, [
    'ajaxUpdate' => false,
    'dataProvider' => $dataProvider,
    'itemView' => 'comment.views.admin.comment._view',
]);
