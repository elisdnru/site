<?php
/** @var $links array */
?>
<?php if (count($links)) : ?>
    <aside><?php Yii::app()->controller->widget('zii.widgets.CBreadcrumbs', ['links' => $links]); ?></aside>
<?php endif; ?>
