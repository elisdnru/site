<?php
use app\widgets\Breadcrumbs;
use app\widgets\Messages;
use app\modules\block\widgets\BlockWidget;
use yii\caching\TagDependency;
use yii\web\View;

/**
 * @var View $this
 * @var string $content
 */
?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>

<div class="main left_main">

    <?php if ($this->beginCache('banner_blog_top', ['dependency' => new TagDependency(['tags' => 'block'])])) : ?>
        <?= BlockWidget::widget(['id' => 'banner_blog_top']) ?>
        <?php $this->endCache(); ?>
    <?php endif; ?>

    <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
    <?= Messages::widget() ?>

    <?= $content ?>

    <?php if ($this->beginCache('banner_blog_bottom', ['dependency' => new TagDependency(['tags' => 'block'])])) : ?>
        <?= BlockWidget::widget(['id' => 'banner_blog_bottom']) ?>
        <?php $this->endCache(); ?>
    <?php endif; ?>

</div>

<aside class="sidebar right_sidebar">

    <?= $this->render('/layouts/_sidebar') ?>

    <div class="clear bottom-marker"></div>
</aside>

<?php $this->endContent(); ?>
