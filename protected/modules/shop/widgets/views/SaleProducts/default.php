<?php foreach ($items as $index=>$item): ?>
<?php $this->render('PopularProducts/_view', array('data'=>$item, 'index'=>$index)); ?>
<?php endforeach; ?>