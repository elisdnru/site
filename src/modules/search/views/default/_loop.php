<?php $this->widget('DListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    'viewData'=>array(
        'query'=>$query,
    ),
    'id'=>'searchList',
    'ajaxUpdate' => false,
    'cssFile'=>false,
    'noScript'=>true,
)); ?>