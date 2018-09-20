<?php $this->widget('DListView', [
    'ajaxUpdate' => false,
    'dataProvider' => $dataProvider,
    'itemView' => 'comment.views.commentAdmin._view',
]);
