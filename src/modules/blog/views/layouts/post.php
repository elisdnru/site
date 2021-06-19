<?php declare(strict_types=1);

use app\widgets\Breadcrumbs;
use app\widgets\Messages;
use yii\web\View;

/**
 * @var View $this
 * @var string $content
 */
?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>

<div class="main left-main">

    <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]); ?>
    <?= Messages::widget(); ?>

    <?= $content; ?>

</div>

<aside class="sidebar right-sidebar">

    <?= $this->render('/layouts/_sidebar'); ?>

    <div class="clear bottom-marker"></div>
</aside>

<?php $this->endContent(); ?>
