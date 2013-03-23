<?php $this->widget('DListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    'id'=>'blogList',
    'ajaxUpdate' => false,
    'cssFile'=>false,
    'noScript'=>true,
)); ?>