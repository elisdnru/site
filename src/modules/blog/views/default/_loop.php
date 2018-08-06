<?php $this->widget('DListView', [
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
    'id' => 'blogList',
    'ajaxUpdate' => false,
    'cssFile' => false,
    'noScript' => true,
]);
