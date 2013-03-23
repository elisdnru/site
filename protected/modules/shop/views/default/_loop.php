<?php $this->widget('DListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    'ajaxUpdate'=>false,
    'htmlOptions'=>array(
        'class'=>'list-view loop_container'
    ),
)); ?>

<script>
    jQuery("a.tocartiframe").colorbox({
        'transition' : 'none',
        'initialWidth' : 200,
        'initialHeight' : 120,
        'innerWidth' : 200,
        'innerHeight' : 120,
        'opacity' : 0.1,
        'iframe' : true
    });
</script>