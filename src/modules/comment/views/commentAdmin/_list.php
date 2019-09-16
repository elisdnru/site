<?php $this->widget(\app\modules\main\components\widgets\DListView::class, [
    'ajaxUpdate' => false,
    'dataProvider' => $dataProvider,
    'itemView' => 'comment.views.commentAdmin._view',
]);
