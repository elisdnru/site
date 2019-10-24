<?php $this->beginContent('//layouts/main');

use app\components\widgets\MessagesWidget; ?>

<div class="main left_main">

    <?= MessagesWidget::widget() ?>

    <?= $content ?>

</div>

<aside class="sidebar right_sidebar">

    <?= $this->renderPartial('/layouts/_sidebar'); ?>

    <div class="clear bottom-marker"></div>
</aside>

<?php $this->endContent(); ?>
