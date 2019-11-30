<?php $this->beginContent('@app/views/layouts/main.php');

use app\widgets\BreadcrumbsWidget;
use app\widgets\MessagesWidget; ?>

<section class="main">

    <?= BreadcrumbsWidget::widget(['links' => $this->params['breadcrumbs']]) ?>
    <?= MessagesWidget::widget() ?>

    <?= $content ?>

</section>

<?php $this->endContent(); ?>
