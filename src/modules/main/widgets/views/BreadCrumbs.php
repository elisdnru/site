<?php if(count($breadcrumbs)) : ?>
<aside><?php $this->widget('zii.widgets.CBreadcrumbs', array('links'=>$breadcrumbs)); ?></aside>
<?php endif; ?>