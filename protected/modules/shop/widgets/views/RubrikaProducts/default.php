<?php foreach ($items as $index=>$item): ?>
<?php $this->render('RubrikaProducts/_view', array('data'=>$item, 'index'=>$index)); ?>
<?php endforeach; ?>