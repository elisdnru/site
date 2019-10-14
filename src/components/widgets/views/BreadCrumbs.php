<?php
/** @var $breadcrumbs array */
?>
<?php if (count($breadcrumbs)) : ?>
    <aside><?php $this->widget('zii.widgets.CBreadcrumbs', ['links' => $breadcrumbs]); ?></aside>
<?php endif; ?>
