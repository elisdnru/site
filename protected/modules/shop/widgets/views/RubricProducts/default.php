<?php foreach ($items as $index=>$item): ?>
<?php $this->render('RubricProducts/_view', array('data'=>$item, 'index'=>$index)); ?>
<?php endforeach; ?>