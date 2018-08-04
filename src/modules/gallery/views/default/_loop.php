<?php $this->widget('DListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    'id'=>'worklist',
    'afterAjaxUpdate' => 'function(){$("html, body").animate({scrollTop: $("#worklist").position().top + 250 }, 100);}',
    'htmlOptions' => array(
        'class'=>'list-view greed_container'
    ),
)); ?>
