<?php $this->reflash(); ?>
<?php $this->redirect($this->createUrl('update', array('id'=>$model->getPrimaryKey()))); ?>