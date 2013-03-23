<?php $this->widget('DListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    'ajaxUpdate'=>false,
    'htmlOptions'=>array(
        'class'=>'list-view'
    ),
)); ?>