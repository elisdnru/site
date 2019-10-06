<?php $this->widget(\app\components\widgets\ListView::class, [
    'ajaxUpdate' => false,
    'dataProvider' => $dataProvider,
    'itemView' => 'comment.views.commentAdmin._view',
]);
