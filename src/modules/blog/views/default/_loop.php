<?php $this->widget(DListView::class, [
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
    'id' => 'blogList',
    'ajaxUpdate' => false,
    'cssFile' => false,
    'noScript' => true,
]);
