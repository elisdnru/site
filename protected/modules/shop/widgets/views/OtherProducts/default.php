<?php foreach ($items as $index=>$item): ?>
<?php $this->render('OtherProducts/_view', array('data'=>$item, 'index'=>$index)); ?>
<?php endforeach; ?>