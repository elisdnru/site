<?php $this->beginContent('@app/views/layouts/main.php');

use app\components\widgets\BreadcrumbsWidget;
use app\components\widgets\MessagesWidget; ?>

<section class="main">

    <?= BreadcrumbsWidget::widget(['links' => $this->params['breadcrumbs']]) ?>
    <?= MessagesWidget::widget() ?>

    <?= $content ?>

</section>

<?php $this->endContent(); ?>
