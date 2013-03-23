<?php foreach ($items as $index=>$item): ?>
<?php $this->render('LastProducts/_view', array('data'=>$item, 'index'=>$index)); ?>
<?php endforeach; ?>