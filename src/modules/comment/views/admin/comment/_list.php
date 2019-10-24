<?php
/** @var $dataProvider CDataProvider */
?>

<div class="items">
    <?php foreach ($dataProvider->getData() as $data) : ?>
        <?php $this->renderPartial('comment.views.admin.comment._view', ['data' => $data]) ?>
    <?php endforeach; ?>
</div>

<div class="pager">
    <?php Yii::app()->controller->widget('system.web.widgets.pagers.CLinkPager', [
        'pages' => $dataProvider->getPagination(),
    ]) ?>
</div>
