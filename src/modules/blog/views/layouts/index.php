<?php $this->beginContent('//layouts/main');

use app\components\widgets\BreadcrumbsWidget;
use app\components\widgets\MessagesWidget;
use app\modules\block\widgets\BlockWidget; ?>

<div class="main left_main">

    <?= BlockWidget::widget(['id' => 'banner_blog_top']) ?>

    <?= BreadcrumbsWidget::widget(['links' => $this->params['breadcrumbs']]) ?>
    <?= MessagesWidget::widget() ?>

    <?= $content ?>

    <?= BlockWidget::widget(['id' => 'banner_blog_bottom']) ?>

</div>

<aside class="sidebar right_sidebar">

    <?= $this->renderPartial('/layouts/_sidebar'); ?>

    <div class="clear bottom-marker"></div>
</aside>

<?php $this->endContent(); ?>
