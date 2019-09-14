<?php $this->widget(\DListView::class, [
    'ajaxUpdate' => false,
    'dataProvider' => $dataProvider,
    'itemView' => 'comment.views.commentAdmin._view',
]);
