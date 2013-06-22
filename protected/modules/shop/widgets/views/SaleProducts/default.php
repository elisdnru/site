<?php foreach ($items as $index=>$item): ?>
<?php $this->render('SaleProducts/_view', array('data'=>$item, 'index'=>$index)); ?>
<?php endforeach; ?>