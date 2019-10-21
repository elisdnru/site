<?php $this->beginContent('//layouts/main');

use app\components\widgets\BreadcrumbsWidget;
use app\components\widgets\MessagesWidget; ?>
<section class="main">

    <?= BreadcrumbsWidget::widget(['links' => $this->params['breadcrumbs']]) ?>
    <?= MessagesWidget::widget() ?>

    <?php echo $content; ?>

</section>
<?php $this->endContent(); ?>
